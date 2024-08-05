<?php
session_start(); // Démarrer la session

// Vérifier si la demande de déconnexion est faite
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset(); // Détruire toutes les variables de session
    session_destroy(); // Détruire la session
    header("Location: index.php"); // Redirection vers la page d'accueil après déconnexion
    exit();
}

// Gérer les messages d'alerte
$alert_message = '';
if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case 'login_required':
            $alert_message = 'Vous devez être connecté pour demander un devis.';
            break;
        case 'invalid_request':
            $alert_message = 'Demande invalide.';
            break;
        case 'quote_request_success':
            $alert_message = 'Votre demande de devis a été envoyée avec succès.';
            break;
        case 'quote_request_failed':
            $alert_message = 'Échec de l\'envoi de votre demande de devis.';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Eco-Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.jpg" alt="Eco-Services Logo" width="150">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Produits</a>
                    </li>
                    <li class="nav-item active">
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
                            <a class="dropdown-item" href="services.php?logout=true">Déconnexion</a>
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

    <main class="container py-5">
        <h2 class="text-center mb-4 title-services">Nos Services</h2>

        <?php if ($alert_message): ?>
        <div class="alert alert-info text-center">
            <?php echo htmlspecialchars($alert_message); ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/service1.jpg" class="card-img-top" alt="Consultation en Gestion des Déchets">
                    <div class="card-body">
                        <h5 class="card-title">Consultation en Gestion des Déchets</h5>
                        <p class="card-text">Notre service de consultation vous aide à élaborer des stratégies efficaces pour la gestion des déchets, réduisant ainsi l'impact environnemental de vos activités.</p>
                        <?php if (isset($_SESSION['username'])): ?>
                        <a href="quote_request.php?service_id=1" class="btn btn-primary">Demander un devis</a>
                        <?php else: ?>
                        <button class="btn btn-secondary" disabled>Demander un devis</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/service2.jpg" class="card-img-top" alt="Programme de Recyclage sur Mesure">
                    <div class="card-body">
                        <h5 class="card-title">Programme de Recyclage sur Mesure</h5>
                        <p class="card-text">Nous développons des programmes de recyclage personnalisés pour répondre aux besoins spécifiques de votre entreprise, facilitant la transition vers des pratiques plus durables.</p>
                        <?php if (isset($_SESSION['username'])): ?>
                        <a href="quote_request.php?service_id=2" class="btn btn-primary">Demander un devis</a>
                        <?php else: ?>
                        <button class="btn btn-secondary" disabled>Demander un devis</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/service3.jpg" class="card-img-top" alt="Formation et Sensibilisation">
                    <div class="card-body">
                        <h5 class="card-title">Formation et Sensibilisation</h5>
                        <p class="card-text">Nous proposons des formations et des ateliers de sensibilisation pour aider votre personnel à adopter des pratiques écologiques et à mieux comprendre l'importance de la gestion des déchets.</p>
                        <?php if (isset($_SESSION['username'])): ?>
                        <a href="quote_request.php?service_id=3" class="btn btn-primary">Demander un devis</a>
                        <?php else: ?>
                        <button class="btn btn-secondary" disabled>Demander un devis</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
