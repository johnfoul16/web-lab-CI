<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #fafafa;
            color: #2d3748;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            padding: 32px 32px 24px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .back-link {
            position: absolute;
            top: 32px;
            left: 32px;
            color: #0099f7;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #334155;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 14px;
            color: #64748b;
        }

        .form-container {
            padding: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .input, .textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .input:focus, .textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .textarea {
            resize: vertical;
            min-height: 100px;
        }

        .file-input-wrapper {
            position: relative;
            display: block;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-display {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background: #f8fafc;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .file-input-display:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        .file-input-content {
            text-align: center;
        }

        .file-input-icon {
            font-size: 24px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .file-input-text {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .file-input-hint {
            font-size: 12px;
            color: #94a3b8;
        }

        .price-stock-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .submit-button {
            width: 100%;
            padding: 16px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
            margin-top: 8px;
        }

        .submit-button:hover {
            background: #2563eb;
        }

        .submit-button:active {
            transform: translateY(1px);
        }

        .alert {
            margin: 16px 32px;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        .current-image {
            margin-bottom: 16px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .current-image-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .current-image-preview {
            max-width: 120px;
            height: auto;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .file-input-note {
            font-size: 12px;
            color: #64748b;
            margin-top: 8px;
        }
        @media (max-width: 576px) {
            body {
                padding: 12px;
            }
            
            .container {
                border-radius: 8px;
            }
            
            .header {
                padding: 24px 24px 20px;
            }
            
            .back-link {
                top: 24px;
                left: 24px;
            }
            
            .form-container {
                padding: 24px;
            }
            
            .price-stock-group {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="<?php echo site_url('products'); ?>" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
            <h1 class="title">EDIT PRODUCT</h1>
            <p class="subtitle">Update a product information</p>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('UserController/update/' . ($product['id'] ?? '')); ?>" enctype="multipart/form-data" class="form-container">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            
            <div class="form-group">
                <label for="name" class="label">Product Name</label>
                <input type="text" id="name" name="name" class="input" value="<?= set_value('name', $product['name'] ?? ''); ?>" placeholder="Enter product name" required>
                <?php echo form_error('name', '<div class="error-text">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="description" class="label">Description</label>
                <textarea id="description" name="description" class="textarea" placeholder="Describe your product..."><?= set_value('description', $product['description'] ?? ''); ?></textarea>
                <?php echo form_error('description', '<div class="error-text">', '</div>'); ?>
            </div>

            <div class="form-group">
                <label class="label">Product Image</label>
                <?php if (!empty($product['image_path'])): ?>
                    <div class="current-image">
                        <div class="current-image-label">Current Image</div>
                        <img src="<?= base_url($product['image_path']); ?>" alt="Current Product Image" class="current-image-preview">
                    </div>
                <?php endif; ?>
                <div class="file-input-wrapper">
                    <input type="file" id="product_image" name="product_image" class="file-input" accept="image/jpeg,image/png,image/gif">
                    <div class="file-input-display">
                        <div class="file-input-content">
                            <div class="file-input-icon">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <div class="file-input-text">Click to upload new image</div>
                            <div class="file-input-hint">JPG, PNG, GIF up to 2MB</div>
                        </div>
                    </div>
                </div>
                <div class="file-input-note">Leave blank to keep current image</div>
            </div>
            
            <div class="price-stock-group">
                <div class="form-group">
                    <label for="price" class="label">Price</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" class="input" value="<?= set_value('price', $product['price'] ?? ''); ?>" placeholder="0.00" required>
                    <?php echo form_error('price', '<div class="error-text">', '</div>'); ?>
                </div>
                
                <div class="form-group">
                    <label for="stock" class="label">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" class="input" value="<?= set_value('stock', $product['stock'] ?? ''); ?>" placeholder="0" required>
                    <?php echo form_error('stock', '<div class="error-text">', '</div>'); ?>
                </div>
            </div>
            
            <button type="submit" class="submit-button">
                Update Product
            </button>
        </form>
    </div>

    <script>
        // Enhanced file input interaction
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('product_image');
            const fileDisplay = document.querySelector('.file-input-display');
            const fileContent = document.querySelector('.file-input-content');
            
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    fileContent.innerHTML = `
                        <div class="file-input-icon">
                            <i class="bi bi-check-circle" style="color: #10b981;"></i>
                        </div>
                        <div class="file-input-text" style="color: #10b981;">${file.name}</div>
                        <div class="file-input-hint">Click to change</div>
                    `;
                } else {
                    fileContent.innerHTML = `
                        <div class="file-input-icon">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                                                    <div class="file-input-text">Click to upload new image</div>
                        <div class="file-input-hint">JPG, PNG, GIF up to 2MB</div>
                    `;
                }
            });
        });
    </script>
</body>
</html>