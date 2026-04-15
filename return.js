document.getElementById('return-form').addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    let product_id = document.getElementById('product_id').value;
    let fault_description = document.getElementById('fault_description').value;
    let fault_image = document.getElementById('fault_image').files[0];

    let errorMessage = document.getElementById('error-message');
    errorMessage.innerText = ""; // Clear any previous error message

    // Create FormData object to send file and data
    let formData = new FormData();
    formData.append('product_id', product_id);
    formData.append('fault_description', fault_description);
    formData.append('fault_image', fault_image);

    try {
        let response = await fetch('return.php', {
            method: 'POST',
            body: formData
        });

        let result = await response.json();

        if (result.success) {
            alert(result.message); // Show success message
            // Redirect to HOME.html after a successful return submission
            window.location.href = "home.php"; // Redirect to HOME.html
        } else {
            errorMessage.innerText = result.message; // Show error message
        }
    } catch (error) {
        console.error("Error:", error);
        errorMessage.innerText = "An error occurred. Please try again.";
    }
});
