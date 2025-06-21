<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css](https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css)">
    <style>
        body {
            padding-top: 56px; /* Adjust for fixed header, if any */
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; /* Using 'Inter' for consistency */
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        /* Further custom styles can be added here or converted to Bootstrap classes */
    </style>
</head>
<body>
    <header>
        <!-- Include the header.html file here. It's recommended to load views using CodeIgniter's view loader: -->
        <?php $this->load->view('header'); // Assuming header.html is header.php in your views folder ?>
    </header>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 fw-bold text-center">YOUR SHOPPING CART</h2>
                
                <?php if (empty($cart)): ?>
                    <div class="alert alert-info border-info shadow-sm p-4 text-center rounded-3">
                        <p class="mb-0 fs-5"><i class="bi bi-info-circle me-2"></i>Your cart is empty. Start shopping now!</p>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="<?= site_url('shop'); ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow">
                            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm mb-4 rounded-3">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $grand_total = 0;
                                    foreach ($cart as $item_id => $item): // Ensure $item_id is available for accurate removal
                                        $total = $item['qty'] * $item['price'];
                                        $grand_total += $total;
                                    ?>
                                    <tr>
                                        <td class="align-middle"><?= htmlspecialchars($item['name']); ?></td>
                                        <td class="text-center align-middle"><?= htmlspecialchars($item['qty']); ?></td>
                                        <td class="text-end align-middle">₱<?= number_format($item['price'], 2); ?></td>
                                        <td class="text-end align-middle">₱<?= number_format($total, 2); ?></td>
                                        <td class="text-center align-middle">
                                            <a href="<?= site_url('ShopController/removeFromCart/' . $item_id); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="bi bi-trash me-1"></i>Remove
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                        <td class="text-end fw-bold fs-5">₱<?= number_format($grand_total, 2); ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="<?= site_url('shop'); ?>" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button type="button" class="btn btn-primary rounded-pill px-4 py-2 shadow" data-bs-toggle="collapse" data-bs-target="#checkoutForm" aria-expanded="false" aria-controls="checkoutForm">
                                Proceed to Checkout<i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="collapse mt-4" id="checkoutForm">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-header bg-light rounded-top-3">
                                <h3 class="h5 mb-0 fw-bold"><i class="bi bi-cash-coin me-2"></i>Checkout Information</h3>
                            </div>
                            <div class="card-body">
                                <form action="<?= site_url('ShopController/completePayment'); ?>" method="post">
                                    <!-- CSRF Token: CRITICAL for security -->
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name'); ?>" required>
                                        <?php echo form_error('name', '<div class="text-danger mt-1">', '</div>'); ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Delivery Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" required><?= set_value('address'); ?></textarea>
                                        <?php echo form_error('address', '<div class="text-danger mt-1">', '</div>'); ?>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="" selected disabled>Select payment method</option>
                                            <option value="cod" <?= set_select('payment_method', 'cod'); ?>>Cash on Delivery</option>
                                            <option value="gcash" <?= set_select('payment_method', 'gcash'); ?>>GCash</option>
                                            <option value="paypal" <?= set_select('payment_method', 'paypal'); ?>>PayPal</option>
                                        </select>
                                        <?php echo form_error('payment_method', '<div class="text-danger mt-1">', '</div>'); ?>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 py-2 shadow">
                                            <i class="bi bi-credit-card me-2"></i>Complete Payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
