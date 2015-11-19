<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
?>
<html>
    <head>
        <title>admin</title>
        <link href="../content/admin.css" type="text/css" rel="stylesheet">
    </head>

    <body>
        <?php

        echo "welkom: " . getUser();
        
        ?>
        <a href="uitloggen.php">uitloggen</a>
        
    </body>
</html>


