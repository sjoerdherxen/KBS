<?php

include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Zoeken", "");

$where = "";
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
    
    if ($_GET["lijst"] !== "2"){
        $where .= " AND lijst = " . $_GET["lijst"] . " ";
    }
    if ($_GET["passepartout"] !== "2"){
        $where .= " AND passepartout = " . $_GET["passepartout"] . " "; 
    }
    if ($_GET["orientatie"] !== "2"){
        $where .= " AND isStaand = " . $_GET["orientatie"] . " ";
    }
    if ($_GET["prijs"] !== "4"){
        if ($_GET["prijs"] === "0"){
            $where .= " AND (prijs >= 0 AND prijs < 300 "; 
        } elseif ($_GET["prijs"] === "1"){
            $where .= " AND (prijs >= 300 AND prijs < 600 ";
        } elseif ($_GET["prijs"] === "2"){
            $where .= " AND (prijs >= 600 AND prijs < 1000 ";
        } elseif ($_GET["prijs"] === "3"){
            $where .= " AND prijs >= 1000 ";
        }
    }
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
                        <select name="lijst">
                            <option value="2">Beide</option>
                            <option value="1">Met</option>
                            <option value="0">Zonder</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Passepartout:
                    </div>
                    <div class="col-md-6">
                        <select name="passepartout">
                            <option value="2">Beide</option>
                            <option value="1">Met</option>
                            <option value="0">Zonder</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Orientatie:
                    </div>
                    <div class="col-md-6">
                        <select name="orientatie">
                            <option value="2">Beide</option>
                            <option value="1">Staand</option>
                            <option value="0">Liggend</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Prijs:
                    </div>
                    <div class="col-md-6">
                        <select name="prijs">
                            <option value="4">Alle</option>
                            <option value="0">€100 tot €300</option>
                            <option vaiue="1">€300 tot €600</option>
                            <option value="2">€600 tot €1000</option>
                            <option value="3">€1000 en hoger</option>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Categorie:
                    </div>
                    <div class="col-md-6">
                        <select name="categorie">
                            <option value="Alles">Alle</option>
                            <?php

                            foreach ($categorieen as $value1) {
                                // foreach($value1 as $key2 => $value2){
                                // if ($key2 === "Categorie_naam"){
                                echo"<option value=\"" . $value1['CategorieID'] . "\">" . $value1["Categorie_naam"] . "</option>";
                                // }
                                //}
                            }
                            ?>
                        </select> <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Materiaal:
                    </div>
                    <div class="col-md-6">
                        <select name="materiaal">
                            <option value="Alles">Alle</option>
                            <?php

                            foreach ($materialen as $value1) {
                                // foreach($value1 as $key2 => $value2){
                                // if ($key2 === "Materiaal_soort"){
                                echo"<option value=\"" . $value1["MateriaalID"] . "\">" . $value1["Materiaal_soort"] . "</option>";
                                // }
                                //  }
                            }
                            ?>
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

    // pagination
    $pageSize = 20;
    $page = 1;
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        $page = $_GET["page"];
    }

    if ($where != "") {
        $where = " WHERE 1=1 " . $where;
    }
    
    $pageCountResult = query("SELECT COUNT(*) as aantal FROM schilderij " . $where, $params);
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