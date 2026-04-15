<?php
session_start();
if (!isset($_SESSION['admin_email'])) { // Ensure it checks 'admin_email'
    header('Location: login.php');
    exit();
}

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

// Query to fetch feedback data
$sql = "SELECT id, customer_name, email, feedback, created_at, reply FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
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
            max-width: 1100px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
        }
        h1 {
            color: #f8f8f2;
            margin-bottom: 20px;
        }
        .table-container {
            overflow-x: auto; /* Enables horizontal scrolling on small screens */
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #44475a;
            color: white;
            margin-top: 20px;
            border-radius: 10px;
            text-align: left;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #f8f8f2;
            word-break: break-word;
        }
        th {
            background: #6272a4;
            font-size: 16px;
            text-align: center;
        }
        td {
            background: #343746;
            font-size: 14px;
        }
        td:nth-child(4) { /* Feedback Column */
            max-width: 300px; /* Restrict width */
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .reply-btn, .delete-btn {
            padding: 8px 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
            width: 100px; /* Uniform width */
            font-weight: bold;
            text-align: center;
        }
        .reply-btn {
            background: #f1c40f;
            color: black;
        }
        .reply-btn:hover {
            background: #d4ac0d;
            transform: scale(1.05);
        }
        .delete-btn {
            background: #ff5555;
            color: white;
        }
        .delete-btn:hover {
            background: #ff3333;
            transform: scale(1.05);
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
        }
        .back-btn:hover {
            background: #8be9fd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Reviews</h1>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Reply</th>
                        <th>Action</th>
                    </tr>
                    <!-- Inside your while loop -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["customer_name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["feedback"]; ?></td>
                        <td><?php echo $row["created_at"]; ?></td>
                        <td><?php echo !empty($row["reply"]) ? $row["reply"] : "No reply yet"; ?></t>
                        <td class="action-buttons">
                            <!-- Reply Button -->
                            <form action="reply_feedback.php" method="GET">
                                <input type="hidden" name="review_id" value="<?php echo $row["id"]; ?>">
                                <button type="submit" class="reply-btn">Reply</button>
                            </form>

                            <!-- Delete Button - Only if replied -->
                            <?php if (!empty($row["reply"])): ?>
                            <form action="delete_review.php" method="POST">
                                <input type="hidden" name="review_id" value="<?php echo $row["id"]; ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this review?');">Delete</butto>
                            </form>
                            <?php else: ?>
                            <button class="delete-btn" style="background-color: grey; cursor: not-allowed;" disabled>Delete</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php else: ?>
            <p>No reviews found.</p>
        <?php endif; ?>

        <a href="admin_panel.php" class="back-btn">⬅ Back to Admin Panel</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
