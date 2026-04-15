<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET["review_id"])) {
    die("Invalid request.");
}

$review_id = $_GET["review_id"];
$sql = "SELECT id, name, email, message FROM feedback WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $review_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Review not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
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
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background: #282a36;
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            color: #f8f8f2;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
        }
        .save-btn {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .save-btn:hover {
            background: #218838;
        }
        .back-btn {
            display: inline-block;
            margin-top: 10px;
            background: #bd93f9;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: #8be9fd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Review</h1>
        <form action="update_review.php" method="POST">
            <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <textarea name="message" required><?php echo $row['message']; ?></textarea>
            <button type="submit" class="save-btn">Save Changes</button>
        </form>
        <a href="reviews.php" class="back-btn">⬅ Back to Reviews</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
