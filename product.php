<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dairy_products"; // ✅ Correct database

$conn = new mysqli($host, $user, $pass, $dbname);

// Fetch selected product by ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
    $stmt->close();
}

// Fetch all products for bottom scroll
$allProducts = [];
$all = $conn->query("SELECT * FROM products");
while ($row = $all->fetch_assoc()) {
    $allProducts[] = $row;
}

$conn->close();

if (!$product) {
    echo "<h2 style='padding: 20px;'>Product not found.</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $product['name']; ?> - Product Page</title>
    <style>
       .back-btn {
    background-color: #ffca28;
    color: #4e342e;
    border: none;
    padding: 12px 25px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(255, 193, 7, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
}
.back-btn:hover {
    background-color: #ffc107;
    transform: scale(1.05);
}

/* Updated product layout styles */
.product-container {
    display: flex;
    flex-wrap: wrap;
    padding: 40px 60px;
    background-color: #fff3e0;
    border-bottom: 2px solid #ffcc80;
    justify-content: center;
    align-items: flex-start;
}

.product-container img {
    max-width: 100%;
    width: 350px;
    border-radius: 16px;
    box-shadow: 0 6px 12px rgba(255, 165, 0, 0.25);
    margin-bottom: 20px;
}

.product-details {
    flex: 1;
    max-width: 600px;
    margin-left: 30px;
    background-color: #fff8f0;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 6px 12px rgba(255, 193, 7, 0.2);
}

.product-details h1 {
    color: #e65100;
    font-size: 32px;
    margin-bottom: 10px;
}

.price {
    font-size: 26px;
    font-weight: bold;
    color: #bf360c;
    margin: 12px 0;
}

.quantity button {
    padding: 6px 15px;
    font-size: 20px;
}

.dates {
    background-color: #fff3e0;
    padding: 10px;
    border-radius: 8px;
    margin-top: 15px;
    line-height: 1.6;
    font-weight: bold;
}

.desc {
    margin-top: 20px;
    line-height: 1.6;
    font-size: 15px;
}

.milk-options {
    margin: 15px 0;
    font-weight: bold;
}
.all-products {
    padding: 40px 20px;
    background: #fffaf0;
    margin-top: 30px;
    border-top: 2px solid #ffd180;
}
.all-products h2 {
    color: #ff6f00;
    font-size: 24px;
    margin-bottom: 20px;
}

.product-list {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding-bottom: 10px;
    scroll-behavior: smooth;
}

.product-card {
    min-width: 200px;
    background: #fff;
    border: 1px solid #ffe0b2;
    border-radius: 12px;
    text-align: center;
    padding: 10px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s;
}

.product-card:hover {
    transform: scale(1.05);
}

.product-card img {
    max-width: 100%;
    max-height: 150px;
    object-fit: contain;
    border-radius: 10px;
    margin-bottom: 10px;
}

.product-card a {
    text-decoration: none;
    color: #333;
}

.product-card h4 {
    font-size: 18px;
    color: #ff6f00;
    margin: 5px 0;
}

.product-card p {
    font-weight: bold;
    color: #e65100;
}

    </style>
    <script>
        function updateQty(val) {
            const qtyElem = document.getElementById("quantity");
            let qty = parseInt(qtyElem.textContent);
            if (val === '+' && qty < 20) qty++;
            if (val === '-' && qty > 1) qty--;
            qtyElem.textContent = qty;
        }

        function addToCart(productId) {
            const qty = parseInt(document.getElementById("quantity").textContent);
            const productName = "<?= addslashes($product['name']); ?>";
            const productPrice = <?= $product['price']; ?>;
            const productImage = "<?= $product['image']; ?>";

            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            const existing = cart.find(item => item.id === productId);

            if (existing) {
                existing.qty += qty;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    qty: qty
                });
            }

            localStorage.setItem("cart", JSON.stringify(cart));
            alert(`${productName} added to cart!`);
            window.location.href = 'cart.html';
        }
    </script>
</head>
<body>
<div style="padding: 20px; text-align: right;">
    <a href="cart.html">
        <button style="
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 128, 0, 0.2);
        " onmouseover="this.style.backgroundColor='#43a047';"
           onmouseout="this.style.backgroundColor='#4caf50';">
            🛒 Show Cart
        </button>
    </a>
</div>

<div class="product-container">
    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
    <div class="product-details">
        <h1><?= htmlspecialchars($product['name']); ?></h1>
        <div class="price">₹<?= number_format($product['price'], 2); ?></div>
        <!-- Place this inside <body> tag after product container -->
        <div style="padding: 20px; text-align: center;">
            <a href="home.php">
        <button class="back-btn">⬅ Back to Homepage</button>
            </a>
        </div>

        <div class="quantity">
            <label>Quantity:</label>
            <button onclick="updateQty('-')">-</button>
            <span id="quantity">1</span>
            <button onclick="updateQty('+')">+</button>
        </div>

        <?php if (stripos($product['name'], 'milk') !== false): ?>
        <div class="milk-options">
            <label><input type="radio" name="size" checked> 500ml</label>
            <label><input type="radio" name="size"> 1L</label>
        </div>
        <?php endif; ?>

        <div class="dates">
            <strong>Making Date:</strong> <?= htmlspecialchars($product['making_date'] ?? date('Y-m-d')); ?><br>
            <strong>Expiry Date:</strong> <?= htmlspecialchars($product['expiry_date'] ?? date('Y-m-d', strtotime('+5 days'))); ?>
        </div>

        <div class="desc">
    <?php 
        if (isset($product['description']) && !empty($product['description'])) {
            echo nl2br(htmlspecialchars($product['description']));
        } else {
            echo "<em>No description available for this product.</em>";
        }
    ?>
    </div>

        <div class="add-to-cart">
        <button onclick="addToCart()">Add to Cart</button>

        <script>
    function addToCart() {
        const qty = parseInt(document.getElementById("quantity").textContent);
        const product = {
            id: <?= $product['id']; ?>,
            name: "<?= addslashes($product['name']); ?>",
            price: <?= $product['price']; ?>,
            image: "<?= addslashes($product['image']); ?>",
            quantity: qty
        };

        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const existing = cart.find(item => item.id === product.id);

        if (existing) {
            existing.quantity += qty;
        } else {
            cart.push(product);
        }

        localStorage.setItem("cart", JSON.stringify(cart));

        // Show confirmation popup
        const confirmBox = document.createElement("div");
        confirmBox.innerHTML = `
            <div style="
                position: fixed;
                top: 30%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff8e1;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
                z-index: 9999;
                text-align: center;
                font-family: Arial, sans-serif;
            ">
                <h3 style="color: #e65100;">🛒 ${product.name} added to cart!</h3>
                <button onclick="window.location.href='cart.html'" style="
                    background-color: #ff9800;
                    color: white;
                    border: none;
                    padding: 10px 25px;
                    margin-top: 15px;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 16px;
                ">Go to Cart</button>
                <br><br>
                <button onclick="this.parentElement.remove()" style="
                    background-color: #cfd8dc;
                    color: #333;
                    border: none;
                    padding: 8px 20px;
                    border-radius: 8px;
                    font-size: 14px;
                    cursor: pointer;
                ">Continue Shopping</button>
            </div>
        `;
        document.body.appendChild(confirmBox);
    }
</script>

        </div>
    </div>
</div>
<!-- Place this right before the closing </body> tag in your existing file -->

<div class="all-products">
    <h2>Other Products</h2>
    <div class="product-list">
        <?php foreach ($allProducts as $item): ?>
            <?php if ($item['id'] !== $product['id']): ?>
                <div class="product-card">
                    <a href="product.php?id=<?= $item['id']; ?>">
                        <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                        <h4><?= htmlspecialchars($item['name']); ?></h4>
                        <p>₹<?= number_format($item['price'], 2); ?></p>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<div style="text-align:center; padding: 30px;">
    <a href="home.php">
        <button style="
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        " onmouseover="this.style.backgroundColor='#fb8c00';"
           onmouseout="this.style.backgroundColor='#ff9800';">
            ⬅ Back to Homepage
        </button>
    </a>
</div>

</body>
</html>
