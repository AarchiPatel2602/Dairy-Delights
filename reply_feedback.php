<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Load PHPMailer
require __DIR__ . '/vendor/autoload.php';

if (isset($_POST['send_email'])) {
    $user_email = $_POST['email']; 
    $subject = $_POST['subject']; 
    $message = nl2br($_POST['message']); // Converts new lines to <br> for better formatting in emails

    try {
        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dairydelights2602@gmail.com'; // Your Gmail
        $mail->Password = 'verkbntclewxcewa'; // Your 16-character App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Headers
        $mail->setFrom('dairydelights2602@gmail.com', 'Dairy Delights');
        $mail->addReplyTo('dairydelights2602@gmail.com', 'Dairy Delights');
        $mail->addAddress($user_email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<p>$message</p>"; // HTML formatting

        // Send email
        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo 'Failed to send email. Error: ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send Reply</h2>
        <form action="reply_feedback.php" method="POST">
            <label for="email">Customer Email:</label>
            <input type="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" name="subject" required>

            <label for="message">Message:</label>
            <textarea name="message" required></textarea>

            <button type="submit" name="send_email">Send Reply</button>
        </form>
    </div>
</body>
</html>
