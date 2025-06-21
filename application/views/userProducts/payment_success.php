<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful!</title>
    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css](https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css)">

    <style>
        body {
            padding-top: 56px; /* Adjust for fixed header, if any */
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; /* Using 'Inter' for consistency */
            min-height: 100vh; /* Ensure full height for sticky footer if needed */
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
            flex: 1; /* Allows main content to grow and push footer down */
        }
        .success-card {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        /* Adjusted icon styling to match the provided layout */
        .success-icon-container {
            width: 90px;
            height: 90px;
            background-color: #28a745; /* Bootstrap success color */
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .success-icon {
            font-size: 3rem; /* Adjusted font size for checkmark */
        }
    </style>
</head>
<body>
    <header>
        <!-- Include the header.html file here. Recommended to load views using CodeIgniter's view loader: -->
        <?php $this->load->view('header'); // Assuming header.html is header.php in your views folder ?>
    </header>

    <div class="container main-content py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="success-icon-container">
                                <i class="bi bi-check-lg success-icon"></i>
                            </div>
                        </div>
                        
                        <h2 class="mb-4 fw-bold text-success"><?= htmlspecialchars($message ?? 'Payment Successful!') ?></h2>
                        
                        <div class="alert alert-light border text-start mb-4 rounded-3 p-4">
                            <h5 class="mb-3 text-center text-primary fw-bold">ORDER DETAILS</h5>
                            <div class="mb-2 row">
                                <div class="col-4 fw-bold">Name:</div>
                                <div class="col-8"><?= htmlspecialchars($name ?? 'N/A') ?></div>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-4 fw-bold">Address:</div>
                                <div class="col-8"><?= htmlspecialchars($address ?? 'N/A') ?></div>
                            </div>
                            <div class="row">
                                <div class="col-4 fw-bold">Payment Method:</div>
                                <div class="col-8">
                                    <?php
                                    // Make sure $payment_method is defined, or provide a default
                                    $current_payment_method = htmlspecialchars($payment_method ?? 'N/A');
                                    $icon = '';
                                    switch(strtolower($current_payment_method)) { // Normalize for consistent matching
                                        case 'cod':
                                            $icon = '<i class="bi bi-cash-coin me-2"></i>';
                                            $current_payment_method = 'Cash on Delivery';
                                            break;
                                        case 'gcash':
                                            $icon = '<i class="bi bi-phone-fill me-2"></i>'; // More generic phone icon for GCash
                                            $current_payment_method = 'GCash';
                                            break;
                                        case 'paypal':
                                            $icon = '<i class="bi bi-paypal me-2"></i>';
                                            $current_method = 'PayPal';
                                            break;
                                        default:
                                            $icon = '<i class="bi bi-credit-card me-2"></i>';
                                            // If it's not one of the cases, just use the raw value (which is already escaped)
                                            break;
                                    }
                                    echo $icon . $current_payment_method;
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="<?= site_url('ShopController/shop') ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">
                                <i class="bi bi-cart me-2"></i>Continue Shopping
                            </a>
                            <a href="<?= site_url('ShopController/orderHistory') ?>" class="btn btn-outline-secondary btn-lg rounded-pill px-4 py-2">
                                <i class="bi bi-clock-history me-2"></i>Order History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
  
 <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
