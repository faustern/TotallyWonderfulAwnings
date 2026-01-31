<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    session_start(); // start session
    session_destroy(); // destroy session
    header("Location: index.php"); // redirect to index page
    exit;
?>