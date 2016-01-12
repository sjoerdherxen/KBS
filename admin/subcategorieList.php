<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Subcategori&euml;n", "", "subcategorie");

// subcategorien ophalen
$query = "SELECT * FROM subcategorie";
$subcategorieen = query($query, null);

$succes = "";

if(isset($_GET["x"])){
    if($_GET["x"] === "1"){
        $succes = "Subategorie is toegevoegd.";
    }
}

echo "<table><tr><td><a href='addSubcategorie.php' id='addSubcategorieLink'><button type=\"button\"><span style=\"color: #333333\">Toevoegen</span></button></a></td><td>$succes</td></tr></table>";

echo "<div id='subcategorieList'>";
// subcategorieen tonen
foreach ($subcategorieen as $subcategorie) {
    echo "<a class='subcategorieListItem' href='editSubcategorie.php?id=" . $subcategorie["SubcategorieID"] . "'>";
    echo "<div class='subcategorieListItemInner'>";
    echo "<span class='titel'>" . $subcategorie["Subcategorie_naam"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $subcategorie["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();
