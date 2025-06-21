<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-card {
            max-width: 600px;
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
        .btn-secondary-custom {
            background-color: #6c757d; /* Bootstrap secondary */
            color: white;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        }
        .btn-secondary-custom:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(108, 117, 125, 0.4);
        }
    </style>
</head>
<body>
    <header>
        <?php $this->load->view('header'); ?>
    </header>

    <div class="container main-content py-5">
        <div class="profile-card">
            <h2 class="text-primary"><i class="bi bi-person-circle me-2"></i>My Profile</h2>

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

            <form method="post" action="<?= site_url('profile'); ?>">
                <!-- CSRF Token: CRITICAL for security -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?= set_value('username', $user['username'] ?? ''); ?>" required>
                    <?php echo form_error('username', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= set_value('email', $user['email'] ?? ''); ?>" required>
                    <?php echo form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <!-- Add more profile fields here if applicable (e.g., name, address) -->
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">Update Profile</button>
                    <a href="<?= site_url('change_password'); ?>" class="btn btn-secondary-custom btn-lg rounded-pill px-4 py-2 shadow">Change Password</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
