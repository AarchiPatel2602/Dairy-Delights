<?php
include('db1.php'); // Include the database connection file

// Query to fetch all subscriptions from the database
$sql = "SELECT * FROM subscriptions ORDER BY start_date DESC";
$result = $conn->query($sql);

// Check if the result is valid and contains rows
if ($result === false) {
    echo "Error: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Subscriptions</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 85%;
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
            padding-bottom: 40px;
        }

        h2 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background-color: #007bff;
            color: white;
            font-size: 1.1rem;
        }

        td {
            background-color: #f9f9f9;
        }

        td a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            padding: 5px;
            display: inline-block;
        }

        td a:hover {
            text-decoration: underline;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
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
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .no-subscriptions {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }

            table th, table td {
                padding: 10px;
                font-size: 0.9rem;
            }

            .back-btn {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>All Subscriptions</h2>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Frequency</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['product_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['frequency']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <a href='edit_subscription.php?id={$row['id']}'>Edit</a> |
                            <a href='delete_subscription.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this subscription?\")'>Delete</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-subscriptions'>No subscriptions found.</p>";
        }
        ?>

        <div class="button-container">
            <a href="subscription_form.html" class="back-btn">Add Subscription</a>
        </div>

        <div class="button-container">
            <a href="home.php" class="back-btn">Back to Homepage</a>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
