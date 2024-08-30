<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Si vous utilisez Composer

function sendEmail($to, $subject, $body, $altBody = '', $from = 'noreply@yourdomain.com') {
    $mail = new PHPMailer(true);  // Instancie la classe PHPMailer avec gestion des exceptions

    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();                                      // On va utiliser SMTP
        $mail->Host = 'smtp.gmail.com';                       // Spécifiez le serveur SMTP principal (ici Gmail)
        $mail->SMTPAuth = true;                               // Activer l'authentification SMTP
        $mail->Username = 'atanga00@gmail.com';             // Adresse email SMTP
        $mail->Password = 'wvxhefhyonkrzaun';              // Mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Activer le cryptage TLS (PHPMailer::ENCRYPTION_SMTPS pour SSL)
        $mail->Port = 587;                                    // Port TCP pour se connecter (587 pour TLS, 465 pour SSL)

        // Expéditeur et destinataire
        $mail->setFrom($from, '1xbet ehub');
        $mail->addAddress($to);                               // Ajouter un destinataire

        // Contenu de l'email
        $mail->isHTML(true);                                  // Définir l'email au format HTML
        $mail->Subject = $subject;                            // Sujet de l'email
        $mail->Body    = $body;                               // Corps de l'email en HTML
        $mail->AltBody = $altBody;                            // Corps de l'email en texte brut (pour les clients email sans support HTML)

        $mail->send();
        return true; // Si l'email est envoyé avec succès
    } catch (Exception $e) {
        // En cas d'erreur, vous pouvez loguer l'erreur ou l'afficher
        error_log("L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}");
        return false;
    }
}
?>
