<?php
session_start();

// Ensure OTP session is set
if (!isset($_SESSION['otp']) || !isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp'] && time() <= $_SESSION['otp_expiry']) {
        $_SESSION['authenticated'] = true; // Set authenticated flag
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);

        header('Location: admin_panel.php');
        exit();
    } else {
        $error = "Invalid or expired OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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

        /* OTP Verification Container */
        .otp-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        .otp-container h2 {
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

        /* Verify Button */
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
            .otp-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="otp-container">
        <h2>Enter OTP</h2>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST">
            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>

</body>
</html>
