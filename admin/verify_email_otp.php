<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dairy_products");

if (!isset($_SESSION['admin_email']) || !isset($_SESSION['otp']) || !isset($_SESSION['pending_email'])) {
    header("Location: change_email.php");
    exit();
}

$currentEmail = $_SESSION['admin_email'];
$pendingEmail = $_SESSION['pending_email'];
$storedOtp = $_SESSION['otp'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = $_POST['otp'];

    if ($enteredOtp == $storedOtp) {
        $stmt = $conn->prepare("UPDATE admin SET email=? WHERE email=?");
        $stmt->bind_param("ss", $pendingEmail, $currentEmail);

        if ($stmt->execute()) {
            $_SESSION['admin_email'] = $pendingEmail;
            unset($_SESSION['otp'], $_SESSION['pending_email']);
            $message = "✅ Email updated successfully!";
        } else {
            $message = "❌ Failed to update email in DB.";
        }
    } else {
        $message = "⚠️ Incorrect OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body { background-color: #1e1e2f; color: white; font-family: Arial; text-align: center; padding-top: 100px; }
        form { background: #282a36; padding: 30px; border-radius: 10px; width: 400px; margin: auto; box-shadow: 0px 0px 10px #000; }
        input, button { padding: 10px; width: 90%; margin-top: 15px; border: none; border-radius: 5px; }
        button { background: #ffb86c; color: black; font-weight: bold; cursor: pointer; }
        .msg { margin-top: 15px; color: #f1fa8c; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Enter OTP</h2>
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify & Update Email</button>
        <div class="msg"><?php echo $message; ?></div>
        <a href="admin_panel.php">← BACK</a>
    </form>
</body>
</html>
