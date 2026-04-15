<?php
include('db2.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    header('Location: manage_users.php');
}
?>
