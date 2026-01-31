<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    require_once('dbconn.php'); // connect to database
    require_once('session.php'); // start session
    checkLogin(true); // check login

    // get user id, name and today date
    $userId = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $today = date('d/m/Y');
    $isEmployee = isEmployee(); // check if user's an employee

    // initialise employee search
    $searchResults = [];
    $searchError = '';
    $surname = $orderNumber = $phone = '';

    // handle search form submission (employee only)
    if ($isEmployee && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $surname = trim($_POST['surname']);
        $orderNumber = trim($_POST['order_number']);
        $phone = trim($_POST['phone']);

        if ($surname == '') {
            $searchError = "Surname is required.";
        } else {
            $safeSurname = $dbConn->real_escape_string($surname);
            $sql = "SELECT o.order_id, u.firstname, u.surname, u.postal_address, u.suburb, u.postcode, u.mobile, o.order_date FROM orders o JOIN users u ON o.customer_id = u.user_id WHERE u.surname LIKE '%$safeSurname%'";

            if ($orderNumber != '') {
                $orderNumber = $dbConn->real_escape_string($orderNumber);
                $sql .= " AND o.order_id = '$orderNumber'";
            }

            if ($phone != '') {
                $phone = $dbConn->real_escape_string($phone);
                $sql .= " AND u.mobile LIKE '%$phone%'";
            }

            $sql .= " ORDER BY o.order_date DESC";

            // handle results
            $results = $dbConn->query($sql);
            if ($results && $results->num_rows > 0) {
                $searchResults = $results->fetch_all(MYSQLI_ASSOC);
            } else {
                $searchError = "No matching orders found.";
            }
        }
    }

    // get order (customer only)
    $customerOrders = [];
    if (!$isEmployee) {
        $sql = "SELECT order_id, order_date FROM orders WHERE customer_id = $userId ORDER BY order_date DESC";
        $result = $dbConn->query($sql);
        if ($result && $result->num_rows > 0) {
            $customerOrders = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TWACO Order Finder</title>
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

        <?php if (!$isEmployee): ?>
            <h3>Your Orders</h3>
            <?php if (empty($customerOrders)): ?>
                <p>You have no orders</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($customerOrders as $order): ?>
                        <li>
                            <a href="displayOrder.php?order_id=<?= $order['order_id'] ?>">
                                Order ID: <?= $order['order_id'] ?> (<?= $order['order_date'] ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <h3>Search For Order</h3>
            <?php if ($searchError): ?>
                <p class="error"><?= htmlspecialchars($searchError) ?></p>
            <?php endif; ?>
            <form method="POST" onsubmit="return validateSearchForm();">
                <div class="form-group">                
                    <label>Surname:</label>
                    <input type="text" name="surname" value="<?= htmlspecialchars($surname) ?>" required>
                </div>
                <div class="form-group">
                    <label>Order ID:</label>
                    <input type="text" name="order_number" value="<?= htmlspecialchars($orderNumber) ?>">
                </div>
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">
                </div>
                <button class="btn" type="submit">Search</button>
            </form>

            <?php if (!empty($searchResults)): ?>
                <h3>Results</h3>
                <ul>
                    <?php foreach ($searchResults as $row): ?>
                        <li>
                            <a href="displayOrder.php?order_id=<?= $row['order_id'] ?>">
                                <?= htmlspecialchars($row['firstname']) ?> <?= htmlspecialchars($row['surname']) ?>
                            </a><br>
                            <?= htmlspecialchars($row['postal_address']) ?>, <?= htmlspecialchars($row['suburb']) ?> <?= htmlspecialchars($row['postcode']) ?><br>
                            Phone: <?= htmlspecialchars($row['mobile']) ?> | Order ID: <?= $row['order_id'] ?> | Date: <?= $row['order_date'] ?>
                        </li><br>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
