<?php
include('db.php');

if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];
    
    // Fetch payment data
    $stmt = $conn->prepare("SELECT * FROM payments WHERE id = ?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payment = $result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $payment_status = $_POST['payment_status'];
        
        // Update payment status
        $stmt = $conn->prepare("UPDATE payments SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("si", $payment_status, $payment_id);
        $stmt->execute();
        
        header('Location: manage_payments.php');
    }
} else {
    header('Location: manage_payments.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Payment</h2>
    <form action="edit_payment.php?id=<?php echo $payment['id']; ?>" method="POST">
        <label for="payment_status">Payment Status:</label>
        <input type="text" id="payment_status" name="payment_status" value="<?php echo $payment['payment_status']; ?>" required>
        <button type="submit">Update Payment</button>
    </form>
</body>
</html>
