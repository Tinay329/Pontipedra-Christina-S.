function togglePassword() {
    const passField = document.getElementById('password');
    const toggleText = document.querySelector('.toggle-pass');
    if (passField.type === 'password') {
        passField.type = 'text';
        toggleText.textContent = 'Hide';
    } else {
        passField.type = 'password';
        toggleText.textContent = 'Show';
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    const studentID = document.getElementById('studentID').value.trim();
    const password = document.getElementById('password').value.trim();
    const msgBox = document.getElementById('messageBox');

    if (!studentID || !password) {
        e.preventDefault();
        msgBox.textContent = 'Please enter both Student ID and Password!';
        msgBox.className = 'message error';
        msgBox.style.display = 'block';
    }
});

window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('error') === '1') {
        const msgBox = document.getElementById('messageBox');
        msgBox.textContent = 'Invalid Student ID or Password!';
        msgBox.className = 'message error';
        msgBox.style.display = 'block';
    }
};