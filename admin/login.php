<?php
session_start();
include('db.php'); // Include MySQLi database connection
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTPEmail($to, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dairydelights2602@gmail.com';
        $mail->Password = 'verk bntc lewx cewa'; // Replace with App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('dairydelights2602@gmail.com', 'Dairy Delights Admin');
        $mail->addAddress($to);
        $mail->Subject = 'Your Dairy Delights Admin Login OTP';
        $mail->isHTML(true);
        $mail->Body = "
            <h2>Admin Login OTP</h2>
            <p>Your OTP for login is: <b>$otp</b></p>
            <p>This OTP is valid for 5 minutes.</p>
            <p>If you didn't request this, please ignore this email.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Check if admin exists in the database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin) {
        // Generate OTP
        $otp = rand(1000, 9999);
        $_SESSION['otp'] = $otp;
        $_SESSION['admin_email'] = $email;
        $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes

        // Send OTP email
        if (sendOTPEmail($email, $otp)) {
            header('Location: otp_verification.php'); // Redirect to OTP verification page
            exit();
        } else {
            $error = "Failed to send OTP. Please check email settings.";
        }
    } else {
        $error = "Admin not found! Please check your email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* General Page Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #232526, #414345);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login Container */
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        /* Form Styling */
        label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-top: 10px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Login Button */
        button {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: white;
            font-size: 16px;
            border: none;
            padding: 12px;
            width: 100%;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(135deg, #ff6b42, #fd9c5a);
        }

        /* Error Message */
        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Send OTP</button>
        </form>
    </div>

</body>
</html>
