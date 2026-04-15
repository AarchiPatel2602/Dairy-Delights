<?php
include('db2.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data
    $stmt = $conn->prepare("SELECT full_name, email, password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('User not found!'); window.location.href='manage_users.php';</script>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the password field is empty
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssi", $full_name, $email, $hashed_password, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $full_name, $email, $user_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('User updated successfully!'); window.location.href='manage_users.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating user: " . $conn->error . "');</script>";
        }
    }
} else {
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: white;
            text-align: center;
            padding: 0;
            margin: 0;
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #44475a;
            color: white;
            font-size: 16px;
        }

        input:focus {
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
        <h2>✏️ Edit User</h2>

        <a href="manage_users.php" class="back-button">⬅ Back to Users</a>

        <form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST">
            <label for="id">User ID:</label>
            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($user_id); ?>" disabled>
            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="current_password">Current Hashed Password:</label>
            <input type="text" id="current_password" value="<?php echo htmlspecialchars($user['password']); ?>" readonly>

            <label for="password">New Password (leave blank to keep current):</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">
            
            <button type="submit">✔ Update User</button>
        </form>
    </div>

</body>
</html>
