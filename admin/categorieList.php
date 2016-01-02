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

$error = "";

if(isset($_GET["x"])){
    if($_GET["x"] === 1){
        $error = "Categorie is toegevoegd.";
    }
}

echo "<table><tr><td><a href='addCategorie.php' id='addCategorieLink'>Toevoegen</a></td><td>$error</td></tr></table>";

echo "<div id='categorieList'>";
foreach ($categorieen as $categorie) {
    echo "<a class='categorieListItem' href='editcategorie.php?id=" . $categorie["CategorieID"] . "'>"; // link
    echo "<div class='categorieListItemInner'>";// block
    echo "<span class='titel'>" . $categorie["Categorie_naam"] . "</span><br/>  ";  // maam
    echo "<span class='beschrijving'>" . $categorie["Beschrijving"] . "</span><br/>"; // beschrijving
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();
