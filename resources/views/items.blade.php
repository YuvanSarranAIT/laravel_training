<!DOCTYPE html>
<html>
<head>
    <title>Items</title>
</head>
<body>
<h2>Item List</h2>

<button onclick="logout()">Logout</button>

<form id="itemForm">
    <input type="text" name="title" placeholder="Title" required />
    <input type="text" name="description" placeholder="Description" required />
    <button type="submit">Add Item</button>
</form>

<ul id="itemsList"></ul>

<p id="statusMsg" style="color: red;"></p>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const token = localStorage.getItem('token');

    if (!token) {
        alert("You must be logged in first.");
        window.location.href = '/login';
    }

    const api = axios.create({
        baseURL: '/api',
        headers: {
            Authorization: `Bearer ${token}`
        }
    });

    async function fetchItems() {
        try {
            const res = await api.get('/items');
            const list = document.getElementById('itemsList');
            list.innerHTML = '';

            res.data.forEach(item => {
                list.innerHTML += `
                    <li>
                        <strong>${item.title}</strong> - ${item.description}
                        <button onclick="editItem(${item.id}, '${item.title}', '${item.description}')">Edit</button>
                        <button onclick="deleteItem(${item.id})">Delete</button>
                    </li>
                `;
            });
        } catch (err) {
            document.getElementById('statusMsg').innerText = "Failed to load items.";
        }
    }

    document.getElementById('itemForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = new FormData(e.target);
        const data = Object.fromEntries(form.entries());

        try {
            await api.post('/items', data);
            e.target.reset();
            fetchItems();
        } catch (err) {
            document.getElementById('statusMsg').innerText = "Failed to add item.";
        }
    });

    async function deleteItem(id) {
        if (!confirm("Are you sure you want to delete this item?")) return;

        try {
            await api.delete(`/items/${id}`);
            fetchItems();
        } catch (err) {
            alert('Delete failed.');
        }
    }

    function editItem(id, oldTitle, oldDesc) {
        const newTitle = prompt("Edit title:", oldTitle);
        const newDesc = prompt("Edit description:", oldDesc);
        if (!newTitle || !newDesc) return;

        api.put(`/items/${id}`, { title: newTitle, description: newDesc })
            .then(fetchItems)
            .catch(() => alert('Update failed.'));
    }

    function logout() {
        localStorage.removeItem('token');
        window.location.href = '/login';
    }

    fetchItems();
</script>
</body>
</html>
