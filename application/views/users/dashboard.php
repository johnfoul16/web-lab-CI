<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            /* Background image with cover and fixed position for hero section */
            background-image: url('<?php echo base_url("assets/bg.jpg"); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh; /* Ensures the background covers the whole viewport height */
            margin: 0;
            font-family: 'Inter', sans-serif; /* Consistent font */
            display: flex;
            flex-direction: column;
            padding-top: 56px; /* Space for fixed header */
        }
        
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .hero-section {
            flex: 1; /* Allows the hero section to take up remaining space */
            display: flex;
            align-items: center; /* Vertically center content */
            justify-content: flex-start; /* Align content to the start (left) */
            padding-left: 5%; /* Indent from left */
            padding-right: 5%; /* Add some right padding for smaller screens */
            text-align: left; /* Ensure text alignment is left */
            color: white;
        }

        .hero-content {
            max-width: 600px; /* Limit width of content for readability */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Add text shadow for contrast */
        }

        .hero-content h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem); /* Responsive font size */
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }

        .hero-content p {
            font-size: clamp(1rem, 2vw, 1.5rem);
            margin-top: 1rem;
            margin-bottom: 2rem;
        }

        .cta-button {
            font-size: 1.2rem;
            font-weight: bold;
            padding: 12px 25px; /* Larger padding for better touch targets */
            border-radius: 50px; /* More rounded pill shape */
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            display: inline-flex; /* Allows icon and text to align */
            align-items: center;
            justify-content: center;
            gap: 8px; /* Space between icon and text */
        }

        .cta-button-primary {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
        }

        .cta-button-primary:hover {
            background-color: #0056b3;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.6);
        }

        .cta-button-secondary {
            background-color: #3E5A69; /* Original color, can be mapped to Bootstrap secondary if preferred */
            color: white;
            border: 2px solid #3E5A69;
            box-shadow: 0 4px 8px rgba(62, 90, 105, 0.4);
        }

        .cta-button-secondary:hover {
            background-color: #2c3e50;
            border-color: #2c3e50;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 6px 12px rgba(62, 90, 105, 0.6);
        }

        /* Styles for the dashboard widgets */
        .widget-section {
            background-color: #f8f9fa; /* Light background for the widget section */
            padding: 4rem 0; /* More padding */
            border-top: 1px solid #e0e0e0;
        }
        .widget-card {
            min-height: 250px; /* Ensure cards have a consistent minimum height */
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .widget-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .icon-large {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <!-- Include the header.html file here. Recommended to load views using CodeIgniter's view loader: -->
        <?php $this->load->view('header'); // Assuming header.html is header.php in your views folder ?>
    </header>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Level Up Your Gear</h1>
            <h1>with TechSnap!</h1>
            <p class="lead mt-4 mb-5">Discover the latest in electronics and gadgets. Find everything you need to enhance your tech experience.</p>
            <div class="d-flex flex-column flex-sm-row gap-3">
                <a href="<?php echo site_url('shop'); ?>" class="cta-button cta-button-primary">
                    <i class="bi bi-bag-fill"></i> Shop Now
                </a>
                <!-- Conditionally display "Manage" button based on user role -->
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="<?php echo site_url('products'); ?>" class="cta-button cta-button-secondary">
                        <i class="bi bi-gear-fill"></i> Manage Products
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="widget-section">
            <div class="container">
                <h2 class="text-center fw-bold mb-5 text-primary">Admin Dashboard Overview</h2>
                <div class="row g-4 justify-content-center">
                    <!-- Widget 1: Total Orders -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm border-0 rounded-3 widget-card p-4 text-center">
                            <div class="card-body">
                                <i class="bi bi-cart-fill text-info icon-large"></i>
                                <h5 class="card-title fw-bold mb-3">Total Orders</h5>
                                <p class="card-text fs-4 fw-bold text-info"><?= $total_orders ?? 'N/A' ?></p>
                                <p class="text-muted"><small>All time</small></p>
                                <a href="<?= site_url('reports'); ?>" class="btn btn-sm btn-outline-info rounded-pill">View Orders</a>
                            </div>
                        </div>
                    </div>

                    <!-- Widget 2: Total Revenue -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm border-0 rounded-3 widget-card p-4 text-center">
                            <div class="card-body">
                                <i class="bi bi-wallet-fill text-success icon-large"></i>
                                <h5 class="card-title fw-bold mb-3">Total Revenue</h5>
                                <p class="card-text fs-4 fw-bold text-success">₱<?= number_format($total_revenue ?? 0, 2) ?></p>
                                <p class="text-muted"><small>All time</small></p>
                                <a href="<?= site_url('reports'); ?>" class="btn btn-sm btn-outline-success rounded-pill">View Reports</a>
                            </div>
                        </div>
                    </div>

                    <!-- Widget 3: Total Users -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm border-0 rounded-3 widget-card p-4 text-center">
                            <div class="card-body">
                                <i class="bi bi-people-fill text-warning icon-large"></i>
                                <h5 class="card-title fw-bold mb-3">Total Users</h5>
                                <p class="card-text fs-4 fw-bold text-warning"><?= $total_users ?? 'N/A' ?></p>
                                <p class="text-muted"><small>Registered accounts</small></p>
                                <a href="<?= site_url('manage_user'); ?>" class="btn btn-sm btn-outline-warning rounded-pill">Manage Users</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap Bundle with Popper -->
 <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
