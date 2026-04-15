<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dairy_products");

// Validate and get order ID from URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 50;
if ($order_id < 50) {
    $error = "Invalid Order ID. ID must be 50 or above.";
} else {
    // Check if order exists
    $stmt = $conn->prepare("SELECT status FROM orders WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        $error = "Order not found with ID $order_id.";
    } else {
        $current_status = $order['status'];
    }
}

// Handle admin update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true && isset($order)) {
    $new_status = $_POST['status'];
    $update_stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $update_stmt->bind_param("si", $new_status, $order_id);
    $update_stmt->execute();

    // Refresh to see the update
    header("Location: ".$_SERVER['PHP_SELF']."?order_id=".$order_id);
    exit;
}

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Status | Dairy Delights</title>
  <style>
    body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(to right, #fffaf5, #fff0e0);
  color: #333;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  min-height: 100vh;
  padding-top: 40px;
}

h1 {
  font-size: 36px;
  color: #f57c00;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px;
}

.tracker {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 90%;
  max-width: 900px;
  margin-bottom: 40px;
  position: relative;
}

.tracker::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 5%;
  right: 5%;
  height: 6px;
  background: #e0e0e0;
  z-index: 0;
  border-radius: 5px;
  transform: translateY(-50%);
}

.step {
  background: #fff;
  border-radius: 50%;
  width: 65px;
  height: 65px;
  font-size: 14px;
  text-align: center;
  line-height: 65px;
  font-weight: 600;
  color: #aaa;
  z-index: 2;
  position: relative;
  transition: all 0.3s ease;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
  border: 3px solid #ddd;
}

.step.active {
  background: linear-gradient(145deg, #ffa726, #fb8c00);
  color: #fff;
  border: 3px solid #ffc285;
  box-shadow: 0 0 12px #ffb86b;
  transform: scale(1.05);
}

.step::after {
  content: attr(data-status);
  display: block;
  position: absolute;
  top: 75px;
  width: 100px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 13px;
  color: #444;
  font-weight: 500;
  white-space: nowrap;
}

.status-control {
  margin-top: 30px;
  padding: 20px;
  background: #fff;
  border: 2px solid #ffe0b2;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(255, 171, 64, 0.1);
}

label {
  font-size: 16px;
  font-weight: 600;
  margin-right: 10px;
}

select {
  padding: 10px 16px;
  font-size: 16px;
  border-radius: 10px;
  border: 2px solid #ffa726;
  background-color: #fffdf9;
  color: #333;
  outline: none;
}

button {
  background: linear-gradient(135deg, #ffa726, #fb8c00);
  color: white;
  padding: 10px 20px;
  border: none;
  margin-left: 12px;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.3s ease;
}

button:hover {
  background: linear-gradient(135deg, #fb8c00, #ffa726);
  box-shadow: 0 0 10px #ffcc80;
}

.error {
  color: #e53935;
  margin-top: 20px;
  font-size: 18px;
  background: #ffe5e0;
  padding: 15px 25px;
  border-radius: 8px;
  border-left: 5px solid #f44336;
}

@media (max-width: 700px) {
  .tracker {
    flex-direction: column;
    gap: 40px;
  }

  .tracker::before {
    display: none;
  }

  .step::after {
    top: 70px;
    font-size: 12px;
  }
}

  </style>
</head>
<body>

  <h1>Order Status Tracker</h1>

  <?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php else: ?>
    <div class="tracker" id="statusTracker">
      <div class="step" data-status="ordered">1</div>
      <div class="step" data-status="dispatched">2</div>
      <div class="step" data-status="shipped">3</div>
      <div class="step" data-status="out for delivery">4</div>
      <div class="step" data-status="delivered">5</div>
    </div>

    <?php if ($is_admin): ?>
    <div class="status-control">
      <form method="post">
        <label for="status">Update Order Status:</label>
        <select id="status" name="status">
          <option value="ordered">Ordered</option>
          <option value="dispatched">Dispatched</option>
          <option value="shipped">Shipped</option>
          <option value="out for delivery">Out for Delivery</option>
          <option value="delivered">Delivered</option>
        </select>
        <button type="submit">Update</button>
      </form>
    </div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (!isset($error)): ?>
  <script>
    const currentStatus = "<?= strtolower($current_status) ?>";
    const steps = document.querySelectorAll(".step");
    let active = true;

    steps.forEach(step => {
      const status = step.getAttribute("data-status");

      if (active) {
        step.classList.add("active");
      }

      if (status === currentStatus) {
        active = false;
      }
    });

    <?php if ($is_admin): ?>
      document.getElementById("status").value = currentStatus;
    <?php endif; ?>
  </script>
  <?php endif; ?>
  <br><br>
  <div style="margin-top: 30px; width: 90%; max-width: 900px; text-align: left;">
  <a href="home.php" style="
    background: linear-gradient(135deg, #ffa726, #fb8c00);
    color: white;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    box-shadow: 0 4px 8px rgba(255, 138, 0, 0.3);
    display: inline-block;
    transition: background 0.3s ease;
  " onmouseover="this.style.background='linear-gradient(135deg, #fb8c00, #ffa726)'" 
     onmouseout="this.style.background='linear-gradient(135deg, #ffa726, #fb8c00)'">
    ⬅ Back to Homepage
  </a>
</div>

</body>
</html>
