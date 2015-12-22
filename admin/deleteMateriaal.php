
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {// get is goed
    $invoer = array($_GET["id"]);
    $result = query("SELECT MateriaalID FROM materiaal WHERE MateriaalID = ?", $invoer);// check of materiaal bestaat
    if (count($result) == 1) {
        // verwijderen
        query("DELETE FROM materiaal WHERE MateriaalID = ?", $invoer);
        header("location:materiaalList.php#Materiaal is verwijderd!");
        exit();
    } else {
        // materiaal bestaat niet
        header("location:materiaalList.php#Materiaal verwijderen is mislukt!");
        exit();
    }
}
header("location: categorieList.php");
exit();
?> 
