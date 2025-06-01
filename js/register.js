const form = document.getElementById('signup-form');
const errortxt = document.querySelector('.error-text');
submitbtn = form.querySelector('.submit input'),

form.onsubmit = (e) => {
    e.preventDefault(); // Prevent default form submission
}

// Handle the button click for form submission
form.querySelector('.submit input').onclick = () => {
    const formData = new FormData(form); // Gather form data

    let xhr = new XMLHttpRequest(); // Create XML object
    xhr.open("POST", "./Php/register.php", true); // Send data to signup.php
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const data = xhr.responseText;
                if (data === "success") {
                    location.href = "./verify.php"; // Redirect to verify.php if signup is successful
                } else {
                    errortxt.textContent = data;
                    errortxt.style.display = "block"; // Show error message if there's an issue
                }
            }
        }
    }

    xhr.send(formData); // Send form data to PHP via AJAX
}
