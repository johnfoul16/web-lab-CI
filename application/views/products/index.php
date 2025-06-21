<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css](https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css)">
<style>
        body {
            padding-top: 56px; /* Space for fixed navbar */
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; /* Consistent font */
        }
        
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        
        .content-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
            font-weight: bold;
            padding-bottom: 2.5rem;
        }
        
        .add-product-btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #2196F3;
            color: white; 
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        
        .add-product-btn:hover {
            background-color: #0d8bf2;
            transform: scale(1.05);
        }
        
        .product-table {
            border: 2px solid #dee2e6; /* Using Bootstrap's default table border color */
        }
        
        .product-table th {
            background-color: #e9ecef; /* Light gray for table header */
            border-bottom: 1.5px solid #dee2e6; /* Consistent with Bootstrap table borders */
        }
        
        .btn-edit {
            background-color: #ffc107; /* Bootstrap warning color */
            color: white; 
        }
        
        .btn-delete {
            background-color: #dc3545; /* Bootstrap danger color */
            color: white;
        }
        .product-list-image {
            width: 50px; /* Small size for thumbnail in table */
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
    <header>
        <!-- Include the header.php file here. Recommended to load views using CodeIgniter's view loader: -->
        <?php $this->load->view('header'); ?>
    </header>

    <div class="content-container">
        <h2 class="page-title text-primary"><i class="bi bi-box-seam-fill me-2"></i>PRODUCT LISTING</h2>

        <!-- Display flash data messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Add New Product Button (Conditionally display for admin) -->
        <?php if ($this->session->userdata('role') === 'admin'): ?>
            <div class="d-flex justify-content-end mb-3">
                <a href="<?= site_url('products/create'); ?>" class="btn btn-primary add-product-btn rounded-pill px-4 py-2 shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> Add New Product
                </a>
            </div>
        <?php endif; ?>

        <div class="table-responsive rounded-3 overflow-hidden shadow-sm border">
            <table class="table table-bordered table-striped table-hover product-table">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th> <!-- New column for image -->
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Stock</th>
                        <?php if ($this->session->userdata('role') === 'admin'): ?>
                            <th class="text-center">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="align-middle"><?= htmlspecialchars($product['id'] ?? 'N/A'); ?></td>
                            <td class="align-middle">
                                <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
                                    <img src="<?= base_url($product['image_path']); ?>" alt="<?= htmlspecialchars($product['name'] ?? 'Product Image'); ?>" class="product-list-image">
                                <?php else: ?>
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;" title="No Image"></i>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle fw-bold"><?= htmlspecialchars($product['name'] ?? 'N/A'); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($product['description'] ?? 'N/A'); ?></td>
                            <td class="align-middle text-end">₱<?= number_format($product['price'] ?? 0, 2); ?></td>
                            <td class="align-middle text-center">
                                <?php if (($product['stock'] ?? 0) > 0): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i><?= htmlspecialchars($product['stock']); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <?php if ($this->session->userdata('role') === 'admin'): ?>
                                <td class="align-middle text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="<?= site_url('products/edit/' . ($product['id'] ?? '')); ?>" class="btn btn-warning btn-sm rounded-pill px-3 btn-edit">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 btn-delete" 
                                                data-bs-toggle="modal" data-bs-target="#deleteProductModal" 
                                                data-product-id="<?= htmlspecialchars($product['id'] ?? ''); ?>" 
                                                data-product-name="<?= htmlspecialchars($product['name'] ?? ''); ?>">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= ($this->session->userdata('role') === 'admin') ? '7' : '6'; ?>" class="text-center py-4 text-muted">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Delete Confirmation Modal (Bootstrap Modal) -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete product "<strong id="modalProductName"></strong>"? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteButton" href="#" class="btn btn-danger rounded-pill px-3">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // JavaScript to handle the delete confirmation modal
        document.addEventListener('DOMContentLoaded', function() {
            const deleteProductModal = document.getElementById('deleteProductModal');
            if (deleteProductModal) {
                deleteProductModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    const button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    const productId = button.getAttribute('data-product-id');
                    const productName = button.getAttribute('data-product-name');

                    // Update the modal's content.
                    const modalProductName = deleteProductModal.querySelector('#modalProductName');
                    const confirmDeleteButton = deleteProductModal.querySelector('#confirmDeleteButton');

                    modalProductName.textContent = productName;
                    confirmDeleteButton.href = '<?= site_url('products/delete/'); ?>' + productId;
                });
            }
        });
    </script>
</body>
</html>
