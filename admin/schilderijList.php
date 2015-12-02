<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderijen", "");

$zoek = "";
if (isset($_GET["zoek"]) && $_GET["zoek"] != "") {
    $zoek = $_GET["zoek"];
    $query = "SELECT * FROM schilderij WHERE Titel LIKE ? OR Beschrijving LIKE ? OR Categorie_naam LIKE ? OR Techniek_naam LIKE ?";
    $zoek2 = "%" . $zoek . "%";
    $schilderijen = query($query, array($zoek2, $zoek2, $zoek2, $zoek2));
} else {
    $query = "SELECT * FROM schilderij";
    $schilderijen = query($query, null);
}

?>

<div id='schilderijList'>
    <form method="get" action="schilderijList.php">
        <a href='addSchilderij.php'>Toevoegen</a>
        <input name="zoek" placeholder="Zoeken" value="<?php echo $zoek; ?>">
        <input type="submit" value="Zoek">
    </form>

    <?php

    foreach ($schilderijen as $schilderij) {
        echo "<a class='schilderijListItem' href='editschilderij.php?id=" . $schilderij["Schilderij_ID"] . "'>";
        echo "<div class='schilderijListItemImg' style='background-image: url(\"" . $schilderij["Img"] . "?_=".strtotime(date("Y-m-d H:i:s"))."\");'></div>";
        echo "<div class='schilderijListItemInner'>";
        echo "<span class='titel'>" . $schilderij["Titel"] . "</span><br/>  ";
        echo "<span class='beschrijving'>" . $schilderij["Beschrijving"] . "</span><br/>";
        echo "</div>";
        echo "</a>";
    }
    ?>
</div>
<?php

renderHtmlEndAdmin();
