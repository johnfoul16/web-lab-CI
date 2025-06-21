<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif; /* Consistent font */
            background-color: #e9ecef; /* Lighter background for the entire page */
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Ensure full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            display: flex;
            width: 100%; /* Make it responsive */
            max-width: 800px; /* Limit max width */
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            flex-direction: column; /* Stack vertically on small screens */
        }

        /* Responsive adjustments for larger screens */
        @media (min-width: 768px) {
            .login-container {
                flex-direction: row; /* Side-by-side on larger screens */
            }
        }
        
        .brand-section {
            flex: 1;
            background-color: #3E5A69; /* TechSnap dark blue */
            display: flex;
            flex-direction: column; /* Align icon and text vertically */
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: white;
            text-align: center;
            border-radius: 10px 0 0 10px; /* Rounded left corners */
        }

        @media (max-width: 767.98px) {
            .brand-section {
                border-radius: 10px 10px 0 0; /* Rounded top corners on small screens */
            }
        }
        
        .brand-icon {
            font-size: 4rem; /* Larger icon */
            color: yellow;
            margin-bottom: 15px;
        }

        .brand-name {
            font-size: 2.2rem; /* Larger font size */
            font-weight: bold;
            line-height: 1.2;
        }
        
        .form-section {
            flex: 1;
            padding: 30px;
            display: flex; /* Use flex to align content vertically */
            flex-direction: column;
            justify-content: center; /* Center form content vertically */
        }
        
        h2 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 25px; /* More spacing */
            text-align: center;
            font-weight: bold;
        }
        
        /* Using Bootstrap alert classes for error messages */
        .form-group { 
            margin-bottom: 1rem; /* Consistent Bootstrap spacing */
        }
        
        label { 
            display: block; 
            margin-bottom: 0.5rem; /* Consistent Bootstrap spacing */
            color: #34495e;
            font-weight: bold;
        }
        
        /* Using Bootstrap form-control class for inputs */
        input[type="submit"] {
            background-color: #3E5A69; /* TechSnap dark blue */
            color: white;
            border: none;
            border-radius: 0.375rem; /* Bootstrap's default border-radius */
            padding: 12px 20px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem; /* Consistent font size */
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(62, 90, 105, 0.3); /* Subtle shadow */
        }
        
        input[type="submit"]:hover {
            background-color: rgb(255, 202, 29); /* Yellow on hover */
            transform: translateY(-2px) scale(1.01); /* Slight lift */
            box-shadow: 0 6px 12px rgba(255, 202, 29, 0.4); /* Enhanced shadow */
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95rem;
        }
        
        .register-link a {
            color: #3E5A69; /* TechSnap dark blue */
            text-decoration: none;
            font-weight: bold;
        }
        
        .register-link a:hover {
            text-decoration: underline;
            color: #2c3e50; /* Slightly darker on hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-section">
            <i class="bi bi-lightning-fill brand-icon"></i>
            <div class="brand-name">TechSnap</div>
            <p class="text-white-50 mt-3 d-none d-md-block">Login to manage your account and explore our latest products.</p>
        </div>
        
        <div class="form-section">
            <h2 class="mb-4">Login to your account</h2>
            
            <?php if (validation_errors()): ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors('<p class="mb-0">', '</p>'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo site_url('login'); ?>">
                <!-- CSRF Token: CRITICAL for security -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" required>
                    <?php echo form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <?php echo form_error('password', '<div class="text-danger mt-1">', '</div>'); ?>
                </div>
                
                <div class="d-grid gap-2 mb-3">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>
                
                <div class="register-link">
                    Don't have an account? <a href="<?php echo site_url('register'); ?>">Register here</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
