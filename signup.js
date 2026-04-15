document.getElementById("signup-form").addEventListener("submit", async function (event) {
    event.preventDefault();

    let fullName = document.getElementById("fullname").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    let errorMessage = document.getElementById("error-message");

    errorMessage.innerText = ""; // Clear previous errors

    if (fullName === "" || email === "" || password === "" || confirmPassword === "") {
        errorMessage.innerText = "All fields are required!";
        return;
    }

    if (password.length < 6) {
        errorMessage.innerText = "Password must be at least 6 characters long!";
        return;
    }

    if (password !== confirmPassword) {
        errorMessage.innerText = "Passwords do not match!";
        return;
    }

    let userData = { 
        full_name: fullName, 
        email: email, 
        password: password 
    };

    console.log("🔹 Sending Data:", JSON.stringify(userData)); // ✅ Debugging log

    try {
        let response = await fetch("signup.php", {
            method: "POST",
            headers: { 
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify(userData)
        });

        let textResponse = await response.text();
        console.log("🔹 Raw Response Text:", textResponse); // ✅ Log raw response for debugging

        let jsonData;
        try {
            jsonData = JSON.parse(textResponse); // ✅ Parse response safely
        } catch (parseError) {
            console.error("JSON Parse Error:", parseError);
            errorMessage.innerText = "Server returned an unexpected response.";
            return;
        }

        console.log("🔹 Parsed JSON:", jsonData); // ✅ Log parsed JSON

        if (jsonData.success) {
            alert("Sign-Up Successful! A welcome email has been sent.");
            setTimeout(() => {
                window.location.href = "login.html"; // ✅ Redirect after a short delay
            }, 2000);
        } else {
            errorMessage.innerText = jsonData.message || "Signup failed!";
        }
    } catch (error) {
        console.error("Fetch Error:", error);
        errorMessage.innerText = "An error occurred. Please try again.";
    }
});
