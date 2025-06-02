<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php include('header.html') ?>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold mb-0">
                                <i class="bi bi-receipt me-2"></i>Order #<?= $order['id'] ?>
                            </h2>
                            <span class="badge bg-secondary">Processing</span>
                        </div>
                        
                        <div class="mb-4 text-muted">
                            <i class="bi bi-calendar3 me-2"></i>Placed on: <?= date('F d, Y h:i A', strtotime($order['created_at'])) ?>
                        </div>
                        
                        <div class="table-responsive mb-4">
                            <table class="table">
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
                                    $total = 0;
                                    foreach ($order_items as $item): 
                                        $subtotal = $item['price'] * $item['qty'];
                                        $total += $subtotal;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?= $item['name'] ?></div>
                                            </td>
                                            <td class="text-center">$<?= number_format($item['price'], 2) ?></td>
                                            <td class="text-center"><?= $item['qty'] ?></td>
                                            <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td class="text-end fw-bold">$<?= number_format($total, 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Shipping Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="fw-bold">Name:</span> <?= $order['customer_name'] ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold">Address:</span> <?= $order['address'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Payment Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <?php
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
                                            <span class="fw-bold">Method:</span> <?= $icon . $payment_display ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold">Status:</span> <span class="text-success">Paid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= site_url('ShopController/orderHistory') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Order History
                    </a>
                    <a href="<?= site_url('ShopController/shop') ?>" class="btn btn-primary">
                        <i class="bi bi-cart me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>