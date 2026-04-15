<?php
session_start();
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$conn = new mysqli("localhost", "root", "", "dairy_products");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$currentEmail = $_SESSION['admin_email'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = $_POST['new_email'];
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['pending_email'] = $newEmail;

    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'dairydelights2602@gmail.com';
        $mail->Password = 'verk bntc lewx cewa'; // Use App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('dairydelights2602@gmail.com', 'Dairy Admin OTP');
        $mail->addAddress($currentEmail);

        $mail->Subject = "OTP for Email Change";
        $mail->Body = "Your OTP is: $otp";

        $mail->send();
        header("Location: verify_email_otp.php");
        exit();
    } catch (Exception $e) {
        $message = "❌ Failed to send OTP. Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Email</title>
    <style>
        body { background-color: #1e1e2f; color: white; font-family: Arial; text-align: center; padding-top: 100px; }
        form { background: #282a36; padding: 30px; border-radius: 10px; width: 400px; margin: auto; box-shadow: 0px 0px 10px #000; }
        input, button { padding: 10px; width: 90%; margin-top: 15px; border: none; border-radius: 5px; }
        button {
    background: linear-gradient(135deg, #50fa7b, #00c896);
    color: #1e1e2f;
    font-weight: bold;
    border: none;
    padding: 12px;
    width: 90%;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 0 10px #50fa7b88, 0 0 20px #00c89644;
}

button:hover {
    background: linear-gradient(135deg, #00c896, #50fa7b);
    transform: scale(1.03);
    box-shadow: 0 0 15px #00ffc855, 0 0 25px #00ffc833;
}

        a { color: #8be9fd; display: inline-block; margin-top: 20px; text-decoration: none; }
        .msg { margin-top: 15px; color: #f1fa8c; }
        .back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #6272a4;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s, transform 0.2s;
}

.back-btn:hover {
    background-color: #8be9fd;
    color: black;
    transform: scale(1.05);
    box-shadow: 0 0 10px #8be9fd;
}

    </style>
</head>
<body>
    <form method="POST">
        <h2>Change Email (OTP Secured)</h2>
        <input type="email" name="new_email" placeholder="New Email" required>
        <button type="submit">Send OTP</button>
        <div class="msg"><?php echo $message; ?></div>
        <a class="back-btn" href="admin_panel.php">← Back to Admin Panel</a>
    </form>
</body>
</html>
