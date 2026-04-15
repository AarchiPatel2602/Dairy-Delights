<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dairy_products";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get subscription ID from URL
$subscription_id = $_GET['id'] ?? null;

if (!$subscription_id) {
    die("No subscription ID provided.");
}

// Fetch subscription details
$sql = "SELECT * FROM subscriptions WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subscription_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Subscription not found.");
}

$subscription = $result->fetch_assoc();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $frequency = $_POST['frequency'];
    $status = $_POST['status'];

    // Update the subscription
    $sql_update = "UPDATE subscriptions SET product_name = ?, quantity = ?, frequency = ?, status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sissi", $product_name, $quantity, $frequency, $status, $subscription_id);
    
    if ($stmt_update->execute()) {
        header("Location: admin_view_subscriptions.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt_update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subscription</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            margin: 0;
            padding: 0;
            color: white;
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #f8f8f2;
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #44475a;
            color: white;
            font-size: 16px;
        }

        input:focus, select:focus {
            outline: 2px solid #6272a4;
        }

        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        button:hover {
            background: #218838;
        }

        /* Back Button */
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
            margin-top: 15px;
        }

        .back-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>✏️ Edit Subscription</h2>

        <form action="admin_edit_subscription.php?id=<?php echo $subscription['id']; ?>" method="POST">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo $subscription['product_name']; ?>" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $subscription['quantity']; ?>" required min="1">

            <label for="frequency">Frequency:</label>
            <select name="frequency" id="frequency" required>
                <option value="daily" <?php echo ($subscription['frequency'] === 'daily') ? 'selected' : ''; ?>>Daily</option>
                <option value="weekly" <?php echo ($subscription['frequency'] === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                <option value="monthly" <?php echo ($subscription['frequency'] === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="active" <?php echo ($subscription['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="paused" <?php echo ($subscription['status'] === 'paused') ? 'selected' : ''; ?>>Paused</option>
                <option value="stopped" <?php echo ($subscription['status'] === 'stopped') ? 'selected' : ''; ?>>Stopped</option>
            </select>

            <button type="submit">✔ Update Subscription</button>
        </form>

        <a href="admin_view_subscriptions.php" class="back-button">⬅ Back to Subscriptions</a>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
