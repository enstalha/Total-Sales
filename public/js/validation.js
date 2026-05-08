// validation.js
// basic client-side form validation -- nothing fancy

document.addEventListener('DOMContentLoaded', function () {

    var loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            var usr  = document.getElementById('username').value.trim();
            var pass = document.getElementById('password').value;

            if (!usr || !pass) {
                e.preventDefault();
                alert('Please fill in both fields.');
            }
        });
    }

    var registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            var usr   = document.getElementById('username').value.trim();
            var email = document.getElementById('email').value.trim();
            var pass  = document.getElementById('password').value;

            if (!usr || !email || !pass) {
                e.preventDefault();
                alert('All fields are required.');
                return;
            }

            // basic email format check
            var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            if (!emailOk) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                return;
            }

            if (pass.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters.');
            }
        });
    }

    var addItemForm = document.getElementById('addItemForm');
    if (addItemForm) {
        addItemForm.addEventListener('submit', function (e) {
            var title = document.getElementById('title').value.trim();
            var price = document.getElementById('price').value;

            if (!title) {
                e.preventDefault();
                alert('Item title is required.');
                return;
            }

            if (!price || isNaN(price) || parseFloat(price) <= 0) {
                e.preventDefault();
                alert('Enter a valid price.');
            }
        });
    }

});
