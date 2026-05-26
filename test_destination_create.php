<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/includes/security_headers.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test destination create - VoyageVista</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm p-4">
                    <h1 class="h4 mb-3">Test API destination_create.php</h1>
                    <p class="text-muted mb-4">
                        This page generates a valid CSRF token automatically. Fill the form and submit it to test the endpoint.
                    </p>

                    <form action="api/destination_create.php" method="POST">
                        <?php echo csrf_input_field(); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Destination name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country ISO code (Europe only)</label>
                            <input type="text" class="form-control" id="country" name="country" maxlength="2" placeholder="FR" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image path (optional)</label>
                            <input type="text" class="form-control" id="image" name="image" placeholder="assets/images/paris.jpg">
                            <div class="form-text">Leave empty to store an empty string for now.</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit test</button>
                    </form>

                    <hr class="my-4">

                    <p class="mb-2"><strong>Expected success:</strong> JSON response like <code>{"success":true,"id":123}</code></p>
                    <p class="mb-0"><strong>Expected failure:</strong> if the country is not in Europe, you should get a JSON error.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
