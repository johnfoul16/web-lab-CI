<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <a class="nav-button" href="<?php echo site_url('products'); ?>">
        <i class="bi bi-chevron-double-left"></i>
    </a>
    <h2>EDIT A PRODUCT</h2>
    <form method="post" action="<?= site_url('UserController/update/' . $products['id']); ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $products['name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= $products['description']; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= $products['price']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" min="0" value="<?= $products['stock']; ?>" required>
        </div>
        
        <div class="button-container">
            <button type="submit">Update Product</button>
        </div>
    </form>
</body>
</html>