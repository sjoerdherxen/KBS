
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["Categorie_naam"])) {
    $result = query("SELECT Categorie_naam FROM Categorie WHERE Categorie_naam = ?", array($_GET["Categorie_naam"]));
    if (count($result == 1)) {
        query("DELETE FROM Categorie WHERE Categorie_naam_= ?", array($_GET["Categorie_naam"]));
        header("location: categorieList.php");
        exit();
    } else {
        header("location: categorieList.php");
        exit();
    }
}
header("location: categorieList.php");
exit();
?>
