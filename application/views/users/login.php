<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            display: flex;
            width: 800px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .brand-section {
            flex: 1;
            background-color: #3E5A69;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .brand-name {
            font-size: 32px;
            font-weight: bold;
            color: white;
            text-align: center;
        }
        
        .form-section {
            flex: 1;
            padding: 30px;
        }
        
        h2 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error { 
            color: #e74c3c;
            background-color: #fadbd8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        
        label { 
            display: block; 
            margin-bottom: 8px;
            color: #34495e;
            font-weight: bold;
        }
        
        input[type="text"], 
        input[type="email"], 
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus, 
        input[type="email"]:focus, 
        input[type="password"]:focus {
            border-color: #3E5A69;
            outline: none;
            box-shadow: 0 0 5px rgba(62, 90, 105, 0.3);
        }
        
        input[type="submit"] {
            background-color: #3E5A69;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        input[type="submit"]:hover {
            background-color: rgb(255, 202, 29);
        }
        
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .register-link a {
            color: #3E5A69;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-section">
            <i class="bi bi-lightning-fill" style="color: yellow; font-size: 32px; margin-right: 10px;"></i>
            <div class="brand-name">TechSnap</div>
        </div>
        
        <div class="form-section">
            <h2>Login</h2>
            
            <?php echo validation_errors('<div class="error">', '</div>'); ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="error"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo site_url('login'); ?>">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                
                <div class="form-group">
                    <input type="submit" value="Login">
                </div>
                
                <div class="register-link">
                    Don't have an account? <a href="<?php echo site_url('register'); ?>">Register here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>