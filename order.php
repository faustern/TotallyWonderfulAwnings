<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    require_once('session.php'); // start session
    checkLogin(true); // check login

    // if not an employee then redirect to index page
    if (!isEmployee()) {
        header("Location: index.php");
        exit;
    }

    // get user's name and today date
    $name = $_SESSION['name'];
    $today = date('d/m/Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TWACO New Order</title>
    <link rel="stylesheet" href="css/project.css">
</head>
<body>
<div class="container">
    <div class="header">
        <img src=".\images\logo.png" alt="">
        <h1>Totally Wonderful Awnings</h1>
        <h2>Customer Orders</h2>

        <ul>
            <li><a href="findOrder.php">Find Order</a></li>
            <li><a href="order.php">New Order</a></li>
            <li><a href="addCustomer.php">New Customer</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>

    <p class="appendix"><strong>User: <?= htmlspecialchars($name) ?> | Date: <?= $today ?></strong></p>
    <h3>Add New Order</h3>
</div>
</body>
</html>
