<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categori&euml;n", "");
$query = "SELECT * FROM categorie";
$categorieen = query($query, null);

echo "<a href='addCategorie.php' id='addCategorieLink'>Toevoegen</a>";
echo "<div id='categorieList'>";
foreach ($categorieen as $categorie) {
    echo "<a class='categorieListItem' href='editcategorie.php?id=" . $categorie["CategorieID"] . "'>";
    echo "<div class='categorieListItemInner'>";
    echo "<span class='titel'>" . $categorie["Categorie_naam"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $categorie["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";
?>
<script>
    if (window.location.hash != "") {
        alert(window.location.hash.substr(1));
        window.location.hash = "";
    }
</script>
<?php

renderHtmlEndAdmin();
