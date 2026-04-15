<?php
include 'db1.php';

$result = $conn->query("SELECT id, username, status FROM orders ORDER BY id DESC");
?>

<h2>Update Order Status</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Username</th>
        <th>Status</th>
        <th>Update</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <form method="post" action="update_order_status.php">
                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                <select name="status">
                    <option value="0" <?= $row['status']==0 ? 'selected' : '' ?>>Ordered</option>
                    <option value="1" <?= $row['status']==1 ? 'selected' : '' ?>>Shipped</option>
                    <option value="2" <?= $row['status']==2 ? 'selected' : '' ?>>Out for Delivery</option>
                    <option value="3" <?= $row['status']==3 ? 'selected' : '' ?>>Delivered</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
