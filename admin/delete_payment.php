<?php
include('db.php');

if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];
    
    // Delete payment
    $stmt = $conn->prepare("DELETE FROM payments WHERE id = ?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    
    header('Location: manage_payments.php');
}
?>
