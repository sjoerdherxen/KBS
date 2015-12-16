
<?php

session_start();
require 'functions.php';
confirm("Weet u zeker dat u deze subcategorie wilt verwijderen?");
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"])) {
    $invoer = array($_GET["id"]);
    $result = query("SELECT CategorieID FROM Categorie WHERE CategorieID = ?", $invoer);
    if (count($result) == 1) {
        query("DELETE FROM Categorie WHERE CategorieID = ?", array($_GET["id"]));
        header("location: categorieList.php#Categorie is verwijderd!");
        exit();
    } else {
        header("location: categorieList.php#Categorie verwijderen is mislukt!");
        exit();
    } 
} 
header("location: categorieList.php");
exit(); 
?> 
