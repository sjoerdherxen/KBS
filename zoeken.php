<?php

include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Zoeken", "");

$where = " WHERE OpWebsite = 1 ";
$params = array();
$zoek = "";
//checken of het knopje is ingedrukt
if (isset($_GET['button'])) {
    //checken of categorie is ingevuld
    if (isset($_GET["categorie"])) {
        if ($_GET["categorie"] != "Alles") {
            $where .= " AND CategorieID = ? ";
            $params[] = $_GET["categorie"];
        }
    }

    //checken of materiaal is ingevuld
    if (isset($_GET["materiaal"])) {
        if ($_GET["materiaal"] != "Alles") {
            $where .= " AND MateriaalID = ? ";
            $params[] = $_GET["materiaal"];
        }
    }

    // zoek op tekst
    if ($_GET['zoek'] != "") {
        $zoek = $_GET['zoek'];
        $where .= " AND (Titel LIKE ? OR Beschrijving LIKE ?) ";
        $params[] = "%$zoek%";
        $params[] = "%$zoek%";
    }

    if ($_GET["lijst"] !== "2") {
        $where .= " AND lijst = ? ";
        $params[] = $_GET["lijst"];
    }
    if ($_GET["passepartout"] !== "2") {
        $where .= " AND passepartout = ? ";
        $params[] = $_GET["passepartout"];
    }
    if ($_GET["orientatie"] !== "2") {
        $where .= " AND isStaand = ? ";
        $params[] = $_GET["orientatie"];
    }
    if ($_GET["prijs"] !== "4") {
        if ($_GET["prijs"] === "0") {
            $where .= " AND prijs >= 0 AND prijs <= 100 ";
        } elseif ($_GET["prijs"] === "1") {
            $where .= " AND prijs >= 100 AND prijs <= 200 ";
        } elseif ($_GET["prijs"] === "2") {
            $where .= " AND prijs >= 200 AND prijs <= 500 ";
        } elseif ($_GET["prijs"] === "3") {
            $where .= " AND prijs >= 500 ";
        }
        //$params[] = $_GET["prijs"];
    }
}

$categorieen = query("SELECT * FROM categorie c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.CategorieID = c.CategorieID) >= 1", null);
$subcategorieen = query("SELECT * FROM subcategorie c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.SubcategorieID = c.SubcategorieID) >= 1", null);
$materialen = query("SELECT * FROM materiaal c WHERE (SELECT COUNT(*) FROM schilderij s WHERE s.MateriaalID = c.MateriaalID) >= 1", null);
?>

<div class="gallerij">
    <form method="get" action="zoeken.php">
        <div class="gallerij-zoek row">
            <div class="col-md-2">
                Zoek: 
            </div> 
            <div class="col-md-4">
                <input type="text" name="zoek" id="gallerij-zoek-text" value="<?php echo $zoek; ?>">
            </div>

            <div class="col-md-2">
                Lijst:
            </div>
            <div class="col-md-4">
                <select name="lijst">
                    <?php $lijst = isset($_GET["lijst"]) ? $_GET["lijst"] : null; ?>
                    <option value="2" <?php showSelected($lijst, "2"); ?>>Beide</option>
                    <option value="1" <?php showSelected($lijst, "1"); ?>>Met</option>
                    <option value="0" <?php showSelected($lijst, "0"); ?>>Zonder</option>
                </select> 
            </div>
            <div class="col-md-2">
                Passepartout:
            </div>
            <div class="col-md-4">
                <select name="passepartout">
                    <?php $passepartout = isset($_GET["passepartout"]) ? $_GET["passepartout"] : null; ?>
                    <option value="2" <?php showSelected($passepartout, "2"); ?>>Beide</option>
                    <option value="1" <?php showSelected($passepartout, "1"); ?>>Met</option>
                    <option value="0" <?php showSelected($passepartout, "0"); ?>>Zonder</option>
                </select>
            </div>
            <div class="col-md-2">
                Orientatie:
            </div>
            <div class="col-md-4">
                <select name="orientatie">
                    <?php $orientatie = isset($_GET["orientatie"]) ? $_GET["orientatie"] : null; ?>
                    <option value="2" <?php showSelected($orientatie, "2"); ?>>Beide</option>
                    <option value="1" <?php showSelected($orientatie, "1"); ?>>Staand</option>
                    <option value="0" <?php showSelected($orientatie, "0"); ?>>Liggend</option>
                </select> 
            </div>
            <div class="col-md-2">
                Prijs:
            </div>
            <div class="col-md-4">
                <select name="prijs">
                    <?php $prijs = isset($_GET["prijs"]) ? $_GET["prijs"] : null; ?>
                    <option value="4" <?php showSelected($prijs, "4"); ?>>Alle</option>
                    <option value="0" <?php showSelected($prijs, "0"); ?>>€0 tot €100</option>
                    <option value="1" <?php showSelected($prijs, "1"); ?>>€100 tot €200</option>
                    <option value="2" <?php showSelected($prijs, "2"); ?>>€200 tot €500</option>
                    <option value="3" <?php showSelected($prijs, "3"); ?>>€500 en hoger</option>
                </select>
            </div>
            <div class="col-md-2">
                Categorie:
            </div>
            <div class="col-md-4">
                <select name="categorie">
                    <option value="Alles">Alle</option>
                    <?php

                    foreach ($categorieen as $value1) {
                        $checked = "";
                        if (isset($_GET["categorie"]) && $value1['CategorieID'] == $_GET["categorie"]) {
                            $checked = "selected";
                        }

                        echo "<option value=\"" . $value1['CategorieID'] . "\" " . $checked . ">" . $value1["Categorie_naam"] . "</option>";
                    }
                    ?>
                </select> 
            </div>
            <div class="col-md-2">
                Materiaal:
            </div>
            <div class="col-md-4">
                <select name="materiaal">
                    <option value="Alles">Alle</option>
                    <?php

                    foreach ($materialen as $value1) {
                        $checked = "";
                        if (isset($_GET["materiaal"]) && $value1['MateriaalID'] == $_GET["materiaal"]) {
                            $checked = "selected";
                        }
                        echo"<option value=\"" . $value1["MateriaalID"] . "\" " . $checked . ">" . $value1["Materiaal_soort"] . "</option>";
                    }
                    ?>
                </select> 
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <input type="submit" value="Zoeken" name="button">
            </div>
        </div>
    </form>
    <?php

    // pagination
    $pageSize = 20;
    $page = 1;
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        $page = $_GET["page"];
    }

    $pageCountResult = query("SELECT COUNT(*) as aantal FROM schilderij " . $where, $params);
    //print("SELECT COUNT(*) as aantal FROM schilderij " . $where . "<br/>");
    //var_dump($params);
    //echo "<br/>";
    $pageCount = ceil($pageCountResult[0]["aantal"] / $pageSize);
    if ($page > $pageCount) {
        $page = $pageCount;
        if ($page == 0) {
            $page = 1;
        }
    }
    //print("SELECT * FROM schilderij " . $where . " LIMIT " . (($page * $pageSize) - $pageSize) . ", " . $pageSize);
    $schilderijen = query("SELECT s.* FROM schilderij s " . $where . " LIMIT " . (($page * $pageSize) - $pageSize) . ", " . $pageSize, $params);
//echo "<div class='row'>";
    toonSchilderijLijst($schilderijen, $page, $pageCount, $pageSize, "/zoeken.php?zoek=" . $zoek . "&button=Filter&");
    ?>

</div>
<?php

renderHtmlEnd();

function showSelected($get, $value) {
    if (isset($get) && $value == $get) {
        echo "selected";
    }
}
?>
