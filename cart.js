document.addEventListener("DOMContentLoaded", function () {
    loadCart();
});

let cart = JSON.parse(localStorage.getItem("cart")) || [];
let discountApplied = false;

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Function to load cart items and update the UI
function loadCart() {
    const cartTable = document.getElementById("cart-items");
    const cartEmpty = document.getElementById("cart-empty");
    cartTable.innerHTML = "";

    if (cart.length === 0) {
        cartEmpty.style.display = "block";
        return;
    }
    cartEmpty.style.display = "none";

    let total = 0;

    cart.forEach((item, index) => {
        if (!item.quantity) item.quantity = 1;
        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.name}</td>
            <td>₹${item.price}</td>
            <td>
                <button onclick="changeQuantity(${index}, -1)">-</button>
                <span id="quantity-${index}">${item.quantity}</span>
                <button onclick="changeQuantity(${index}, 1)">+</button>
            </td>
            <td id="item-total-${index}">₹${itemTotal.toFixed(2)}</td>
            <td><button onclick="removeItem(${index})">Remove</button></td>
        `;
        cartTable.appendChild(row);
    });

    if (discountApplied) {
        total *= 0.8;
    }
    let tax = total * 0.18;
    let finalTotal = total + tax;

    document.getElementById("subtotal").innerText = total.toFixed(2);
    document.getElementById("discount").innerText = discountApplied ? (total * 0.2).toFixed(2) : "0.00";
    document.getElementById("tax").innerText = tax.toFixed(2);
    document.getElementById("total").innerText = finalTotal.toFixed(2);

    saveCart();
}

// Function to change product quantity
function changeQuantity(index, change) {
    if (cart[index].quantity + change > 0) {
        cart[index].quantity += change;
        saveCart();
        loadCart();
    }
}

// Function to remove an item from the cart
function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    loadCart();
}

// Function to apply coupon
function applyCoupon() {
    let couponCode = document.getElementById("coupon-code").value;

    if (couponCode === "DAIRY20") {
        discountApplied = true;
        loadCart();
        alert("Coupon applied! 20% discount on your order.");
    } else {
        alert("Invalid coupon code!");
    }
}

// Function to download the bill as PDF
function downloadBill() {
    const { jsPDF } = window.jspdf;
    let pdf = new jsPDF();

    pdf.setFontSize(18);
    pdf.text("Dairy Delight - Invoice", 70, 15);
    pdf.setFontSize(12);
    pdf.text("Phone: +91 8469434870", 10, 30);
    pdf.text("Address: L.J Polytechnic", 10, 40);
    pdf.line(10, 45, 200, 45);

    let y = 55;
    pdf.text("Product Details:", 10, y);
    cart.forEach((item, index) => {
        y += 10;
        pdf.text(`${index + 1}. ${item.name} - ₹${item.price} x ${item.quantity} = ₹${(item.price * item.quantity).toFixed(2)}`, 10, y);
    });

    y += 15;
    pdf.line(10, y, 200, y);
    y += 10;
    pdf.text(`Subtotal: ₹${document.getElementById("subtotal").innerText}`, 10, y);
    pdf.text(`Discount: ₹${document.getElementById("discount").innerText}`, 10, y + 10);
    pdf.text(`Tax: ₹${document.getElementById("tax").innerText}`, 10, y + 20);
    pdf.setFontSize(14);
    pdf.text(`Total: ₹${document.getElementById("total").innerText}`, 10, y + 30);
    pdf.save("Dairy_Delight_Bill.pdf");
}

// Open and close payment modal
function openPaymentModal() {
    document.getElementById("payment-modal").style.display = "block";
}
function closePaymentModal() {
    document.getElementById("payment-modal").style.display = "none";
}

// Function to confirm the order and send data to backend
function confirmOrder() {
    let paymentMethod = document.querySelector('input[name="payment"]:checked');

    if (!paymentMethod) {
        alert("Please select a payment method!");
        return;
    }

    let orderDetails = {
        products: cart.map(item => ({
            name: item.name,
            price: item.price,
            quantity: item.quantity,
            total: (item.price * item.quantity).toFixed(2)
        })),
        total: document.getElementById("total").innerText,
        paymentMethod: paymentMethod.value
    };

    console.log("Sending Order Details:", JSON.stringify(orderDetails));
    
    // Redirect to order.html with order details stored in localStorage
    localStorage.setItem("pendingOrder", JSON.stringify(orderDetails));
    window.location.href = "order.html";
}
