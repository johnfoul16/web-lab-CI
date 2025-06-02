<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php include('header.html')?>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                                <i class="bi bi-check-lg" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        
                        <h2 class="mb-4 fw-bold text-success"><?= $message ?></h2>
                        
                        <div class="alert alert-light border text-start mb-4">
                            <h5 class="mb-3 text-center">ORDER DETAILS</h5>
                            <div class="mb-2 row">
                                <div class="col-4 fw-bold">Name:</div>
                                <div class="col-8"><?= $name ?></div>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-4 fw-bold">Address:</div>
                                <div class="col-8"><?= $address ?></div>
                            </div>
                            <div class="row">
                                <div class="col-4 fw-bold">Payment Method:</div>
                                <div class="col-8">
                                    <?php
                                    $icon = '';
                                    switch($payment_method) {
                                        case 'cod':
                                            $icon = '<i class="bi bi-cash-coin me-2"></i>';
                                            $payment_method = 'Cash on Delivery';
                                            break;
                                        case 'gcash':
                                            $icon = '<i class="bi bi-wallet2 me-2"></i>';
                                            $payment_method = 'GCash';
                                            break;
                                        case 'paypal':
                                            $icon = '<i class="bi bi-paypal me-2"></i>';
                                            $payment_method = 'PayPal';
                                            break;
                                    }
                                    echo $icon . $payment_method;
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="<?= site_url('ShopController/shop') ?>" class="btn btn-primary">
                                <i class="bi bi-cart me-2"></i>Continue Shopping
                            </a>
                            <a href="<?= site_url('ShopController/orderHistory') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-clock-history me-2"></i>Order History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>