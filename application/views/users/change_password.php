<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px; /* Space for fixed navbar */
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; /* Consistent font */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .password-card {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: white;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .form-label {
            font-weight: bold;
            color: #34495e;
        }
        .btn-primary {
            background-color: #3E5A69;
            border-color: #3E5A69;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(62, 90, 105, 0.3);
        }
        .btn-primary:hover {
            background-color: #2c3e50;
            border-color: #2c3e50;
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 6px 12px rgba(62, 90, 105, 0.4);
        }
    </style>
</head>
<body>
    <header>
        <?php $this->load->view('header'); ?>
    </header>

    <div class="container py-5">
        <div class="password-card">
            <a class="btn btn-secondary btn-sm mb-3" href="<?php echo site_url('profile'); ?>">
                <i class="bi bi-chevron-double-left"></i> Back to Profile
            </a>
            <h2 class="text-primary"><i class="bi bi-key-fill me-2"></i>Change Password</h2>

            <?php if (validation_errors()): ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors('<p class="mb-0">', '</p>'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('change_password'); ?>">
                <!-- CSRF Token: CRITICAL for security -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                    <?php echo form_error('current_password', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                    <?php echo form_error('new_password', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <div class="mb-4">
                    <label for="new_password_confirm" class="form-label">Confirm New Password:</label>
                    <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" required>
                    <?php echo form_error('new_password_confirm', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
