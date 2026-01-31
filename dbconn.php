<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    // connect to database 
    $dbConn = new mysqli('localhost', 'twa091', 'twa091j2', 'awnings091');
    if ($dbConn->connect_error) {
        die('Connection error (' . $dbConn->connect_errno . ')'
        . $dbConn->connect_error);
    }
?>