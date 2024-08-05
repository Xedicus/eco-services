<?php
session_start(); // Démarrer la session

// Inclure le fichier de configuration de la base de données
include '../back-end/config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Vérifier si la demande de déconnexion est faite
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset(); // Détruire toutes les variables de session
    session_destroy(); // Détruire la session
    header("Location: index.php"); // Redirection vers la page d'accueil après déconnexion
    exit();
}

// Récupérer les produits depuis la base de données
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Erreur de requête : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - Eco-Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item active">
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
                            <a class="dropdown-item" href="products.php?logout=true">Déconnexion</a>
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
    <h2 class="text-center mb-4 title-catalogue">Catalogue des Produits</h2>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="card-text"><strong>Prix : <?php echo htmlspecialchars($row['price']); ?>€</strong></p>
                    </div>
                    <div class="card-footer">
                        <form action="add_to_cart.php" method="GET">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <div class="form-group quantity-wrapper">
                                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1, '<?php echo $row['id']; ?>')">-</button>
                                <input type="number" id="quantity<?php echo $row['id']; ?>" name="quantity" class="quantity-input" min="1" value="1">
                                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1, '<?php echo $row['id']; ?>')">+</button>
                            </div>
                            <?php if (isset($_SESSION['username'])): ?>
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            <?php else: ?>
                            <button class="btn btn-secondary" disabled>Ajouter au panier</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <!-- Bouton Valider vos achats centré en bas de la page -->
        <div class="text-center mt-4">
            <a href="checkout.php" class="btn btn-validation">Valider vos achats</a>
        </div>
    </main>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Fonction pour ajuster la quantité
        function changeQuantity(change, id) {
            var quantityInput = document.getElementById('quantity' + id);
            var currentValue = parseInt(quantityInput.value);
            var newValue = currentValue + change;
            if (newValue > 0) {
                quantityInput.value = newValue;
            }
        }
    </script>
</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
