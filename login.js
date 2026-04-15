document.getElementById("login-form").addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let errorMessage = document.getElementById("error-message");

    errorMessage.innerText = ""; // Clear previous error messages

    // Validate that the fields are not empty
    if (email === "" || password === "") {
        errorMessage.innerText = "Both fields are required!";
        return;
    }

    // Prepare the login data
    let userData = { 
        email: email, 
        password: password 
    };

    try {
        // Send the login data to the server
        let response = await fetch("login.php", {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify(userData)
        });

        // Parse the JSON response
        let jsonData = await response.json();

        if (jsonData.success) {
            // If login is successful, redirect to the home page
            alert("Login Successful!");
            window.location.href = "home.php"; // Redirect to home.php
        } else {
            // If login failed, show the error message
            errorMessage.innerText = jsonData.message || "Invalid email or password";
        }
    } catch (error) {
        console.error("Login Error:", error);
        errorMessage.innerText = "An error occurred. Please try again.";
    }
});
