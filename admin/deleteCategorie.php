
<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) { // get is goed
    $invoer = array($_GET["id"]);
    $result = query("SELECT CategorieID FROM Categorie WHERE CategorieID = ?", $invoer); // check of categorie bestaat
    if (count($result) == 1) {
        // verwijderen
        query("DELETE FROM Categorie WHERE CategorieID = ?",$invoer);
        header("location: categorieList.php#Categorie is verwijderd!");
        exit();
    } else {
        // categorie bestaat niet
        header("location: categorieList.php#Categorie verwijderen is mislukt!");
        exit();
    } 
} 
header("location: categorieList.php");
exit(); 
?> 
