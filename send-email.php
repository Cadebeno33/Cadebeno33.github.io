<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Brevo API payload
    $data = [
        "sender" => [
            "name" => "Portfolio Website",
            "email" => "94ee92001@smtp-brevo.com" // Verified Brevo sender
        ],
        "to" => [
            [
                "email" => "cadebeno3322@gmail.com",
                "name" => "Cade"
            ]
        ],
        "subject" => "New message from your portfolio site",
        "htmlContent" => "
            <b>Name:</b> $name<br>
            <b>Email:</b> $email<br>
            <b>Message:</b><br>$message"
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
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($error) {
        echo "cURL error: $error";
    } else {
        $responseData = json_decode($response, true);

        if ($status >= 200 && $status < 300) {
            // Success
            header("Location: sent.html");
            exit;
        } else {
            // Brevo API returned an error
            $apiMessage = $responseData['message'] ?? 'Unknown error';
            echo "Brevo API error (HTTP $status): $apiMessage";
        }
    }
} else {
    echo "Invalid request method.";
}
?>
