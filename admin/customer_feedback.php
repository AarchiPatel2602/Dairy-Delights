<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check if database connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch customer feedback from the database
$sql = "SELECT id, customer_name, feedback, email FROM feedback";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-links a {
            text-decoration: none;
            font-weight: bold;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
        }
        .reply {
            background-color: #007bff;
        }
        .reply:hover {
            background-color: #0056b3;
        }
        .delete {
            background-color: #dc3545;
        }
        .delete:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>
    <h2>Customer Feedback</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Feedback</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['feedback']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td class="action-links">
                <a href="reply_feedback.php?email=<?php echo $row['email']; ?>" class="reply">Reply</a>
                <a href="delete_feedback.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
