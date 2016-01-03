
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {// get is goed
    $invoer = array($_GET["id"]);
    $result = query("SELECT SubcategorieID FROM subcategorie WHERE SubcategorieID = ?", $invoer);// check of subcategorie bestaat
    if (count($result) == 1) {
        // verwijderen
        query("DELETE FROM subcategorie WHERE SubcategorieID = ?", $invoer );
        header("location: subcategorieList.php#Subcategorie is verwijderd!");
        exit();
    } else {
         // categorie bestaat niet
        header("location:subcategorieList.php#Subcategorie verwijderen is mislukt!");
        exit();
    }
}
header("location: categorieList.php");
exit();
?> 
