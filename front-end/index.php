<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Eco-Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Ajout de styles personnalisés */
        .hero {
            position: relative;
            background: url('images/eco-banner.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            height: 400px; /* Ajuster la hauteur selon besoin */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Couche sombre pour améliorer la lisibilité du texte */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3rem; /* Taille de police plus grande */
            font-weight: bold;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.5rem; /* Taille de police plus grande pour le sous-titre */
            margin-bottom: 0;
        }

        .info-section h2 {
            color: #28a745; /* Vert écoresponsable */
            margin-bottom: 1rem;
            text-align: center; /* Centrer le titre */
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .products, .services {
            position: relative;
            overflow: hidden;
        }

        .products img, .services img {
            max-width: 80%; /* Réduire la taille des images */
            height: auto;
            margin-top: 2rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .products .btn, .services .btn {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.jpg" alt="Eco-Services Logo" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="profile.php">Profil</a>
                            <a class="dropdown-item" href="?logout=true">Déconnexion</a>
                        </div>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenue chez Eco-Services</h1>
            <p>Votre partenaire pour une vie plus verte</p>
        </div>
    </section>

    <section class="container py-5">
        <div class="info-section">
            <h2>Présentation de la démarche zéro déchet</h2>
            <p>Chez Eco-Services, nous sommes profondément engagés dans la promotion d'un mode de vie durable à travers notre démarche zéro déchet. Notre objectif est de vous accompagner dans la réduction de votre empreinte écologique en adoptant des pratiques simples mais efficaces qui minimisent la production de déchets. En adoptant une approche zéro déchet, nous visons à transformer la manière dont nous consommons, produisons et éliminons les biens.</p>

            <p>Le concept zéro déchet repose sur cinq principes fondamentaux : réduire, réutiliser, recycler, composter et refuser. Voici comment nous appliquons ces principes :</p>
            
            <ul>
                <li><strong>Réduire :</strong> La première étape pour atteindre un mode de vie zéro déchet est de réduire la quantité de déchets que nous produisons. Cela implique d'acheter moins de produits emballés, de privilégier les produits durables et de choisir des articles de qualité qui dureront plus longtemps.</li>
                <li><strong>Réutiliser :</strong> La réutilisation est essentielle pour minimiser les déchets. Nous encourageons la réparation des objets cassés, l'utilisation de contenants réutilisables et la mise en place de systèmes de consigne. Réutiliser les produits et matériaux permet de prolonger leur durée de vie et de diminuer la demande de nouveaux biens.</li>
                <li><strong>Recycler :</strong> Le recyclage est une partie importante de la gestion des déchets, mais il ne doit être considéré qu'après avoir réduit et réutilisé autant que possible. Nous offrons des conseils sur la manière de trier correctement les matériaux recyclables et de participer activement aux programmes de recyclage locaux.</li>
                <li><strong>Composter :</strong> Le compostage permet de transformer les déchets organiques, tels que les restes de nourriture et les déchets de jardin, en compost fertile. Ce processus réduit les déchets envoyés aux décharges et fournit un enrichissement naturel pour le sol.</li>
                <li><strong>Refuser :</strong> Parfois, la meilleure option est de refuser les produits ou emballages inutiles. Nous encourageons nos clients à dire non aux articles jetables, aux plastiques à usage unique et aux produits qui ne sont pas conçus pour être durables.</li>
            </ul>

            <p>Notre démarche zéro déchet n'est pas seulement une philosophie, mais un mode de vie que nous souhaitons partager avec vous. Nous proposons des ateliers éducatifs, des consultations personnalisées et une gamme de produits écoresponsables pour vous aider à intégrer ces pratiques dans votre quotidien. En travaillant ensemble, nous pouvons faire une différence significative pour notre planète et créer un avenir plus durable.</p>
            
            <p>Rejoignez-nous dans ce mouvement et découvrez comment vous pouvez contribuer à la réduction des déchets et à la protection de notre environnement. Pour en savoir plus sur nos initiatives et obtenir des conseils pratiques, n'hésitez pas à explorer nos ressources et à nous contacter.</p>
            
            <img src="images/zero-waste.jpg" alt="Démarche Zéro Déchet" class="img-fluid">
        </div>
    </section>

    <section class="products py-5 text-center">
        <div class="container">
            <h2>Produits Écoresponsables</h2>
            <a href="products.php" class="btn btn-primary">Voir nos produits</a>
            <img src="images/products-image.jpg" alt="Produits Écoresponsables" class="img-fluid mt-4">
        </div>
    </section>

    <section class="services bg-light py-5 text-center">
        <div class="container">
            <h2>Services pour Professionnels</h2>
            <a href="services.php" class="btn btn-primary">Demander un devis</a>
            <img src="images/services-image.jpg" alt="Services pour Professionnels" class="img-fluid mt-4">
        </div>
    </section>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
