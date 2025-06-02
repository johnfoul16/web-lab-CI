<?php
function get_status_badge_class($status) {
    switch ($status) {
        case 'Processing':
            return 'bg-secondary';
        case 'Ready to Ship':
            return 'bg-info';
        case 'In Transit':
            return 'bg-primary';
        case 'Out for Delivery':
            return 'bg-warning';
        case 'Delivered':
            return 'bg-success';
        default:
            return 'bg-secondary';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php include('header.html') ?>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="mb-4 fw-bold text-center">
                            <i class="bi bi-clock-history me-2"></i>My Order History
                        </h2>
                        
                        <?php if (empty($orders)): ?>
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-bag text-secondary" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="text-secondary mb-3">You haven't placed any orders yet.</h4>
                                <p class="mb-4">Visit our shop to explore products and start shopping!</p>
                                <a href="<?= site_url('ShopController/shop') ?>" class="btn btn-primary">
                                    <i class="bi bi-cart me-2"></i>Go to Shop
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Shipping Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <?php 
                                            $order_items = json_decode($order['order_data'], true);
                                            // Calculate total
                                            $total = 0;
                                            foreach ($order_items as $item) {
                                                $total += $item['price'] * $item['qty'];
                                            }
                                            
                                            // Set payment method icon
                                            $icon = '';
                                            $payment_display = strtolower($order['payment_method']);
                                            switch($payment_display) {
                                                case 'cod':
                                                    $icon = '<i class="bi bi-cash-coin me-2"></i>';
                                                    $payment_display = 'Cash on Delivery';
                                                    break;
                                                case 'gcash':
                                                    $icon = '<i class="bi bi-wallet2 me-2"></i>';
                                                    $payment_display = 'GCash';
                                                    break;
                                                case 'paypal':
                                                    $icon = '<i class="bi bi-paypal me-2"></i>';
                                                    $payment_display = 'PayPal';
                                                    break;
                                                default:
                                                    $icon = '<i class="bi bi-credit-card me-2"></i>';
                                                    $payment_display = ucfirst($order['payment_method']);
                                            }
                                            ?>
                                            <tr>
                                                <td><strong>#<?= $order['id'] ?></strong></td>
                                                <td><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                                                <td>
                                                    <?php 
                                                    $item_count = count($order_items);
                                                    echo $item_count . ' ' . ($item_count > 1 ? 'items' : 'item');
                                                    ?>
                                                </td>
                                                <td><strong>$<?= number_format($total, 2) ?></strong></td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <?= $icon . $payment_display ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?php echo get_status_badge_class($order['shipping_status']); ?>">
                                                        <?php echo $order['shipping_status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= site_url('ShopController/viewOrder/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary">
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
                            <a href="<?= site_url('ShopController/shop') ?>" class="btn btn-primary">
                                <i class="bi bi-cart me-2"></i>Continue Shopping
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