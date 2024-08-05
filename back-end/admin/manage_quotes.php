<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il est un administrateur
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html"); // Rediriger vers la page de connexion si non autorisé
    exit();
}

// Gérer la déconnexion
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset(); // Détruire toutes les variables de session
    session_destroy(); // Détruire la session
    header("Location: ../../front-end/index.php"); // Rediriger vers la page d'accueil après déconnexion
    exit();
}

// Inclure le fichier de configuration de la base de données
include '../config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Suppression d'une demande de devis
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM quotes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "Demande de devis supprimée avec succès !";
    } else {
        $message = "Erreur lors de la suppression de la demande de devis.";
    }
    $stmt->close();
}

// Récupération des demandes de devis
$result = $conn->query("SELECT * FROM quotes");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Devis - Eco-Services</title>
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
                    <li class="nav-item">
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
                    <li class="nav-item active">
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
        <h2 class="text-center mb-4">Gérer les Demandes de Devis</h2>
        <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande de devis ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
