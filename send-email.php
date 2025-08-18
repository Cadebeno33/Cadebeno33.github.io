<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $email   = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $data = [
        "sender" => [
            "name" => "Portfolio Website",
            "email" => "94ee92001@smtp-brevo.com" // Must be verified in Brevo
        ],
        "to" => [
            [
                "email" => "cadebeno3322@gmail.com",
                "name" => "Cade"
            ]
        ],
        "subject" => "New message from your portfolio site",
        "htmlContent" => "<b>Name:</b> $name<br><b>Email:</b> $email<br><b>Message:</b><br>$message"
    ];

    $ch = curl_init("https://api.brevo.com/v3/smtp/email");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "accept: application/json",
        "api-key: wTjtZbm1hQSxNqz9", // Your Brevo API key
        "content-type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo "Message could not be sent. Error: $error";
    } else {
        header("Location: sent.html");
        exit;
    }
}
?>
