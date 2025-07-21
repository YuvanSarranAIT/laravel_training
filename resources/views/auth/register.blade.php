<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<form id="registerForm">
    Name: <input type="text" name="name" /><br />
    Email: <input type="email" name="email" /><br />
    Password: <input type="password" name="password" /><br />
    <button type="submit">Register</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);
    const data = Object.fromEntries(form);

    try {
        const res = await axios.post('/api/register', data);
        alert(res.data.message);
        window.location.href = '/login';
    } catch (err) {
        alert(JSON.stringify(err.response.data));
    }
});
</script>
</body>
</html>
