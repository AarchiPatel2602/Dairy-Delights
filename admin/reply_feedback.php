<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Load PHPMailer
require __DIR__ . '/vendor/autoload.php';

$successMessage = "";
$errorMessage = "";
$review_id = isset($_GET['review_id']) ? $_GET['review_id'] : '';

$customer_email = "";
$customer_feedback = "";

// Fetch email and feedback
if (!empty($review_id)) {
    $query = "SELECT email, feedback FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $stmt->bind_result($customer_email, $customer_feedback);
    $stmt->fetch();
    $stmt->close();
}

// Handle email submission
if (isset($_POST['send_email'])) {
    $review_id = $_POST['review_id'];
    $user_email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = nl2br($_POST['message']);

    try {
        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dairydelights2602@gmail.com';
        $mail->Password = 'verkbntclewxcewa';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Headers
        $mail->setFrom('dairydelights2602@gmail.com', 'Dairy Delights');
        $mail->addReplyTo('dairydelights2602@gmail.com', 'Dairy Delights');
        $mail->addAddress($user_email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<p>$message</p>";

        // Send email
        $mail->send();

        // Update feedback reply in DB
        $update_sql = "UPDATE feedback SET reply = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $message, $review_id);
        if ($stmt->execute()) {
            $successMessage = "✅ Email sent & reply saved!";
        } else {
            $errorMessage = "⚠️ Email sent, but failed to save reply.";
        }
        $stmt->close();
    } catch (Exception $e) {
        $errorMessage = "❌ Failed to send email. Error: " . $mail->ErrorInfo;
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
            background-color: #1e1e2f;
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 95%;
            max-width: 600px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
            text-align: left;
        }
        h2 {
            text-align: center;
            color: #f8f8f2;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #f8f8f2;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #44475a;
            color: white;
        }
        input[readonly], textarea[readonly] {
            background-color: #3c3f52;
            cursor: not-allowed;
        }
        button {
            margin-top: 20px;
            background-color: #f1c40f;
            color: black;
            border: none;
            padding: 10px 15px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover {
            background-color: #d4ac0d;
        }
        .message-box {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .success {
            background-color: #28a745;
            color: white;
            border: 1px solid #1e7e34;
            text-align: center;
        }
        .error {
            background-color: #ff5555;
            color: white;
            border: 1px solid #ff3333;
            text-align: center;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background: #bd93f9;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            width: 100%;
            display: block;
        }
        .back-btn:hover {
            background: #8be9fd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send Reply</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="message-box success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="message-box error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="reply_feedback.php" method="POST">
            <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">

            <label for="email">Customer Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($customer_email); ?>" readonly>

            <label for="feedback">Customer Feedback:</label>
            <textarea name="feedback" readonly><?php echo htmlspecialchars($customer_feedback); ?></textarea>

            <label for="subject">Subject:</label>
            <input type="text" name="subject" required>

            <label for="message">Message:</label>
            <textarea name="message" required></textarea>

            <button type="submit" name="send_email">Send Reply</button>
        </form>

        <a href="reviews.php" class="back-btn">⬅ Back to Reviews</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
