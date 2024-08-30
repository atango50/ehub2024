<?php
require_once 'config.php';
require_once 'auth.php';

$user = authenticateUser($conn);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit;
}

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $_FILES['avatar']['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Format de fichier non autorisé']);
        exit;
    }

    $uploadDir = '../frontend/assets/img/avatar/avatar.jpg';
    $newFilename = uniqid() . '.' . $ext;
    $uploadFile = $uploadDir . $newFilename;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
        $avatarUrl = '/avatars/' . $newFilename;
        $updateQuery = "UPDATE users SET avatar_url = '$avatarUrl' WHERE id = " . $user['id'];
        
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(['success' => true, 'message' => 'Avatar mis à jour avec succès', 'avatarUrl' => $avatarUrl]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'avatar dans la base de données']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement de l\'avatar']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier téléchargé ou erreur de téléchargement']);
}
?>