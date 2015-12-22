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

echo "<a href='addSubcategorie.php' id='addSubcategorieLink'>Toevoegen</a>";
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
