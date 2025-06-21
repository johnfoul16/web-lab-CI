<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px; /* Space for fixed header */
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; /* Consistent font */
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
        .card-header .badge {
            font-size: 0.9em;
            vertical-align: middle;
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
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <h2 class="fw-bold mb-0 text-primary">
                                <i class="bi bi-receipt me-2"></i>Order #<?= htmlspecialchars($order['id'] ?? 'N/A') ?>
                            </h2>
                            <!-- Status badge - Example: Dynamic based on order status from DB -->
                            <?php 
                                // Call the global helper function
                                $status = htmlspecialchars($order['shipping_status'] ?? 'Processing'); 
                            ?>
                            <span class="badge <?= get_status_badge_class($status); ?> fs-6 py-2 px-3 rounded-pill"><?= ucfirst($status) ?></span>
                        </div>
                        
                        <div class="mb-4 text-muted border-bottom pb-3">
                            <i class="bi bi-calendar3 me-2"></i>Placed on: <?= date('F d, Y h:i A', strtotime($order['created_at'] ?? 'now')) ?>
                        </div>
                        
                        <h4 class="mb-3 fw-bold">Order Items</h4>
                        <div class="table-responsive mb-4 rounded-3 overflow-hidden border">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Make sure $order_items is an array, even if empty
                                    $order_items = is_array($order_items) ? $order_items : [];
                                    $total_amount = 0; // Recalculate total for consistency and validation
                                    if (!empty($order_items)):
                                        foreach ($order_items as $item): 
                                            $subtotal = ($item['price'] ?? 0) * ($item['qty'] ?? 0);
                                            $total_amount += $subtotal;
                                        ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="fw-bold"><?= htmlspecialchars($item['name'] ?? 'N/A') ?></div>
                                                    <?php if (isset($item['description'])): ?><small class="text-muted"><?= htmlspecialchars($item['description']) ?></small><?php endif; ?>
                                                </td>
                                                <td class="text-center align-middle">₱<?= number_format(($item['price'] ?? 0), 2) ?></td>
                                                <td class="text-center align-middle"><?= htmlspecialchars($item['qty'] ?? 0) ?></td>
                                                <td class="text-end align-middle">₱<?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">No items found in this order.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                                        <td class="text-end fw-bold fs-5 text-primary">₱<?= number_format($total_amount, 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100 border-info shadow-sm">
                                    <div class="card-header bg-info text-white rounded-top-3">
                                        <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2"></i>Shipping Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="fw-bold">Name:</span> <?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold">Address:</span> <?= htmlspecialchars($order['address'] ?? 'N/A') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card h-100 border-success shadow-sm">
                                    <div class="card-header bg-success text-white rounded-top-3">
                                        <h5 class="mb-0 fw-bold"><i class="bi bi-wallet-fill me-2"></i>Payment Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <?php
                                            // Handle potential missing 'payment_method' key safely
                                            $payment_method_raw = $order['payment_method'] ?? 'N/A';
                                            $icon = '';
                                            $payment_display = strtolower($payment_method_raw);
                                            switch($payment_display) {
                                                case 'cod':
                                                    $icon = '<i class="bi bi-cash-coin me-2"></i>';
                                                    $payment_display = 'Cash on Delivery';
                                                    break;
                                                case 'gcash':
                                                    $icon = '<i class="bi bi-phone-fill me-2"></i>'; // More generic phone icon for GCash
                                                    $payment_display = 'GCash';
                                                    break;
                                                case 'paypal':
                                                    $icon = '<i class="bi bi-paypal me-2"></i>';
                                                    $payment_display = 'PayPal';
                                                    break;
                                                default:
                                                    $icon = '<i class="bi bi-credit-card me-2"></i>';
                                                    $payment_display = ucfirst($payment_method_raw);
                                                    break;
                                            }
                                            ?>
                                            <span class="fw-bold">Method:</span> <?= $icon . htmlspecialchars($payment_display) ?>
                                        </div>
                                        <div>
                                            <!-- Assuming payment is always successful to view order details here -->
                                            <span class="fw-bold">Status:</span> <span class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i>Paid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="<?= site_url('order_history') ?>" class="btn btn-outline-secondary btn-lg rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-left me-2"></i>Back to Order History
                    </a>
                    <a href="<?= site_url('shop') ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">
                        <i class="bi bi-cart me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
