<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px; /* Space for fixed navbar */
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; /* Consistent font */
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .content-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .page-title {
            margin-bottom: 2.5rem;
            color: #333;
            text-align: center;
            font-weight: bold;
        }
        .user-table th {
            background-color: #e9ecef;
            border-bottom: 1.5px solid #dee2e6;
        }
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block; /* Ensure it's visible when needed */
        }
    </style>
</head>
<body>
    <header>
        <?php $this->load->view('header'); ?>
    </header>

    <div class="content-container">
        <h2 class="page-title text-primary"><i class="bi bi-people-fill me-2"></i>MANAGE USERS</h2>

        <!-- Display flash data messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php 
            // Display validation errors passed from the controller, if any
            if (isset($validation_errors) && $validation_errors): 
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $validation_errors; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <div class="table-responsive rounded-3 overflow-hidden shadow-sm border">
            <table class="table table-bordered table-striped table-hover user-table">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="align-middle"><?= htmlspecialchars($user['id'] ?? 'N/A'); ?></td>
                            <td class="align-middle fw-bold"><?= htmlspecialchars($user['username'] ?? 'N/A'); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                            <td class="align-middle">
                                <span class="badge <?= (strtolower($user['role'] ?? '') === 'admin') ? 'bg-primary' : 'bg-secondary'; ?>">
                                    <?= htmlspecialchars(ucfirst($user['role'] ?? 'N/A')); ?>
                                </span>
                            </td>
                            <td class="align-middle"><?= date('M d, Y h:i A', strtotime($user['created_at'] ?? 'now')); ?></td>
                            <td class="align-middle text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- Edit User Button - Triggers Modal -->
                                    <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 edit-user-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editUserModal"
                                            data-user-id="<?= htmlspecialchars($user['id'] ?? '') ?>" 
                                            data-username="<?= htmlspecialchars($user['username'] ?? '') ?>"
                                            data-email="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                            data-role="<?= htmlspecialchars($user['role'] ?? '') ?>">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </button>
                                    
                                    <!-- Delete User Button (Triggers Modal) -->
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" 
                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal" 
                                            data-user-id="<?= htmlspecialchars($user['id'] ?? '') ?>" 
                                            data-username="<?= htmlspecialchars($user['username'] ?? '') ?>"
                                            <?= ($this->session->userdata('user_id') == ($user['id'] ?? '')) ? 'disabled' : '' ?>>
                                        <i class="bi bi-trash-fill me-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editUserModalLabel"><i class="bi bi-person-fill-gear me-2"></i>Edit User: <span id="modalEditUsername"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="post" action="">
                    <div class="modal-body">
                        <!-- CSRF Token -->
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" id="editUserId" name="id">

                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editPassword" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>

                        <div class="mb-3">
                            <label for="editPasswordConfirm" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="editPasswordConfirm" name="password_confirm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4">
                            <i class="bi bi-save me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteUserModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete user "<strong id="modalDeleteUsername"></strong>" (ID: <span id="modalDeleteUserId"></span>)? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="post" action="">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Delete User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
 <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // JavaScript for Delete User Modal
            const deleteUserModal = document.getElementById('deleteUserModal');
            if (deleteUserModal) {
                deleteUserModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    const userId = button.getAttribute('data-user-id');
                    const username = button.getAttribute('data-username');
                    
                    const modalUserIdSpan = deleteUserModal.querySelector('#modalDeleteUserId');
                    const modalUsernameStrong = deleteUserModal.querySelector('#modalDeleteUsername');
                    const deleteUserForm = deleteUserModal.querySelector('#deleteUserForm');

                    modalUserIdSpan.textContent = userId;
                    modalUsernameStrong.textContent = username;
                    deleteUserForm.action = '<?= site_url("admin/users/delete/"); ?>' + userId;
                });
            }

            // JavaScript for Edit User Modal
            const editUserModal = document.getElementById('editUserModal');
            if (editUserModal) {
                editUserModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    const userId = button.getAttribute('data-user-id');
                    const username = button.getAttribute('data-username');
                    const email = button.getAttribute('data-email');
                    const role = button.getAttribute('data-role');

                    // Populate modal title
                    const modalEditUsername = editUserModal.querySelector('#modalEditUsername');
                    modalEditUsername.textContent = username;

                    // Populate form fields
                    const editUserForm = editUserModal.querySelector('#editUserForm');
                    editUserForm.action = '<?= site_url("admin/users/update/"); ?>' + userId; // Set form action
                    
                    editUserForm.querySelector('#editUserId').value = userId;
                    editUserForm.querySelector('#editUsername').value = username;
                    editUserForm.querySelector('#editEmail').value = email;
                    editUserForm.querySelector('#editRole').value = role; // Set selected option for role

                    // Clear password fields on modal open
                    editUserForm.querySelector('#editPassword').value = '';
                    editUserForm.querySelector('#editPasswordConfirm').value = '';
                });

                // Add event listener to clear validation classes on modal hide
                editUserModal.addEventListener('hidden.bs.modal', function () {
                    const form = this.querySelector('form');
                    form.querySelectorAll('.is-invalid').forEach(element => {
                        element.classList.remove('is-invalid');
                    });
                    form.querySelectorAll('.invalid-feedback').forEach(element => {
                        element.remove(); // Remove feedback messages
                    });
                });
            }
        });
    </script>
</body>
</html>
