
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {
    $invoer = array($_GET["id"]);
    $result = query('SELECT SubcategorieID FROM subcategorie WHERE SubcategorieID = ?', $invoer);
    if (count($result) == 1) {
        query('DELETE FROM subcategorie WHERE SubcategorieID = ?', array($_GET["id"]));
        header('location: subcategorieList.php#Subcategorie is verwijderd!');
        exit();
    } else {
        header('location:subcategorieList.php#Subcategorie verwijderen is mislukt!');
        exit();
    }
}
header("location: categorieList.php");
exit();
?> 
