<?php
include('db.php');

// Fetch payments from the database
$query = "SELECT * FROM payments";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Manage Payments</h2>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo $row['payment_status']; ?></td>
                    <td>
                        <a href="edit_payment.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_payment.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
