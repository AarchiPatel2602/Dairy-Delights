<?php
include('db.php');

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Delete order
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    
    header('Location: manage_orders.php');
}
?>
