<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order History</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        .table thead th {
            white-space: nowrap; /* Prevent headers from wrapping too much */
        }
    </style>
</head>
<body>
    <header>
        <!-- Include the header.html file here. Recommended to load views using CodeIgniter's view loader: -->
        <?php $this->load->view('header'); // Assuming header.html is header.php in your views folder ?>
    </header>

    <!-- The get_status_badge_class() function definition HAS BEEN REMOVED from here.
         It should now be defined ONLY in application/helpers/app_helpers_helper.php -->

    <div class="container main-content py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="mb-4 fw-bold text-center text-primary">
                            <i class="bi bi-clock-history me-2"></i>My Order History
                        </h2>
                        
                        <?php if (empty($orders)): ?>
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-bag-fill text-secondary" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="text-secondary mb-3">You haven't placed any orders yet.</h4>
                                <p class="mb-4 text-muted">Visit our shop to explore products and start shopping!</p>
                                <a href="<?= site_url('shop') ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">
                                    <i class="bi bi-cart me-2"></i>Go to Shop
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive rounded-3 overflow-hidden border shadow-sm">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Payment Method</th>
                                            <th>Shipping Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Ensure $orders is an array, even if empty
                                        $orders = is_array($orders) ? $orders : [];
                                        foreach ($orders as $order): 
                                            $order_items = json_decode($order['order_data'] ?? '[]', true); // Decode safely
                                            
                                            // Calculate total
                                            $total = 0;
                                            if (is_array($order_items)) { // Ensure it's an array after decoding
                                                foreach ($order_items as $item) {
                                                    $total += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
                                                }
                                            }
                                            
                                            // Set payment method icon and display name
                                            $icon = '';
                                            $payment_method_raw = $order['payment_method'] ?? 'N/A';
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
                                            <tr>
                                                <td class="align-middle"><strong>#<?= htmlspecialchars($order['id'] ?? 'N/A') ?></strong></td>
                                                <td class="align-middle"><?= date('M d, Y h:i A', strtotime($order['created_at'] ?? 'now')) ?></td>
                                                <td class="align-middle">
                                                    <?php 
                                                    $item_count = is_array($order_items) ? count($order_items) : 0;
                                                    echo htmlspecialchars($item_count) . ' ' . ($item_count !== 1 ? 'items' : 'item');
                                                    ?>
                                                </td>
                                                <td class="align-middle"><strong>₱<?= number_format($total, 2) ?></strong></td>
                                                <td class="align-middle">
                                                    <span class="badge bg-light text-dark border py-2 px-3 rounded-pill">
                                                        <?= $icon . htmlspecialchars($payment_display) ?>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge <?= get_status_badge_class($order['shipping_status'] ?? 'Processing'); ?> py-2 px-3 rounded-pill">
                                                        <?= htmlspecialchars($order['shipping_status'] ?? 'Processing'); ?>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="<?= site_url('order_history/' . ($order['id'] ?? '')) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="bi bi-eye me-2"></i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        
                        <div class="d-flex justify-content-center mt-4">
                            <a href="<?= site_url('shop') ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">
                                <i class="bi bi-cart me-2"></i>Continue Shopping
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
