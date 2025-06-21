<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px; /* Space for fixed navbar */
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
        .page-title {
            margin-bottom: 2.5rem;
            color: #333;
            text-align: center;
            font-weight: bold;
        }
        .report-card {
            min-height: 180px; /* Increased height for better spacing */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            padding: 1.5rem; /* Add some padding */
        }
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15); /* More pronounced shadow on hover */
        }
        .report-card .display-4 {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .report-card .fs-5 {
            opacity: 0.9;
        }
        .report-card .h3 {
            margin-top: 0.75rem;
            font-size: 2.2rem; /* Larger value font size */
        }
        .table thead th {
            white-space: nowrap; /* Prevent headers from wrapping too much */
        }
    </style>
</head>
<body>
    <header>
        <?php $this->load->view('header'); ?>
    </header>

    <div class="container main-content py-5">
        <h2 class="page-title text-primary"><i class="bi bi-graph-up-arrow me-2"></i>ADMIN REPORTS</h2>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="report-card bg-success">
                    <div class="display-4"><i class="bi bi-currency-dollar"></i></div>
                    <div class="fs-5 mt-2">Total Sales</div>
                    <div class="h3 mb-0">₱<?= number_format($total_sales ?? 0, 2); ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card bg-info text-dark">
                    <div class="display-4"><i class="bi bi-cart-check"></i></div>
                    <div class="fs-5 mt-2">Total Orders</div>
                    <div class="h3 mb-0"><?= $total_orders ?? 0; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card bg-primary">
                    <div class="display-4"><i class="bi bi-person-fill"></i></div>
                    <div class="fs-5 mt-2">Total Users</div>
                    <div class="h3 mb-0"><?= $total_users ?? 0; ?></div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-light rounded-top-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Orders</h5>
                    </div>
                    <div class="table-responsive rounded-bottom-3 overflow-hidden">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_orders)): ?>
                                    <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($order['id'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?></td>
                                        <td>₱<?= number_format($order['total_amount'] ?? 0, 2) ?></td>
                                        <td><span class="badge <?= get_status_badge_class($order['shipping_status'] ?? 'Pending'); ?>"><?= ucfirst(htmlspecialchars($order['shipping_status'] ?? 'Pending')) ?></span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No recent orders.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-light rounded-top-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-star-fill me-2"></i>Top Selling Products</h5>
                    </div>
                    <div class="table-responsive rounded-bottom-3 overflow-hidden">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th class="text-end">Qty Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($top_selling_products)): ?>
                                    <?php foreach ($top_selling_products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['product_name'] ?? 'N/A') ?></td>
                                        <td class="text-end"><?= htmlspecialchars($product['total_qty_sold'] ?? 0) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No top selling products data.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
 <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
