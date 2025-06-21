<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif; /* Consistent font as in other views */
        }
        
        .navbar-brand {
            font-weight: 700; /* Bolder for brand */
            transition: all 0.3s ease-in-out;
            color: #ffffff !important; /* Ensure brand color is white */
        }
        
        .navbar-brand:hover {
            transform: translateY(-2px) scale(1.02); /* Slight lift and scale on hover */
            color: yellow !important; /* Consistent hover color */
        }

        .nav-link {
            color: #ffffff; /* Default nav link color */
            transition: color 0.3s ease, transform 0.2s ease;
            font-weight: 500; /* Medium weight for clarity */
            padding-left: 1rem !important; /* Adjust padding for spacing */
            padding-right: 1rem !important; /* Adjust padding for spacing */
        }
    
        .nav-link:hover {
            color: yellow; /* Hover color */
            transform: translateY(-1px);
        }

        /* Specific styles for icons in nav links */
        .nav-link .bi {
            font-size: 1.2rem; /* Make icons slightly larger than text for visibility */
            vertical-align: middle; /* Align icons nicely with text */
        }

        /* Highlight active link if needed - requires JS or server-side logic */
        .nav-item .nav-link.active {
            color: yellow !important;
            font-weight: 600;
        }

        /* Ensure dropdown menu text is readable */
        .dropdown-menu {
            background-color: #3E5A69; /* Match navbar background */
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .dropdown-item {
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(255, 255, 0, 0.2); /* Light yellow transparent hover */
            color: yellow;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #3E5A69;">
        <div class="container-fluid"> <!-- Changed to container-fluid for better full-width responsiveness -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo site_url('dashboard'); ?>">
                <i class="bi bi-lightning-fill me-2" style="color: yellow"></i>
                TechSnap
            </a>
            
            <!-- Navbar Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"> <!-- ms-auto pushes nav links to the right -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('dashboard'); ?>"> <i class="bi bi-house-door-fill me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('shop'); ?>"><i class="bi bi-shop-window me-1"></i>Shop</a>
                    </li>
                    <!-- Conditionally display "Products" and "Reports" links ONLY for admin -->
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('products'); ?>"><i class="bi bi-box-seam-fill me-1"></i>Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('reports'); ?>"><i class="bi bi-graph-up-arrow me-1"></i>Reports</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('cart'); ?>">
                                <i class="bi bi-cart3 fs-5 me-1"></i>Cart
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('order_history'); ?>">
                                <i class="bi bi-clock-history fs-5 me-1"></i>History
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 me-1"></i><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- Removed redundant Dashboard link from dropdown, as "Home" serves as the main dashboard link -->
                                <li><a class="dropdown-item" href="<?= site_url('profile'); ?>"><i class="bi bi-person-badge me-2"></i>My Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= site_url('logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('login'); ?>"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('register'); ?>"><i class="bi bi-person-plus-fill me-1"></i>Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
