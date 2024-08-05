<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il est un administrateur
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html"); // Rediriger vers la page de connexion si non autorisé
    exit();
}

// Inclure le fichier de configuration de la base de données
include '../config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Initialiser les variables pour les messages d'erreur et de succès
$error_message = '';
$success_message = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = htmlspecialchars(trim($_POST["name"]));
    $price = floatval($_POST["price"]);
    $description = htmlspecialchars(trim($_POST["description"]));
    
    // Gestion du fichier image
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        // Définir le répertoire cible pour les images
        $target_dir = "../images/";
        $target_file = $target_dir . basename($image_name);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Valider le type de fichier
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $error_message = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        } else if ($image_size > 5000000) { // Limiter la taille à 5 Mo
            $error_message = "La taille du fichier ne doit pas dépasser 5 Mo.";
        } else {
            // Déplacer le fichier téléchargé vers le répertoire cible
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                $image = "images/" . basename($image_name);
            } else {
                $error_message = "Erreur lors du téléchargement de l'image.";
            }
        }
    }

    // Validation simple
    if (empty($name) || empty($price) || empty($description)) {
        $error_message = "Tous les champs sont requis.";
    } else {
        // Préparer la requête SQL pour insérer le produit
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $name, $price, $description, $image);

        // Exécuter la requête
        if ($stmt->execute()) {
            $success_message = "Produit ajouté avec succès !";
        } else {
            $error_message = "Erreur lors de l'ajout du produit.";
        }

        // Fermer la déclaration
        $stmt->close();
    }
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Produit - Eco-Services</title>
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
                    <li class="nav-item active">
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
        <h2 class="text-center mb-4">Ajouter un Nouveau Produit</h2>
        <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nom du Produit</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" required>
            </div>
            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix du produit" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description du produit" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="manage_products.php" class="btn btn-secondary">Retour</a>
        </form>
    </main>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
