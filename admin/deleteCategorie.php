
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {
    $invoer = array($_GET["id"]);
    $result = query("SELECT id FROM Categorie WHERE id = ?", $invoer);
    var_dump($result); /*
    if (count($result == 1)) {
        query("DELETE FROM Categorie WHERE id = ?", array($_GET["id"]));
        header("location: categorieList.php");
        exit();
    } else {
        header("location: categorieList.php");
        exit();
    } */
} /*
header("location: categorieList.php");
exit(); */
?> 
