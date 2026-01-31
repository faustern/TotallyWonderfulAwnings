<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    require_once('dbconn.php'); // connect to database
    require_once('session.php'); // start session
    checkLogin(true); // check login

    // get order id, name and today date
    if (isset($_GET['order_id'])) {
        $orderId = intval($_GET['order_id']);
    } else {
        $orderId = 0;
    }
    $name = $_SESSION['name'];
    $today = date('d/m/Y');
    $isEmployee = isEmployee(); // check if user's an employee

    // update deposit when form is submitted (employee only)
    if ($isEmployee && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $orderId = intval($_POST['order_id']);
        $newDeposit = trim($_POST['deposit']);

        if (!is_numeric($newDeposit) || $newDeposit < 0) {
            $updateError = "Deposit must be a positive number.";
        } else {
            $newDeposit = round($newDeposit, 2);

            // get subtotal and GST, calculate total and owing
            $query = "SELECT subtotal, gst FROM orders WHERE order_id = $orderId";
            $result = $dbConn->query($query);
            if ($row = $result->fetch_assoc()) {
                $total = $row['subtotal'] + $row['gst'];
                $owing = max(0, $total - $newDeposit);

                // update deposit and owing
                $stmt = $dbConn->prepare("UPDATE orders SET deposit = ?, owing = ? WHERE order_id = ?");
                $stmt->bind_param("ddi", $newDeposit, $owing, $orderId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // get order details
    $orderQuery = "SELECT o.*, u.firstname, u.surname, u.postal_address, u.suburb, u.postcode, u.email, u.mobile, emp.firstname AS emp_firstname, emp.surname AS emp_surname FROM orders o JOIN users u ON o.customer_id = u.user_id JOIN users emp ON o.employee_id = emp.user_id WHERE o.order_id = $orderId";
    $orderResult = $dbConn->query($orderQuery);
    $order = $orderResult->fetch_assoc();

    // get products list
    $productQuery = "SELECT p.product_id, p.product_name, p.description, p.price, op.quantity FROM order_products op JOIN products p ON op.product_id = p.product_id WHERE op.order_id = $orderId";
    $products = $dbConn->query($productQuery)->fetch_all(MYSQLI_ASSOC);

    // calculate subtotal, GST, total, deposit, and total due
    $subtotal = 0;
    foreach ($products as $prod) {
        $subtotal += $prod['price'] * $prod['quantity'];
    }
    $gst = round($subtotal * 0.10, 2);
    $total = round($subtotal + $gst, 2);
    $deposit = floatval($order['deposit']);
    $owing = round($total - $deposit, 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TWACO Order Details</title>
    <link rel="stylesheet" href="css/project.css">
    <script src="javascript/project.js" defer></script>
</head>
<body>
<div class="container">
    <div class="header">
        <img src=".\images\logo.png" alt="">
        <h1>Totally Wonderful Awnings</h1>
        <h2>Customer Orders</h2>

        <ul>
            <li><a href="findOrder.php">Find Order</a></li>
            <?php if ($isEmployee): ?>
                <li><a href="order.php">New Order</a></li>
                <li><a href="addCustomer.php">New Customer</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Log Out</a></li>
        </ul>  
    </div>

    <p class="appendix"><strong>User: <?= htmlspecialchars($name) ?> | Date: <?= $today ?></strong></p>
    <h3>Order Details</h3>

    <h4>Customer Info</h4>
    <li>Customer: <?= htmlspecialchars($order['firstname']) . ' ' . htmlspecialchars($order['surname']) ?></li>
    <li>Address: <?= htmlspecialchars($order['postal_address']) ?>, <?= htmlspecialchars($order['suburb']) ?> <?= htmlspecialchars($order['postcode']) ?></li>
    <li>Email: <?= htmlspecialchars($order['email']) ?></li>
    <li>Phone: <?= htmlspecialchars($order['mobile']) ?></li>

    <h4>Order Info</h4>
    <li>Order ID: <?= $order['order_id'] ?></li>
    <li>Order Date: <?= $order['order_date'] ?></li>
    <li>Status: 
        <?php
            if ($order['completed'] == 'Y') {
                echo 'Completed';
            } else {
                echo 'In Progress';
            }
        ?>
    </li>
    <li>Employee: <?= htmlspecialchars($order['emp_firstname']) . ' ' . htmlspecialchars($order['emp_surname']) ?></li>

    <h4>Products</h4>
    <table>
        <tr><th>ID</th><th>Name</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Line Total</th></tr>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['product_id'] ?></td>
                <td><?= htmlspecialchars($p['product_name']) ?></td>
                <td><?= htmlspecialchars($p['description']) ?></td>
                <td><?= $p['quantity'] ?></td>
                <td>$<?= number_format($p['price'], 2) ?></td>
                <td>$<?= number_format($p['price'] * $p['quantity'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h4>Totals</h4>
    <form method="POST" onsubmit="return validateDepositForm();">
        <input type="text" name="order_id" value="<?= $orderId ?>" hidden>
        <li>Subtotal: $<?= number_format($subtotal, 2) ?></li>
        <li>GST: $<?= number_format($gst, 2) ?></li>
        <li>Total: $<?= number_format($total, 2) ?></li>
        <label><li>Deposit:
            <?php if ($isEmployee): ?>
                <input type="text" name="deposit" id="deposit" value="<?= number_format($deposit, 2) ?>" step="0.01" min="0" oninput="updateOwing(<?= $total ?>)">
            <?php else: ?>
                $<?= number_format($deposit, 2) ?>
            <?php endif; ?>
        </li></label>
        <label><li>Total Due:
            <input type="text" id="owing" name="owing" value="$<?= number_format($owing, 2) ?>" readonly>
        </li></label>


        <?php if ($isEmployee): ?>
            <button class="btn" type="submit">Update Order</button>
        <?php endif; ?>
    </form>

    <?php if (isset($updateError)): ?>
        <p class="error"><?= htmlspecialchars($updateError) ?></p>
    <?php endif; ?>
</div>
</body>
</html>
