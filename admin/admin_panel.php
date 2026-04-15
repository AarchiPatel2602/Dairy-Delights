<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e2f;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .admin-container {
            width: 90%;
            max-width: 900px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            color: #f8f8f2;
            margin-bottom: 10px;
        }

        .greeting {
            font-size: 18px;
            color: #bd93f9;
            margin-bottom: 20px;
        }

        /* Card-Based Navigation */
        .nav-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .nav-card {
            background: #44475a;
            padding: 20px;
            width: 200px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease, background 0.3s ease;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        }

        .nav-card:hover {
            background: #6272a4;
            transform: translateY(-5px);
        }

        .nav-card a {
            text-decoration: none;
            color: #f8f8f2;
            font-size: 16px;
            font-weight: bold;
            display: block;
        }

        .logout-btn {
            display: block;
            margin-top: 30px;
            padding: 12px 18px;
            background: #ff5555;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #ff3333;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <header class="header">
            <h1>Admin Panel</h1>
            <p class="greeting">Welcome, <?php echo $_SESSION['admin_email']; ?>!</p>
        </header>

        <div class="nav-container">
            <div class="nav-card">
                <a href="manage_products.php">📦 Manage Products</a>
            </div>
            <div class="nav-card">
                <a href="manage_orders.php">🛒 Manage Orders</a>
            </div>
            <div class="nav-card">
                <a href="manage_users.php">👥 Manage Users</a>
            </div>
            <div class="nav-card">
                 <a href="reviews.php">📝 Manage Reviews</a>
            </div>
            <div class="nav-card">
                <a href="admin_view_subscriptions.php">📜 Manage Subscriptions</a>
            </div>
            <div class="nav-card">
                <a href="change_email.php">📧 Change Email</a>
            </div>
        </div>

        <a href="logout.php" class="logout-btn">🚪 Logout</a>
    </div>
</body>
</html>