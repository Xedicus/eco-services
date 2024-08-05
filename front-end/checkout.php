<?php
session_start(); // Démarrer la session

// Inclure le fichier de configuration de la base de données
include '../back-end/config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Vérifier si une demande de mise à jour de quantité a été envoyée
if (isset($_POST['update_quantity'])) {
    $productId = intval($_POST['product_id']);
    $newQuantity = intval($_POST['quantity']);

    // Mettre à jour la quantité dans le panier de la session
    if ($newQuantity > 0) {
        $_SESSION['cart'][$productId] = $newQuantity;
    } else {
        unset($_SESSION['cart'][$productId]);
    }

    // Recalculer le panier
    header("Location: checkout.php");
    exit();
}

// Récupérer le panier de l'utilisateur depuis la session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Récupérer les détails des produits dans le panier
$products = [];
$total = 0;
if (!empty($cart)) {
    $productIds = implode(',', array_keys($cart));
    $query = "SELECT * FROM products WHERE id IN ($productIds)";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['quantity'] = $cart[$row['id']];
            $row['total_price'] = $row['quantity'] * $row['price'];
            $total += $row['total_price'];
            $products[] = $row;
        }
    } else {
        die("Erreur de requête : " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des Achats - Eco-Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .quantity-input {
            width: 60px;
            text-align: center;
        }
    </style>
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
        <h2 class="text-center mb-4">Récapitulatif de vos Achats</h2>
        <?php if (empty($products)): ?>
            <p class="text-center">Votre panier est vide.</p>
        <?php else: ?>
        <form method="POST" action="checkout.php">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?>€</td>
                        <td>
                            <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" class="form-control quantity-input">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($product['total_price']); ?>€</td>
                        <td>
                            <button type="submit" name="update_quantity" class="btn btn-primary btn-sm">Mettre à jour</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td><strong><?php echo htmlspecialchars($total); ?>€</strong></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div class="text-center">
            <a href="confirm_purchase.php" class="btn btn-danger btn-lg">Confirmer l'achat</a>
            <a href="products.php" class="btn btn-secondary">Retour aux produits</a>
        </div>
        <?php endif; ?>
    </main>

    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Eco-Services. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
