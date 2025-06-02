<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px; 
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            margin-bottom: 1.5rem;
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
            width: 100%;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 2px solid #3E5A69;
        }
        
        .product-table th {
            background-color: #f2f2f2;
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: 1.5px solid #3E5A69; 
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
        
        .btn-edit {
            padding: 6px 12px;
            background-color: rgb(255, 202, 29);
            color: white; 
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.3s;
        }
        
        .btn-delete {
            padding: 6px 12px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.3s;
        }
        
        .btn-edit:hover {
            background-color: #ffd740;
            transform: scale(1.05);
        }
        
        .btn-delete:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header>
        <?php include('header.html')?>
    </header>

    <div class="content-container">
        <h2 class="page-title">PRODUCT LISTING</h2>
        <a href="<?= site_url('UserController/create'); ?>" class="add-product-btn">Add New Product</a>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= isset($product['name']) ? $product['name'] : 'N/A'; ?></td>
                    <td><?= isset($product['description']) ? $product['description'] : 'N/A'; ?></td>
                    <td><?= isset($product['price']) ? $product['price'] : 'N/A'; ?></td>
                    <td><?= isset($product['stock']) ? $product['stock'] : 'N/A'; ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= site_url('UserController/edit/' . $product['id']); ?>" class="btn-edit">Edit</a>
                            <a href="<?= site_url('UserController/delete/' . $product['id']); ?>" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS Bundle (for any potential Bootstrap features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>