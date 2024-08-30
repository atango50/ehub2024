document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');
    const verifyForm = document.getElementById('verifyForm');
    const messageDiv = document.getElementById('message');

    function handleFormSubmit(form, url, isJSON = false) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            let body = isJSON ? JSON.stringify(Object.fromEntries(formData)) : formData;
            let headers = isJSON ? { 'Content-Type': 'application/json' } : {};

            fetch(url, {
                method: 'POST',
                body: body,
                headers: headers
            })
            .then(response => response.text())
            .then(text => {
                console.log("Réponse brute du serveur:", text);
                return JSON.parse(text);
            })
            .then(data => {
                messageDiv.style.display = 'block';
                if (data.success) {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message success';
                    form.reset();
                    
                    if (form === signupForm && data.redirect) {
                        localStorage.setItem('verificationEmail', formData.get('email'));
                        setTimeout(() => window.location.href = data.redirect, 2000);
                    } else if (form === loginForm && data.token) {
                        localStorage.setItem('token', data.token);
                        localStorage.setItem('username', data.username);
                        // Redirection si nécessaire pour le login
                        setTimeout(() => window.location.href = 'compte_utilisateur.php', 2000);
                    } else if (form === verifyForm) {
                        setTimeout(() => window.location.href = 'login.php', 2000);
                    }
                } else {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message error';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.textContent = 'Une erreur s\'est produite. Veuillez réessayer.';
                messageDiv.className = 'message error';
                messageDiv.style.display = 'block';
            });
        });
    }

    if (signupForm) handleFormSubmit(signupForm, '../backend/signup.php');
    if (loginForm) handleFormSubmit(loginForm, '../backend/login.php', true);
    if (verifyForm) handleFormSubmit(verifyForm, '../backend/verify.php', true);
});
