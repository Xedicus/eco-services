<?php
session_start(); // Démarrer la session

// Vérifier si la demande de déconnexion est faite
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset(); // Détruire toutes les variables de session
    session_destroy(); // Détruire la session
    header("Location: ../../front-end/index.php"); // Redirection vers la page d'accueil du front-end
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Eco-Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <a class="navbar-brand" href="admin_dashboard.php">
                <img src="../../front-end/images/logo.jpg" alt="Eco-Services Logo" width="150">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Gérer Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_services.php">Gérer Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_orders.php">Gérer Commandes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_quotes.php">Gérer Devis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Gérer Utilisateurs</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?logout=true">Déconnexion</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <h2 class="text-center">Tableau de Bord</h2>
        <p class="text-center">Bienvenue dans l'interface d'administration.</p>
    </main>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
