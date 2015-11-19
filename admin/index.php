<?php
session_start();
require 'functions.php';
?>

<html>
    <head>
        <title>admin</title>
        <link href="/content/admin.css" type="text/css" rel="stylesheet">
    </head>

    <body>
        <?php
        if (isLoggedIn()) {
            header("location: main.php");
        } else {
            include 'inlog.php';
        }
        ?>
    </body>
</html>