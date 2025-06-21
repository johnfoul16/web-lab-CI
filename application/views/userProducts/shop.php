<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
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

        .page-title {
            margin-bottom: 2.5rem;
            color: #333;
            text-align: center;
            font-weight: bold;
        }
        
        .product-table {
            border: 2px solid #dee2e6; /* Use Bootstrap's default table border color */
        }
        
        .product-table th {
            background-color: #e9ecef; /* Light gray for table header */
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: 1.5px solid #dee2e6; 
        }
        
        .product-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .product-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .product-list-image {
            width: 50px; /* Small size for thumbnail in table */
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
            cursor: pointer; /* Indicate it's clickable */
            transition: transform 0.2s ease-in-out;
        }
        .product-list-image:hover {
            transform: scale(1.1); /* Slight zoom on hover */
        }

        /* Styles for the image inside the modal */
        .modal-body .img-fluid {
            max-width: 100%;
            max-height: 80vh; /* Limit height to 80% of viewport height */
            display: block;
            margin: auto; /* Center the image in the modal */
        }
    </style>
</head>
<body>
    <header>
        <!-- Include the header.php file here. Recommended to load views using CodeIgniter's view loader: -->
        <?php $this->load->view('header'); // Assuming header.html is header.php in your views folder ?>
    </header>

    <div class="container main-content py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="page-title text-primary"><i class="bi bi-shop me-2"></i>OUR PRODUCTS</h2>
                        
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <form action="<?= site_url('shop'); ?>" method="get" class="d-flex">
                                <input type="search" name="search" class="form-control me-2 rounded-pill" placeholder="Search products by name or description..." aria-label="Search" value="<?= htmlspecialchars($search_query ?? ''); ?>">
                                <button class="btn btn-outline-primary rounded-pill" type="submit"><i class="bi bi-search"></i> Search</button>
                                <?php if (!empty($search_query)): ?>
                                    <a href="<?= site_url('shop'); ?>" class="btn btn-outline-secondary rounded-pill ms-2"><i class="bi bi-x-lg"></i> Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>

                        <?php if (empty($products)): ?>
                            <div class="alert alert-info border-info shadow-sm p-4 text-center rounded-3">
                                <p class="mb-0 fs-5"><i class="bi bi-info-circle me-2"></i>No products found matching your criteria, or no products are available at the moment. Please check back later!</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive rounded-3 overflow-hidden shadow-sm border">
                                <table class="table table-bordered table-striped table-hover product-table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Image</th> <!-- Added Image column header -->
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-center">Availability</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td class="align-middle">
                                                <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
                                                    <!-- Make image clickable to open modal -->
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productImageModal" 
                                                       data-img-src="<?= base_url($product['image_path']); ?>" 
                                                       data-img-alt="<?= htmlspecialchars($product['name'] ?? 'Product Image'); ?>">
                                                        <img src="<?= base_url($product['image_path']); ?>" alt="<?= htmlspecialchars($product['name'] ?? 'Product Image'); ?>" class="product-list-image">
                                                    </a>
                                                <?php else: ?>
                                                    <i class="bi bi-image text-muted" style="font-size: 2rem;" title="No Image"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle fw-bold"><?= htmlspecialchars($product['name'] ?? 'N/A'); ?></td>
                                            <td class="align-middle"><?= htmlspecialchars($product['description'] ?? 'N/A'); ?></td>
                                            <td class="align-middle text-end">₱<?= number_format($product['price'] ?? 0, 2); ?></td>
                                            <td class="align-middle text-center">
                                                <?php if (($product['stock'] ?? 0) > 0): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>In Stock</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php if (($product['stock'] ?? 0) > 0): ?>
                                                    <form method="post" action="<?= site_url('add_to_cart/' . ($product['id'] ?? '')); ?>" class="d-inline">
                                                        <!-- CSRF Token: CRITICAL for security -->
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 py-2">
                                                            <i class="bi bi-cart-plus me-1"></i>Add To Cart
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 py-2" disabled>
                                                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Image Modal -->
    <div class="modal fade" id="productImageModal" tabindex="-1" aria-labelledby="productImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productImageModalLabel">Product Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" class="img-fluid" id="modalProductImage" alt="Product Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
 <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productImageModal = document.getElementById('productImageModal');
            if (productImageModal) {
                productImageModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal (which is our <a> tag wrapping the image)
                    const triggerLink = event.relatedTarget;
                    
                    // Extract info from data-* attributes
                    const imgSrc = triggerLink.getAttribute('data-img-src');
                    const imgAlt = triggerLink.getAttribute('data-img-alt');

                    // Update the modal's content.
                    const modalProductImage = productImageModal.querySelector('#modalProductImage');
                    const modalTitle = productImageModal.querySelector('#productImageModalLabel');

                    modalProductImage.src = imgSrc;
                    modalProductImage.alt = imgAlt;
                    modalTitle.textContent = imgAlt; // Set modal title to product name
                });
            }
        });
    </script>
</body>
</html>
