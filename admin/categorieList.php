<?php

require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("categorie", "");
$query = "SELECT * FROM schi";
$categorie = query($query, null);

echo "<a href='addCategorie.php' id='addCategorieLink'>Toevoegen</a>";
echo "<div id='categorieList'>";
foreach ($categorie as $categorie) {
    echo "<a class='categorieListItem' href='editcategorie.php?id=" . $categorie["Categorie_ID"] . "'>";
    echo "<div class='categorieListItemImg' style='background-image: url(\"" . $categorie["Img"] . "\");'></div>";
    echo "<div class='categorieListItemInner'>";
    echo "<span class='titel'>" . $categorie["Titel"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $categorie["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();