<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM feedback WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $feedback = $_POST['feedback'];

    $query = "UPDATE feedback SET feedback='$feedback' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: customer_feedback.php?success=Feedback updated!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Feedback</title>
</head>
<body>
    <h2>Edit Feedback</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <textarea name="feedback"><?php echo $row['feedback']; ?></textarea><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
