<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    session_start(); // start section

    // check login
    function checkLogin($required = false) {
        if ($required && !isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }
    }

    // check if user is employee
    function isEmployee() {
        return isset($_SESSION['is_employee']) && $_SESSION['is_employee'] == 1;
    }
?>