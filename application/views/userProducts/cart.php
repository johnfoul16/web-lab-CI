<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php include('header.html')?>
    </header>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 fw-bold text-center">YOUR SHOPPING CART</h2>
                
                <?php if (empty($cart)): ?>
                    <div class="alert alert-info">
                        <p class="mb-0">Your cart is empty.</p>
                    </div>
                    <div class="mt-4">
                        <a href="<?= site_url('shop'); ?>" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm mb-4">
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
                                    foreach ($cart as $item): 
                                        $total = $item['qty'] * $item['price'];
                                        $grand_total += $total;
                                    ?>
                                    <tr>
                                        <td class="align-middle"><?= $item['name']; ?></td>
                                        <td class="text-center align-middle"><?= $item['qty']; ?></td>
                                        <td class="text-end align-middle">₱<?= number_format($item['price'], 2); ?></td>
                                        <td class="text-end align-middle">₱<?= number_format($total, 2); ?></td>
                                        <td class="text-center align-middle">
                                            <a href="<?= site_url('ShopController/removeFromCart/' . $item['id']); ?>" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i>Remove
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                        <td class="text-end fw-bold">₱<?= number_format($grand_total, 2); ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <a href="<?= site_url('shop'); ?>" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#checkoutForm">
                                Proceed to Checkout<i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="collapse mt-4" id="checkoutForm">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">Checkout Information</h3>
                            </div>
                            <div class="card-body">
                                <form action="<?= site_url('ShopController/completePayment'); ?>" method="post">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Delivery Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="" selected disabled>Select payment method</option>
                                            <option value="cod">Cash on Delivery</option>
                                            <option value="gcash">GCash</option>
                                            <option value="paypal">PayPal</option>
                                        </select>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>