<?php

include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Zoeken", "");

$zoek = "";
if (isset($_GET['button'])) {
    $zoek = $_GET['zoek'];
}

$categorieen = query("SELECT * FROM categorie c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.categorieid = c.categorieid) >= 1", null);
$subcategorieen = query("SELECT * FROM subcategorie c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.subcategorieid = c.subcategorieid) >= 1", null);
$materialen = query("SELECT * FROM materiaal c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.materiaalid = c.materiaalid) >= 1", null);
?>

<div class="gallerij">
    <form method="get" action="zoeken.php">
        <div class="gallerij-zoek row">
            <div class="col-md-12">
                Zoek: <input type="text" name="zoek" id="gallerij-zoek-text" value="<?php echo $zoek; ?>">
                <input type="submit" value="Filter" name="button">
            </div>
            <div class="col-md-3">
                Lijst
                <select name="lijst">
                    <option value="">Beide</option>
                    <option>Met</option>
                    <option>Zonder</option>
                </select> <br/>
                Passepartout
                <select name="passepartout">
                    <option value="">Beide</option>
                    <option>Met</option>
                    <option>Zonder</option>
                </select> <br/>
                Orientatie 
                <select name="orientatie">
                    <option value="">Beide</option>
                    <option>Staand</option>
                    <option>Liggend</option>
                </select> <br/>

            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">

            </div>
        </div>
    </form>
    <?php

    $pageSize = 20;
    $page = 1;
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        $page = $_GET["page"];
    }

    $where = "";
    $params = array();
    if ($zoek != "") {
        $where = " WHERE titel LIKE ? OR beschrijving LIKE ?";
        $params[] = $zoek;
        $params[] = $zoek;
    }

    $pageCountResult = query("SELECT COUNT(*) as aantal FROM Schilderij" . $where, $params);
    $pageCount = ceil($pageCountResult[0]["aantal"] / $pageSize);
    if ($page > $pageCount) {
        $page = $pageCount;
    }

    $schilderijen = query("SELECT s.* FROM schilderij s " . $where . " LIMIT " . ($page * $pageSize - $pageSize) . ", " . $pageSize, $params);
//echo "<div class='row'>";
    toonSchilderijLijst($schilderijen, $page, $pageCount, $pageSize, "/zoeken.php?zoek=" . $zoek . "&button=Filter&");
    ?>

</div>
<?php

renderHtmlEnd();
?>