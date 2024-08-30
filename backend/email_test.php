<?php
require_once 'send_email.php';

// Paramètres de test
$to = 'missiserg@yahoo.fr'; // Remplacez par votre adresse e-mail
$subject = 'Test d\'envoi d\'e-mail';
$body = '<h1>Ceci est un test</h1><p>Si vous voyez cet e-mail, l\'envoi fonctionne correctement.</p>';
$altBody = 'Ceci est un test. Si vous voyez cet e-mail, l\'envoi fonctionne correctement.';

// Tentative d'envoi d'e-mail
$result = sendEmail($to, $subject, $body, $altBody);

if ($result) {
    echo "L'e-mail a été envoyé avec succès.";
} else {
    echo "L'envoi de l'e-mail a échoué. Vérifiez les logs pour plus de détails.";
}
?>
