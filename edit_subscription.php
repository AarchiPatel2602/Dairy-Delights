<?php
include('db1.php'); // Include the database connection file

// Get the subscription ID from the URL
if (isset($_GET['id'])) {
    $subscription_id = $_GET['id'];
    
    // Query to fetch the subscription details
    $sql = "SELECT * FROM subscriptions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subscription_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if subscription exists
    if ($result->num_rows > 0) {
        $subscription = $result->fetch_assoc();
    } else {
        die("Invalid subscription ID.");
    }
} else {
    die("Invalid request: Missing subscription ID.");
}

// Handle form submission to update subscription
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated status, quantity, and frequency from the form
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    $frequency = $_POST['frequency'];

    // Update the subscription status, quantity, and frequency in the database
    $sql_update = "UPDATE subscriptions SET status = ?, quantity = ?, frequency = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sisi", $status, $quantity, $frequency, $subscription_id);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('Subscription updated successfully!'); window.location.href='your_subscriptions.php';</script>";
        exit();
    } else {
        echo "Error updating subscription: " . $stmt_update->error;
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
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 1rem;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .back-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            margin-top: 15px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .disabled {
            background-color: #f0f0f0;
            color: #888;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Subscription</h2>

    <form method="POST">
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" value="<?php echo $subscription['product_name']; ?>" disabled class="disabled">
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" value="<?php echo $subscription['quantity']; ?>" required>
        </div>

        <div class="form-group">
            <label for="frequency">Frequency</label>
            <select name="frequency" required>
                <option value="daily" <?php echo ($subscription['frequency'] === 'daily') ? 'selected' : ''; ?>>Daily</option>
                <option value="weekly" <?php echo ($subscription['frequency'] === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                <option value="monthly" <?php echo ($subscription['frequency'] === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" required>
                <option value="active" <?php echo ($subscription['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="paused" <?php echo ($subscription['status'] === 'paused') ? 'selected' : ''; ?>>Paused</option>
                <option value="stopped" <?php echo ($subscription['status'] === 'stopped') ? 'selected' : ''; ?>>Stopped</option>
            </select>
        </div>

        <input type="submit" value="Save Changes">
    </form>

    <a href="your_subscriptions.php" class="back-btn">Back to Subscriptions</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
