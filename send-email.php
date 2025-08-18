<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$subject = "New message from your portfolio site";
$message = trim($_POST["message"]);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPAuth   = true;
    $mail->Host       = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->Username   = "cadebeno3322@gmail.com";
    $mail->Password   = "rzvbnkihjuddwxgs";

    $mail->setFrom("cadebeno3322@gmail.com", "Cade"); // Your Gmail
    $mail->addReplyTo($email, $name); // user’s email
    $mail->addAddress("cadebeno3322@gmail.com", "Cade");

    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    header("Location: sent.html");
    exit;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

