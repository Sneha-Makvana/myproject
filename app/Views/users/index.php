<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple AJAX CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h4 class="mb-4">CRUD with CodeIgniter</h4>

        <div class="card mb-4">
            <div class="card-header">Add/Edit User</div>
            <div class="card-body">
                <form id="userForm">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            fetchUsers();

            function fetchUsers() {
                $.get('/users/fetch', function(data) {
                    let rows = '';
                    data.forEach(user => {
                        rows += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editUser(${user.id}, '${user.name}', '${user.email}')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    </tr>
                `;
                    });
                    $('#userTableBody').html(rows);
                });
            }

            $('#userForm').submit(function(e) {
                e.preventDefault();
                const id = $('#userId').val();
                const name = $('#name').val();
                const email = $('#email').val();
                const url = id ? `/users/update/${id}` : '/users/create';

                $.post(url, {
                    name,
                    email
                }, function(response) {
                    alert(response.status);
                    $('#userForm')[0].reset();
                    $('#userId').val('');
                    fetchUsers();
                });
            });

            window.editUser = function(id, name, email) {
                $('#userId').val(id);
                $('#name').val(name);
                $('#email').val(email);
            };

            window.deleteUser = function(id) {
                if (confirm('Are you sure?')) {
                    $.get(`/users/delete/${id}`, function(response) {
                        alert(response.status);
                        fetchUsers();
                    });
                }
            };
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>