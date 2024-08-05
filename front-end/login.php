<?php
session_start(); // Démarrer la session

// Inclure le fichier de configuration de la base de données
include '../back-end/config/db.php'; // Assurez-vous que ce chemin est correct pour votre projet

// Fonction pour nettoyer les données entrantes
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);

    // Validation simple pour le nom d'utilisateur et le mot de passe
    if (empty($username) || empty($password)) {
        header("Location: login.html?message=login_failed"); // Redirection avec message d'erreur
        exit();
    }

    // Préparer la requête SQL pour récupérer l'utilisateur
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $stored_password, $role);
        $stmt->fetch();

        // Vérifier le mot de passe sans hashage
        if ($password === $stored_password) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirection en fonction du rôle de l'utilisateur
            if ($role === 'admin') {
                header("Location: ../back-end/admin/admin_dashboard.php");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            header("Location: login.html?message=login_failed"); // Redirection avec message d'erreur
        }
    } else {
        header("Location: login.html?message=login_failed"); // Redirection avec message d'erreur
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non valide.";
}
?>
