<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Subcategori&euml;n", "");
$query = "SELECT * FROM subcategorie";
$subcategorieen = query($query, null);

echo "<a href='addSubcategorie.php' id='addSubcategorieLink'>Toevoegen</a>";
echo "<div id='subcategorieList'>";
foreach ($subcategorieen as $subcategorie) {
    echo "<a class='subcategorieListItem' href='editsubategorie.php?id=" . $subcategorie["SubcategorieID"] . "'>";
    echo "<div class='subcategorieListItemInner'>";
    echo "<span class='titel'>" . $subcategorie["Subcategorie_naam"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $subcategorie["Beschrijving"] . "</span><br/>";
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
