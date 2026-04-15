<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $to = $data["email"];
    $subject = "Registration Successful!";
    $message = "Hello " . $data["fullName"] . ",\n\nThank you for registering with us!\n\nBest Regards,\nDairy Products Team";
    $headers = "From: noreply@dairyproducts.com\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
}
?>
