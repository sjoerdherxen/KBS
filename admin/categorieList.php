<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("categorie", "");
$query = "SELECT * FROM categorie";
$categorieen = query($query, null);

echo "<a href='addCategorie.php' id='addCategorieLink'>Toevoegen</a>";
echo "<div id='categorieList'>";
foreach ($categorieen as $categorie) {
    echo "<a class='categorieListItem' href='editcategorie.php?id=" . $categorie["Categorie_naam"] . "'>";
    //  echo "<div class='categorieListItemImg' style='background-image: url(\"" . $categorie["Img"] . "\");'></div>";
    echo "<div class='categorieListItemInner'>";
    echo "<span class='titel'>" . $categorie["Categorie_naam"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $categorie["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();
