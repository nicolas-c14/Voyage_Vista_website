<?php
require_once __DIR__ . "/../config/database.php";

/* =========================
   ADD TO CART
========================= */
function addToCart(
    $userId,
    $accommodationId,
    $checkIn,
    $checkOut,
    $persons
) {
    global $pdo;
    /* =========================
    Check si déjà présent (même hébergement + mêmes dates)
    ========================= */
    $check = $pdo->prepare(
        "SELECT id
         FROM cart_items
         WHERE user_id = ?
           AND accommodation_id = ?
           AND check_in = ?
           AND check_out = ?"
    );
    $check->execute([
        $userId,
        $accommodationId,
        $checkIn,
        $checkOut
    ]);
    $existing = $check->fetch();
    if ($existing) {
        /* Met à jour le nombre de personnes */
        $stmt = $pdo->prepare(
            "UPDATE cart_items
             SET persons = ?
             WHERE id = ?"
        );
        return $stmt->execute([
            $persons,
            $existing["id"]
        ]);
    }
    /* Sinon insertion */
    $stmt = $pdo->prepare(
        "INSERT INTO cart_items
        (
            user_id,
            accommodation_id,
            check_in,
            check_out,
            persons
        )
        VALUES (?, ?, ?, ?, ?)"
    );
    return $stmt->execute([
        $userId,
        $accommodationId,
        $checkIn,
        $checkOut,
        $persons
    ]);
}

/* =========================
   GET CART ITEMS
========================= */
function getCartItems($userId) {
    global $pdo;
    $stmt = $pdo->prepare(
        "SELECT
            cart_items.*,
            accommodations.name
            AS accommodation_name,
            accommodations.type,
            accommodations.image,
            accommodations.price_per_night,
            destinations.name
            AS destination_name,
            destinations.country,
            DATEDIFF(cart_items.check_out, cart_items.check_in)
            AS nights,
            (DATEDIFF(cart_items.check_out, cart_items.check_in)
                * accommodations.price_per_night
                * cart_items.persons)
            AS subtotal
        FROM cart_items
        INNER JOIN accommodations
            ON cart_items.accommodation_id =
               accommodations.id
        INNER JOIN destinations
            ON accommodations.destination_id =
               destinations.id
        WHERE cart_items.user_id = ?
        ORDER BY cart_items.added_at DESC"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* =========================
   GET CART COUNT
========================= */
function getCartCount($userId) {
    global $pdo;
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) AS nb
         FROM cart_items
         WHERE user_id = ?"
    );
    $stmt->execute([$userId]);
    $row = $stmt->fetch();
    return (int) $row["nb"];
}

/* =========================
   GET CART TOTAL
========================= */
function getCartTotal($userId) {
    global $pdo;
    $stmt = $pdo->prepare(
        "SELECT
            COALESCE(SUM(
                DATEDIFF(cart_items.check_out, cart_items.check_in)
                * accommodations.price_per_night
                * cart_items.persons
            ), 0) AS total
        FROM cart_items
        INNER JOIN accommodations
            ON cart_items.accommodation_id =
               accommodations.id
        WHERE cart_items.user_id = ?"
    );
    $stmt->execute([$userId]);
    $row = $stmt->fetch();
    return (float) $row["total"];
}

/* =========================
   UPDATE CART ITEM
========================= */
function updateCartItem(
    $itemId,
    $userId,
    $checkIn,
    $checkOut,
    $persons
) {
    global $pdo;
    $stmt = $pdo->prepare(
        "UPDATE cart_items
         SET check_in = ?,
             check_out = ?,
             persons = ?
         WHERE id = ?
           AND user_id = ?"
    );
    return $stmt->execute([
        $checkIn,
        $checkOut,
        $persons,
        $itemId,
        $userId
    ]);
}

/* =========================
   REMOVE FROM CART
========================= */
function removeFromCart($itemId, $userId) {
    global $pdo;
    $stmt = $pdo->prepare(
        "DELETE FROM cart_items
         WHERE id = ?
           AND user_id = ?"
    );
    return $stmt->execute([
        $itemId,
        $userId
    ]);
}

/* =========================
   CLEAR CART
========================= */
function clearCart($userId) {
    global $pdo;
    $stmt = $pdo->prepare(
        "DELETE FROM cart_items
         WHERE user_id = ?"
    );
    return $stmt->execute([$userId]);
}

/* =========================
   CHECKOUT : panier -> reservations
========================= */
function checkoutCart($userId) {
    global $pdo;
    $items = getCartItems($userId);
    if (count($items) === 0) {
        return false;
    }
    try {
        $pdo->beginTransaction();
        foreach ($items as $item) {
            $stmt = $pdo->prepare(
                "INSERT INTO reservations
                (
                    user_id,
                    accommodation_id,
                    check_in,
                    check_out,
                    persons,
                    total_price
                )
                VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $userId,
                $item["accommodation_id"],
                $item["check_in"],
                $item["check_out"],
                $item["persons"],
                $item["subtotal"]
            ]);
        }
        clearCart($userId);
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}
?>