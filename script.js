
// Inject CSS for popup message dynamically
const style = document.createElement("style");
style.innerHTML = `
    .popup-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #ffa726;
        color: #fff;
        padding: 14px 24px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        opacity: 0;
        animation: fadeInOut 3s ease forwards;
        z-index: 9999;
    }
    .popup-message.error {
        background-color: #ff5252;
    }
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-10px); }
        10%, 90% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-10px); }
    }
`;
document.head.appendChild(style);

document.addEventListener("DOMContentLoaded", () => {
    fetchProducts();
    updateCartCount();

    // Attach event listener for search input
    document.getElementById("search").addEventListener("input", searchProducts);
});

document.addEventListener("click", function (event) {
    const target = event.target.closest(".product-link");
    if (target) {
        event.preventDefault();
        window.location.href = target.href;
    }
});

let allProducts = [];

function fetchProducts() {
    fetch("http://localhost:5000/products")
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(products => {
            allProducts = products;
            displayProducts(products);
        })
        .catch(error => console.error("Error fetching products:", error));
}

function displayProducts(products) {
    const productList = document.getElementById("product-list");

    if (!productList) {
        console.error("Error: 'product-list' element not found in HTML.");
        return;
    }

    productList.innerHTML = "";

    if (products.length === 0) {
        productList.innerHTML = "<p>No products found.</p>";
        return;
    }

    products.forEach(product => {
        const productCard = document.createElement("div");
        productCard.classList.add("product");

        productCard.innerHTML = `
            <a href="product.php?id=${product.id}" class="product-link">
                <img src="${product.image}" alt="${product.name}" class="product-image">
            </a>
            <h3>${product.name}</h3>
            <p>Price: ₹${product.price}</p>
            <button onclick="addToCart(${product.id}, '${product.name}', ${product.price})">Add to Cart</button>
        `;

        productList.appendChild(productCard);
    });
}

function searchProducts() {
    const searchText = document.getElementById("search").value.toLowerCase();
    const filteredProducts = allProducts.filter(product =>
        product.name.toLowerCase().includes(searchText)
    );
    displayProducts(filteredProducts);
}

function addToCart(id, name, price) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        showPopupMessage("This item is already in your cart!", true);
        return;
    }

    cart.push({ id, name, price });
    localStorage.setItem("cart", JSON.stringify(cart));

    updateCartCount();
    showPopupMessage(`${name} added to cart successfully!`);
}

function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartCount = document.getElementById("cart-count");
    if (cartCount) {
        cartCount.innerText = cart.length;
    } else {
        console.error("Error: 'cart-count' element not found in HTML.");
    }
}

function showPopupMessage(message, isError = false) {
    const popup = document.createElement("div");
    popup.className = "popup-message";
    if (isError) popup.classList.add("error");
    popup.innerText = message;

    document.body.appendChild(popup);

    setTimeout(() => {
        popup.remove();
    }, 3000);
}

