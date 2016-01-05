<?php
include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Zoeken", "");

$zoek = "";
if (isset($_GET['button'])) {
    $zoek = $_GET['zoek'];
}

$categorieen = query("SELECT * FROM categorie c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.CategorieID = c.CategorieID) >= 1", null);
$subcategorieen = query("SELECT * FROM subcategorie c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.SubcategorieID = c.SubcategorieID) >= 1", null);
$materialen = query("SELECT * FROM materiaal c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.MateriaalID = c.MateriaalID) >= 1", null);
?>

<div class="gallerij">
    <form method="get" action="zoeken.php">
        <div class="gallerij-zoek row">
            <div class="col-md-12">
                Zoek: <input type="text" name="zoek" id="gallerij-zoek-text" value="<?php echo $zoek; ?>">
                <input type="submit" value="Filter" name="button">
            </div>
            <div class="col-md-3">

                <div class="row">
                    <div class="col-md-5">
                        Lijst:
                    </div>
                    <div class="col-md-6">
                        <select name=" divjst">
                            <option value="">Beide</option>
                            <option>Met</option>
                            <option>Zonder</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Passepartout:
                    </div>
                    <div class="col-md-6">
                        <select name="passepartout">
                            <option value="">Beide</option>
                            <option>Met</option>
                            <option>Zonder</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Orientatie:
                    </div>
                    <div class="col-md-6">
                        <select name="orientatie">
                            <option value="">Beide</option>
                            <option>Staand</option>
                            <option>Liggend</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Prijs:
                    </div>
                    <div class="col-md-6">
                        <select name="prijs">
                            <option value="">Alle</option>
                            <option>€100 tot €300</option>
                            <option>€300 tot €600</option>
                            <option>€600 tot €1000</option>
                            <option>€1000 en hoger</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Categorie:
                    </div>
                    <div class="col-md-6">
                        <select name="categorie">
                            <option value="">Alle</option>
                            <option><!-- function  --></option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Materiaal:
                    </div>
                    <div class="col-md-6">
                        <select name="materiaal">
                            <option value="">Alle</option>
                            <option><!-- function  --></option>
                        </select> <br/>
                    </div>
                </div>


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
        $where = " WHERE Titel LIKE ? OR Beschrijving LIKE ?";
        $params[] = $zoek;
        $params[] = $zoek;
    }

    $pageCountResult = query("SELECT COUNT(*) as aantal FROM schilderij" . $where, $params);
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