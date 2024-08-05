<?php
session_start();

// Inclure le fichier de configuration de la base de données
include '../back-end/config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = intval($_GET['product_id']);
    $quantity = intval($_GET['quantity']);
    
    if ($quantity > 0) {
        // Ajouter ou mettre à jour le produit dans le panier
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
        // Mettre à jour la quantité du produit
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
        
        // Redirection avec message d'alerte
        header("Location: products.php?alert=added&product_id=$product_id");
        exit();
    } else {
        // Quantité invalide
        header("Location: products.php?alert=invalid_quantity");
        exit();
    }
} else {
    // Paramètres manquants
    header("Location: products.php?alert=error");
    exit();
}
?>
