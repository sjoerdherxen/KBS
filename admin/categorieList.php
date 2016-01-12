<?php
// start stuff
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categori&euml;n", "", "categorie"); // &euml; = ë in html, is beter

// alle categorieen ophalen
$query = "SELECT * FROM categorie";
$categorieen = query($query, null);

$succes = "";

if(isset($_GET["x"])){
    if($_GET["x"] === "1"){
        $succes = "Categorie is toegevoegd.";
    }
}

echo "<table><tr><td><a href='addCategorie.php' id='addCategorieLink'><button type=\"button\"><span style=\"color: #333333\">Toevoegen</span></button></a></td><td>$succes</td></tr></table>";

echo "<div id='categorieList'>";
//Categorieën tonen
foreach ($categorieen as $categorie) {
    echo "<a class='categorieListItem' href='editCategorie.php?id=" . $categorie["CategorieID"] . "'>"; // link
    echo "<div class='categorieListItemInner'>";// block
    echo "<span class='titel'>" . $categorie["Categorie_naam"] . "</span><br/>  ";  // maam
    echo "<span class='beschrijving'>" . $categorie["Beschrijving"] . "</span><br/>"; // beschrijving
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();
