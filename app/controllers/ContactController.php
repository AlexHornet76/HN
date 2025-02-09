<?php
require_once 'PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController {
    public static function index() {
        require_once "app/views/contact/index.php";
    }

    public static function send() {
        $message = htmlspecialchars($_POST['mess'], ENT_QUOTES, 'UTF-8');
        $to = "your_mail";
        $subject = "New Contact Form Submission";

        $mail = new PHPMailer(true);
        try {
            // Configurare server SMTP
            $mail->isSMTP();
            $mail->Host = 'your_smpt'; // Adresa serverului SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'your_mail'; // Utilizator SMTP
            $mail->Password = 'your_password'; // Parola SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Setări email
            $mail->setFrom('no-reply@example.com', 'Contact Form');
            $mail->addAddress($to);
            $mail->addReplyTo($_SESSION['request_user']['email']);

            // Conținut email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<html><body>
                           <p>You have received a new message from the contact form:</p>
                           <p><strong>Message:</strong> {$message}</p>
                           </body></html>";

            $mail->send();

            // Mesaj de confirmare pentru utilizator
            $confirmationMail = new PHPMailer(true);
            $confirmationMail->isSMTP();
            $confirmationMail->Host = 'your_smpt';
            $confirmationMail->SMTPAuth = true;
            $confirmationMail->Username = 'your_mail';
            $confirmationMail->Password = 'your_password';
            $confirmationMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $confirmationMail->Port = 587;

            $confirmationMail->setFrom('no-reply@example.com', 'Contact Form');
            $confirmationMail->addAddress($_SESSION['request_user']['email']);

            $confirmationMail->isHTML(true);
            $confirmationMail->Subject = "Contact Form Submission";
            $confirmationMail->Body = "Thank you for contacting us! We will get back to you shortly.";

            $confirmationMail->send();
            header("Location: index");
        } catch (Exception $e) {
            echo "Unable to send email. Please try again! Error: {$mail->ErrorInfo}";
        }
    }
}
?>