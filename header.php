<?php
    require_once 'connection.php';

    $sql_cart = "SELECT * FROM cart";
    $all_cart = $conn->query($sql_cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <h1><a href="home.php">eCommerce</a></h1>
        <div id="main-tabs">
            <a href="upload.php">Upload</a>
            <a href="home.php">Products</a>
        </div>
        <a href="cart.php">Cart <span id="badge"><?php echo mysqli_num_rows($all_cart) ?></span></a>
    </header>
</body>
</html>