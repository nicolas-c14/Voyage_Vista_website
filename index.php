<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoyageVista</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'includes/navbar.php'; ?>

    <!-- HERO SECTION -->
    <section class="hero-section">

        <div class="hero-overlay"></div>

        <div class="container hero-content text-center">

            <h1 class="display-4 fw-bold">
                Explorez le monde avec VoyageVista
            </h1>

            <p class="lead">
                Réservez vos destinations, hôtels et activités en quelques clics.
            </p>

            <!-- SEARCH BAR -->
            <div class="search-box mt-4">

                <form id="searchForm" class="row g-2 justify-content-center">

                    <div class="col-md-5">
                        <input type="text"
                            id="searchInput"
                            class="form-control form-control-lg"
                            placeholder="Rechercher une destination">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary btn-lg" type="submit">
                            Rechercher
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </section>

    <!-- DESTINATIONS -->
    <section class="container my-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Destinations populaires</h2>
            <p>Choisissez votre prochaine aventure.</p>
        </div>

        <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-md-4">

                <div class="card destination-card h-100">

                    <img src="assets/images/paris.jpg"
                        class="card-img-top"
                        alt="Paris">

                    <div class="card-body">

                        <h5 class="card-title">
                            Paris, France
                        </h5>

                        <p class="card-text">
                            Découvrez la ville de l’amour et ses monuments emblématiques.
                        </p>

                        <a href="destinations.php" class="btn btn-outline-primary">
                            Découvrir
                        </a>

                    </div>

                </div>

            </div>

            <!-- CARD 2 -->
            <div class="col-md-4">

                <div class="card destination-card h-100">

                    <img src="assets/images/london.jpg"
                        class="card-img-top"
                        alt="Londres">

                    <div class="card-body">

                        <h5 class="card-title">
                            Londres, Royaume-Uni
                        </h5>

                        <p class="card-text">
                            Explorez la capitale britannique et sa culture unique.
                        </p>

                        <a href="destinations.php" class="btn btn-outline-primary">
                            Découvrir
                        </a>

                    </div>

                </div>

            </div>

            <!-- CARD 3 -->
            <div class="col-md-4">

                <div class="card destination-card h-100">

                    <img src="assets/images/barcelone.jpg"
                        class="card-img-top"
                        alt="Barcelone">

                    <div class="card-body">

                        <h5 class="card-title">
                            Barcelone, Espagne
                        </h5>

                        <p class="card-text">
                            Découvrez l’architecture et les plages de Barcelone.
                        </p>

                        <a href="destinations.php" class="btn btn-outline-primary">
                            Découvrir
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ABOUT US -->
    <section class="container my-5">
        <div class="row align-items-center g-4">

            <div class="col-md-6">
                <img src="assets/images/about.jpg" class="img-fluid rounded" alt="About Us">
            </div>

            <div class="col-md-6">
                <h2 class="fw-bold">À propos de VoyageVista</h2>
                <p>VoyageVista est votre partenaire de confiance pour toutes vos aventures de voyage. Nous offrons une plateforme facile à utiliser pour réserver des destinations, des hôtels et des activités dans le monde entier. Notre mission est de rendre le voyage accessible et agréable pour tous, en fournissant des offres compétitives et un service client exceptionnel.</p>
                <a href="#" class="btn btn-primary">
                    En savoir plus
                </a>
            </div>

        </div>
    </section>

    <!-- CONTACT -->
    <section class="container my-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Contactez-nous</h2>
            <p>Nous sommes là pour vous aider à planifier votre prochain voyage.</p>
        </div>

        <!-- CONTACT FORM -->
        <form id="contactForm" class="row g-4 justify-content-center">

            <div class="col-md-6">
                <input type="text" id="contactName" class="form-control form-control-lg" placeholder="Votre nom" required>
            </div>

            <div class="col-md-6">
                <input type="email" id="contactEmail" class="form-control form-control-lg" placeholder="Votre email" required>
            </div>

            <div class="col-12">
                <textarea class="form-control form-control-lg" rows="5" placeholder="Votre message" required></textarea>
            </div>

            <div class="col-12 text-center">
                <button class="btn btn-primary btn-lg" type="submit">
                    Envoyer
                </button>
            </div>
        </form>
    </section>


    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- JS -->
    <script src="assets/js/script.js"></script>

</body>

</html>