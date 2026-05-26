<?php
require_once __DIR__ . '/includes/auth_middleware.php';
require_role(['client', 'agency', 'admin'], 'login.php');
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/config/database.php';

$destinations = [];
$transports = [];
$hebergements = [];
$activites = [];

try {
    $db = get_database_connection();
    $destinations = $db->query('SELECT id, name, country FROM destinations ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    $transports = $db->query('SELECT id, type, company, price, available FROM transports ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    $hebergements = $db->query('SELECT id, name, price_night FROM hebergements ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    $activites = $db->query('SELECT id, name, price_person FROM activites ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    // Lists remain empty if tables are not migrated yet.
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test reservation - VoyageVista</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="container py-5">
        <h1 class="h3 mb-3">Test reservation confirmation API</h1>
        <p class="text-muted">This form posts to <code>api/confirm_reservation.php</code> and should create a reservation + notification.</p>

        <form action="api/confirm_reservation.php" method="POST" class="card p-4">
            <?php echo csrf_input_field(); ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="destination_id">Destination</label>
                    <select class="form-select" name="destination_id" id="destination_id" required>
                        <option value="">Choose destination</option>
                        <?php foreach ($destinations as $d): ?>
                            <option value="<?php echo (int)$d['id']; ?>"><?php echo htmlspecialchars($d['name'] . ' (' . $d['country'] . ')', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="check_in">Check-in</label>
                    <input type="date" class="form-control" id="check_in" name="check_in" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="check_out">Check-out</label>
                    <input type="date" class="form-control" id="check_out" name="check_out" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="travelers">Travelers</label>
                    <input type="number" min="1" class="form-control" id="travelers" name="travelers" value="1" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="transport_id">Transport (optional)</label>
                    <select class="form-select" name="transport_id" id="transport_id">
                        <option value="">None</option>
                        <?php foreach ($transports as $t): ?>
                            <option value="<?php echo (int)$t['id']; ?>">
                                <?php echo htmlspecialchars('#' . $t['id'] . ' ' . $t['type'] . ' ' . ($t['company'] ?? '') . ' - ' . $t['price'] . ' EUR (avail: ' . $t['available'] . ')', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="hebergement_id">Accommodation (optional)</label>
                    <select class="form-select" name="hebergement_id" id="hebergement_id">
                        <option value="">None</option>
                        <?php foreach ($hebergements as $h): ?>
                            <option value="<?php echo (int)$h['id']; ?>">
                                <?php echo htmlspecialchars('#' . $h['id'] . ' ' . $h['name'] . ' - ' . $h['price_night'] . ' EUR/night', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="activity_id">Activity (optional)</label>
                    <select class="form-select" name="activity_id" id="activity_id">
                        <option value="">None</option>
                        <?php foreach ($activites as $a): ?>
                            <option value="<?php echo (int)$a['id']; ?>">
                                <?php echo htmlspecialchars('#' . $a['id'] . ' ' . $a['name'] . ' - ' . $a['price_person'] . ' EUR/person', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="payment_number">Payment number (simulated)</label>
                    <input type="text" class="form-control" id="payment_number" name="payment_number" placeholder="4111111111111111" required>
                    <div class="form-text">Not stored in full; only last 4 digits are saved.</div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Confirm reservation</button>
        </form>
    </main>
</body>
</html>
