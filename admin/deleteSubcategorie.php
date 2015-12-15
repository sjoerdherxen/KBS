
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {
    $paragram = array($_GET["id"]);
    $result = query('SELECT SubcategorieID FROM subcategorie WHERE SubcategorieID = ?', $paragram);
    if (count($result == 1)) {
        query('DELETE FROM subcategorie WHERE SubcategorieID = ?', array($_GET["id"]));
        header('location:subcategorieList.php#Subcategorie is verwijderd!');
        exit();
    } else {
        header('location:subcategorieList.php#Subcategorie verwijderen is mislukt!');
        exit();
    }
} 
header("location: categorieList.php");
exit(); 
?> 
