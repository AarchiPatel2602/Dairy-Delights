<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reply']) && isset($_POST['feedback_id'])) {
        $feedback_id = intval($_POST['feedback_id']); // Prevent SQL injection
        $reply = htmlspecialchars($_POST['reply']);

        // Get user email
        $stmt = $conn->prepare("SELECT email FROM feedback WHERE id = ?");
        $stmt->bind_param("i", $feedback_id);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();

        // Update reply in database
        $stmt = $conn->prepare("UPDATE feedback SET reply = ? WHERE id = ?");
        $stmt->bind_param("si", $reply, $feedback_id);
        if ($stmt->execute()) {
            // Send email notification
            include 'send_email.php'; // Call email function
            sendFeedbackReply($email, $reply);
            echo "<script>alert('Reply sent successfully!'); window.location.href='customer_feedback.php';</script>";
        } else {
            echo "<script>alert('Error updating feedback.'); window.location.href='customer_feedback.php';</script>";
        }
        $stmt->close();
    }
}

// Fetch feedback data
$sql = "SELECT id, customer_name, email, feedback, reply FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        h2 { text-align: center; color: #333; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th { background-color: #007BFF; color: white; }
        tr:hover { background-color: #f1f1f1; }
        textarea {
            width: 80%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .reply-btn {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .reply-btn:hover { background-color: #218838; }
    </style>
</head>
<body>

<h2>Customer Feedback</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Feedback</th>
        <th>Reply</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['feedback']}</td>
                    <td>
                        <form method='POST' action='customer_feedback.php'>
                            <input type='hidden' name='feedback_id' value='{$row['id']}'>
                            <textarea name='reply' required placeholder='Enter your reply'>{$row['reply']}</textarea>
                            <br>
                            <button type='submit' class='reply-btn'>Send</button>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No feedback found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>