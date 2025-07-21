<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

<form id="loginForm">
    Email: <input type="email" name="email" required /><br />
    Password: <input type="password" name="password" required /><br />
    <button type="submit">Login</button>
</form>

<p id="statusMsg" style="color:red;"></p>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Redirect to /items if already logged in
    if (localStorage.getItem('token')) {
        window.location.href = '/items';
    }

    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const form = new FormData(e.target);
        const data = Object.fromEntries(form.entries());

        try {
            const res = await axios.post('/api/login', data);

            // Save token to localStorage
            localStorage.setItem('token', res.data.token);

            // Redirect to protected route
            window.location.href = '/items';

        } catch (err) {
            const msg = err.response?.data?.error || 'Login failed. Please try again.';
            document.getElementById('statusMsg').innerText = msg;
        }
    });
</script>
</body>
</html>
