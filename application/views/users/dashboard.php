<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <style>
        body {
            background-image: url('<?php echo base_url("assets/bg.jpg"); ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .hero-title {
            position: absolute;
            top: 20vh; /* Position the title at 20% of the viewport height */
            left: 5%; /* Move it to the left side */
            color: white;
        }

        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 15px;
            background-color: #3E5A69; /* CTA button color */
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .cta-button:hover {
            background-color:rgb(255, 202, 29); /* Darker orange on hover */
            transform: scale(1.1); /* Slightly enlarge on hover */
        }
    </style>

</head>
<body>
    <header><?php include('header.html')?></header>

    <div class="hero-title">
        <h1>Level Up Your Gear</h1>
        <h1>with TechSnap!</h1>
        <a href="<?php echo site_url('shop'); ?>" class="cta-button">Shop Now</a>
        <a href="<?php echo site_url('products'); ?>" class="cta-button">Manage</a>
       
    </div>

</body>
</html>

<?php

?>