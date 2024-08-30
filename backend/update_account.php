<?php
require_once 'config.php';
require_once 'auth.php';

$user = authenticateUser($conn);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$newUsername = isset($data['newUsername']) ? mysqli_real_escape_string($conn, $data['newUsername']) : null;
$newEmail = isset($data['newEmail']) ? mysqli_real_escape_string($conn, $data['newEmail']) : null;
$newPassword = isset($data['newPassword']) ? $data['newPassword'] : null;

$updateFields = [];
if ($newUsername) $updateFields[] = "username = '$newUsername'";
if ($newEmail) $updateFields[] = "email = '$newEmail'";
if ($newPassword) $updateFields[] = "password = '" . password_hash($newPassword, PASSWORD_DEFAULT) . "'";

if (empty($updateFields)) {
    echo json_encode(['success' => false, 'message' => 'Aucune information à mettre à jour']);
    exit;
}

$updateQuery = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = " . $user['id'];

if (mysqli_query($conn, $updateQuery)) {
    echo json_encode(['success' => true, 'message' => 'Informations mises à jour avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des informations']);
}
?>