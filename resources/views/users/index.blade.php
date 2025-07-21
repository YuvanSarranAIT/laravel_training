<!DOCTYPE html>
<html>

<head>
    <title>Laravel AJAX CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2>User CRUD (AJAX, Validation, Modal)</h2>
        <button class="btn btn-primary mb-3" onclick="openModal()">Add User</button>

        <table class="table table-bordered table-striped" id="userTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Role</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr id="row-{{ $user->id }}">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phonenumber }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->dob }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editUser({{ $user->id }})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="userForm" class="modal-content">
                <input type="hidden" name="id" id="user_id">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit User</h5>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input name="phonenumber" type="tel" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Address</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label>City</label>
                        <select name="city" class="form-select">
                            <option>Chennai</option>
                            <option>Bangalore</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>State</label>
                        <select name="state" class="form-select">
                            <option>Tamil Nadu</option>
                            <option>Karnataka</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Country</label>
                        <select name="country" class="form-select">
                            <option>India</option>
                            <option>USA</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Zipcode</label>
                        <input name="zipcode" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Role</label>
                        <input name="role" type="number" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Gender</label><br>
                        <input type="radio" name="gender" value="male"> Male
                        <input type="radio" name="gender" value="female"> Female
                    </div>
                    <div class="col-md-6">
                        <label>DOB</label>
                        <input name="dob" type="date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        let modal = new bootstrap.Modal(document.getElementById('userModal'));

        $('#userTable').DataTable();

        function openModal() {
            $('#userForm')[0].reset();
            $('#user_id').val('');
            modal.show();
        }

        $('#userForm').submit(function (e) {
            e.preventDefault();
            $.post("{{ route('user.store') }}", $(this).serialize(), function (data) {
                if (data.errors) {
                    alert(Object.values(data.errors).join("\n"));
                } else {
                    location.reload();
                }
            });
        });

        function editUser(id) {
            $.get(`/user/edit/${id}`, function (user) {
                for (let key in user) {
                    $(`[name="${key}"]`).val(user[key]);
                }
                modal.show();
            });
        }

        function deleteUser(id) {
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    url: `/user/delete/${id}`,
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        if (res.success) {
                            $(`#row-${id}`).remove();
                        } else {
                            alert("Failed to delete");
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>