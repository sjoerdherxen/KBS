
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {
    $invoer = array($_GET["id"]);
    $result = query("select MateriaalID from materiaal where MateriaalID = ?", $invoer);
    if ($result == 1) {
        query("DELETE FROM materiaal WHERE MateriaalID = ?)", array($_GET["id"]));
        header("location:materiaalList.php#Materiaal is verwijderd!");
        exit();
    } else {
        header("location:materiaalList.php#Materiaal verwijderen is mislukt!");
        exit();
    }
}
header("location: categorieList.php");
exit();
?> 
