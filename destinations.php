<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - VoyageVista</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'includes/navbar.php'; ?>

    <!-- DESTINATIONS -->
    <div class="container py-5">

        <h1 class="text-center mb-5">
            Choisissez votre destination
        </h1>

        <!-- PRESENTATIONS CARDS -->
        <div class="row g-4">

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/paris.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Paris</h5>
                        <p>France</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/london.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Londres</h5>
                        <p>Royaume-Uni</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/barcelone.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Barcelone</h5>
                        <p>Espagne</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/rome.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Rome</h5>
                        <p>Italie</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/newyork.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>New York</h5>
                        <p>États-Unis</p>
                    </div>
                </div>  
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/tokyo.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Tokyo</h5>
                        <p>Japon</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/sydney.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Sydney</h5>
                        <p>Australie</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card destination-card">
                    <img src="assets/images/capetown.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5>Le Cap</h5>
                        <p>Afrique du Sud</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

</body>

</html>