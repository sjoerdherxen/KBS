<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderijen", "", "schilderij");

$zoek = "";
if (isset($_GET["zoek"]) && $_GET["zoek"] != "") { // zoek boxje zoeken
    $zoek = $_GET["zoek"];
    $query = "SELECT * FROM schilderij S WHERE Titel LIKE ? OR Beschrijving LIKE ?";
    $zoek2 = "%" . $zoek . "%";
    $schilderijen = query($query, array($zoek2, $zoek2));
} else { // standaard
    $query = "SELECT * FROM schilderij";
    $query1 = "SELECT CategorieID FROM schilderij GROUP BY CategorieID";
    $schilderijen = query($query, null);
    $categorieën = query($query1,null);
}
?>

<div id='schilderijList'>
    <form method="get" action="schilderijList.php">
        <a href='addSchilderij.php'><button type="button"><span style="color: #333333">Toevoegen</span></button></a>
        <input name="zoek" placeholder="Zoeken" value="<?php echo $zoek; ?>">
        <input type="submit" value="Zoek">
    </form>

    <?php
    // schilderijen tonen
    foreach ($categorieën as $categorie) {
        //$query2 = "SELECT Categorie_naam FROM categorie WHERE CategorieID = ?";
        $query2 = query("SELECT Categorie_naam FROM categorie WHERE CategorieID = ?", $categorie['CategorieID']);
        $resultaat = $query2[0];
        print_r($categorieën);
        echo "---<br>";
        print_r($query2);
        echo "---<br>";
        print_r($categorie);
        echo "---<br>";
        echo "<h2>$resultaat</h2>";
        foreach ($schilderijen as $schilderij) {
            echo "<a class='schilderijListItem' href='editSchilderij.php?id=" . $schilderij["Schilderij_ID"] . "'>";
            echo "<div class='schilderijListItemImg' style='background-image: url(\"/content/uploads/small_" . $schilderij["Img"] . "?_=" . strtotime(date("Y-m-d H:i:s")) . "\");'></div>";
            echo "<div class='schilderijListItemInner'>";
            echo "<span class='titel'>" . $schilderij["Titel"] . "</span><br/>  ";
            echo "<span class='beschrijving'>" . $schilderij["Beschrijving"] . "</span><br/>";
            echo "</div>";
            echo "</a>";
        }
    }
    ?>
</div>
<?php
renderHtmlEndAdmin();
