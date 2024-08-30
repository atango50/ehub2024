<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once 'config.php';
require_once 'send_email.php';  // Inclure le fichier d'envoi d'email

header('Content-Type: application/json');

// Activez le reporting d'erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : null;
    $firstname = isset($_POST['firstName']) ? mysqli_real_escape_string($conn, $_POST['firstName']) : null;
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : null;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $project_name = isset($_POST['projectName']) ? mysqli_real_escape_string($conn, $_POST['projectName']) : null;
    $project_date = isset($_POST['projectCreationDate']) ? mysqli_real_escape_string($conn, $_POST['projectCreationDate']) : null;
    $category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : null;

    // Vérification des données obligatoires
    if (!$username || !$firstname || !$gender || !$email || !$password || !$project_name || !$project_date || !$category) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    // Gestion du fichier vidéo
    $video_path = '';
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $allowed = array('mp4');
        $filename = $_FILES['video']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed) && $_FILES['video']['size'] <= 3000000) {
            $video_path = 'uploads/' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Le fichier vidéo doit être au format MP4 et ne pas dépasser 3 Mo.']);
            exit;
        }
    }

    // Vérifier si le nom d'utilisateur existe déjà
    $check_username = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($check_username, "s", $username);
    mysqli_stmt_execute($check_username);
    mysqli_stmt_store_result($check_username);

    if (mysqli_stmt_num_rows($check_username) > 0) {
        echo json_encode(['success' => false, 'message' => 'Le nom d\'utilisateur est déjà pris.']);
        exit;
    }

    mysqli_stmt_close($check_username);

    // Générer le code de vérification
    $verification_code = rand(100000, 999999);

    // Insertion des données dans la base
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, firstname, gender, email, password, project_name, project_date, category, video_path, verification_code) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssssssss", $username, $firstname, $gender, $email, $password, $project_name, $project_date, $category, $video_path, $verification_code);

    if (mysqli_stmt_execute($stmt)) {
        // Appeler la fonction sendEmail pour envoyer le code de vérification par email
        $subject = "Votre code de vérification";
        $message = "Bonjour $firstname,\n\nVotre code de vérification est : $verification_code.\n\nMerci.";
        
        if (sendEmail($email, $subject, $message)) {
            echo json_encode([
                "success" => true, 
                "message" => "Inscription réussie. Veuillez vérifier votre email pour le code de vérification.",
                "redirect" => "../frontend/verify.php"
            ]);
        } else {
            echo json_encode([
                "success" => true, 
                "message" => "Inscription réussie, mais l'envoi du mail a échoué. Veuillez vérifier manuellement.",
                "redirect" => "verify.php"
            ]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription: " . mysqli_error($conn)]);
    }
}

mysqli_close($conn);
?>
