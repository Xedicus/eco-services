<?php
// Inclure le fichier de configuration de la base de données
include '../back-end/config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Fonction pour nettoyer les données entrantes
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    
    // Validation simple pour le nom d'utilisateur et le mot de passe
    if (empty($username) || empty($password)) {
        echo "Le nom d'utilisateur et le mot de passe sont requis.";
        exit();
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête SQL
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $username, $hashed_password);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: login.html");
        exit();
    } else {
        echo "Erreur lors de l'inscription. Veuillez réessayer.";
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non valide.";
}
?>
