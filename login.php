<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    require_once('dbconn.php'); // connect to database
    require_once('session.php'); // start session
    $today = date('d/m/Y'); // date

    // get email, password and initialize error value
    $email = ''; 
    $password = '';
    $error = '';

    // handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // get and trim email input
        if (isset($_POST['email'])) {
            $email = trim($_POST['email']);
        } else {
            $email = '';
        }

        // get and trim password input
        if (isset($_POST['password'])) {
            $password = trim($_POST['password']);
        } else {
            $password = '';
        }

        // validate email and password
        if ($email == '' || $password == '') {
            $error = "Email and password are required";
        } else {
            // prevent SQL injection by cleaning email 
            $safeEmail = $dbConn->real_escape_string($email);

            // find user with matching email
            $query = "SELECT * FROM users WHERE email = '$safeEmail'";
            $result = $dbConn->query($query);

            // if user is found
            if ($result && $result -> num_rows == 1) {
                $user = $result -> fetch_assoc();
                
                // encrypt input password and compare with stored hash
                $hashedInput = hash('sha256', $password);
                if ($hashedInput == $user['password']) {

                    // if logged in successfully, set session variables
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['name'] = $user['firstname'] . ' ' . $user['surname'];
                    $_SESSION['is_employee'] = $user['is_employee'];

                    header('Location: findOrder.php'); // redirect to the order search form
                    exit;
                } else {
                    $error = "Incorrect password";
                }
            } else {
                $error = "User not found";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TWACO Login</title>
    <link rel="stylesheet" href="css/project.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src=".\images\logo.png" alt="">
            <h1>Totally Wonderful Awnings</h1>
            <h2>Customer Orders</h2>
        </div>
        <p class="appendix"><strong>Date: <?= $today ?></strong></p>

        <h3>Login</h3>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php" novalidate>
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="form-group">
                <label>Password:</label> 
                <input type="password" name="password" required>
            </div>
            <button class="btn" type="submit">Login</button>
        </form>
        <p class="appendix"><strong><a href="index.php">Return to Home</a></strong></p>
    </div>
</body>
</html>
