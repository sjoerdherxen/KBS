<?php

// test
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderij toevoegen", "", "schilderij");

// init alle velden 
$schilderij = array();
$schilderij["Titel"] = "";
$schilderij["Beschrijving"] = "";
$schilderij["Jaar"] = "";
$schilderij["Hoogte"] = "";
$schilderij["Breedte"] = "";
$schilderij["CategorieID"] = "";
$schilderij["SubcategorieID"] = "";
$schilderij["MateriaalID"] = "";
$schilderij["lijst"] = 0;
$schilderij["passepartout"] = 0;
$schilderij["isStaand"] = 0;
$schilderij["prijs"] = "";
$schilderij["OpWebsite"] = 1;

// haal alle gerelateerde gegevens op voor dropdowns
$resultMateriaal = query("SELECT MateriaalID, Materiaal_soort FROM materiaal", null);
$resultCategorie = query("SELECT CategorieID, Categorie_naam FROM categorie", null);
$resultSubCategorie = query("SELECT SubcategorieID, Subcategorie_naam FROM subcategorie", null);

// submit is gedaan
if (isset($_POST["knop"])) {
    $correct = true;
    $schilderij = array(); //zet waardes voor inputs
    $schilderInsert = array(); // waardes voor query params
    // check titel
    if (!isset($_POST["titel"]) || trim($_POST["titel"]) == "") {
        $titelError = "Titel is verplicht";
        $correct = false;
    }
    $schilderij["OpWebsite"] = $_POST["OpWebsite"];
    $schilderijInsert[] = $_POST["OpWebsite"] ? 1 : 0;
    
    $schilderij["Titel"] = $_POST["titel"];
    $schilderInsert[] = $_POST["titel"];

    $schilderij["Beschrijving"] = $_POST["beschrijving"];
    $schilderInsert[] = $_POST["beschrijving"];

    $schilderij["lijst"] = isset($_POST["lijst"]);
    $schilderInsert[] = $schilderij["lijst"] ? 1 : 0;

    $schilderij["passepartout"] = isset($_POST["passepartout"]);
    $schilderInsert[] = $schilderij["passepartout"] ? 1 : 0;

    $schilderij["isStaand"] = $_POST["isStaand"] == "true";
    $schilderInsert[] = $schilderij["isStaand"] ? 1 : 0;

    // check jaar
    if (!is_numeric($_POST["jaar"]) && isset($_POST["jaar"]) && trim($_POST["jaar"]) != "") {
        $jaarError = "Jaar is geen getal";
        $correct = false;
    }
    $schilderij["Jaar"] = $_POST["jaar"];
    $schilderInsert[] = $_POST["jaar"];

    // check prijs
    if (!is_numeric($_POST["prijs"]) && isset($_POST["prijs"]) && trim($_POST["prijs"]) != "") {
        $jaarError = "Prijs is geen getal";
        $correct = false;
    }
    $schilderij["prijs"] = $_POST["prijs"];
    $schilderInsert[] = $_POST["prijs"] == "" ? null : $_POST["prijs"];

    // check hoogte
    if (!isset($_POST["hoogte"]) || trim($_POST["hoogte"]) == "") {
        $hoogteError = "Hoogte is verplicht";
        $correct = false;
    } elseif (!is_numeric($_POST["hoogte"])) {
        $hoogteError = "Hoogte is geen getal";
        $correct = false;
    }
    $schilderij["Hoogte"] = $_POST["hoogte"];
    $schilderInsert[] = $_POST["hoogte"];

    // check breedte
    if (!isset($_POST["breedte"]) || trim($_POST["breedte"]) == "") {
        $breedteError = "Breedte is verplicht";
        $correct = false;
    } elseif (!is_numeric($_POST["breedte"])) {
        $breedteError = "Breedte is geen getal";
        $correct = false;
    }
    $schilderij["Breedte"] = $_POST["breedte"];
    $schilderInsert[] = $_POST["breedte"];

    // check categorie
    if (!isset($_POST["categorie"]) || trim($_POST["categorie"]) == "") {
        $categorieError = "Categorie is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultCategorie, $_POST["categorie"], "CategorieID")) {
        $categorieError = "Categorie bestaat niet";
        $correct = false;
    }
    $schilderij["CategorieID"] = $_POST["categorie"];
    $schilderInsert[] = $_POST["categorie"];

    // check materiaal
    if (!isset($_POST["materiaal"]) || trim($_POST["materiaal"]) == "") {
        $materiaalError = "Materiaal is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultMateriaal, $_POST["materiaal"], "MateriaalID")) {
        $materiaalError = "Materiaal bestaat niet";
        $correct = false;
    }
    $schilderij["MateriaalID"] = $_POST["materiaal"];
    $schilderInsert[] = $_POST["materiaal"];

    // check subcategorie
    if (!isset($_POST["subcategorie"])) {
        $subcategorieError = "Subcategorie is fout";
        $correct = false;
    } elseif (trim($_POST["subcategorie"]) != "" && !in_query_result($resultSubCategorie, $_POST["subcategorie"], "SubcategorieID")) {
        $subcategorieError = "Subcategorie bestaat niet";
        $correct = false;
    }
    $schilderij["SubcategorieID"] = $_POST["subcategorie"];
    $schilderInsert[] = $_POST["subcategorie"] == "" ? null : $_POST["subcategorie"];

    // check img upload
    if (isset($_FILES["img"])) {
        $imgExtension = strtolower(strrchr($_FILES["img"]["name"], "."));
        $correctExtensions = array(".png", ".jpg", ".jpeg", ".gif");

        if (!in_array($imgExtension, $correctExtensions) || $_FILES["img"]["error"] !== 0 || $_FILES["img"]["size"] == 0) {
            $afbeeldingError = "Geen afbeelding gekozen";
            $correct = false;
        }
    } else {
        $afbeeldingError = "Geen afbeelding gekozen";
        $correct = false;
    }

    if ($correct) {
        // haal correcte schilder id op of insert als geen bestaat
        $schilder = query("SELECT SchilderID FROM schilder LIMIT 0,1", null);
        if (count($schilder) == 0) {
            $schilderid = insert("INSERT INTO schilder (Naam_schilder) VALUES (\"Ellen van 't Hof\")", null);
        } else {
            $schilderid = $schilder[0]["SchilderID"];
        }
        $schilderInsert[] = $schilderid;

        // insert 
        $id = insert("INSERT INTO schilderij (Titel, OpWebsite, Beschrijving, lijst, passepartout, isStaand, Jaar, prijs, Hoogte, "
                . "                             Breedte, CategorieID, MateriaalID, SubcategorieID, SchilderID)"
                . "  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $schilderInsert);
        
        if ($id == null) {
            print("Er is een fout opgreteden tijdens het opslaan");
        } else {
            // zet afbeelding correct
             uploadSchilderijImg($id, $imgExtension, null);

            if ($_POST["knop"] == "Toevoegen, nieuw") {
                header("location: addSchilderij.php#Schilderij is toegevoegd");
                exit();
            } else {
                header("location: schilderijList.php#Schilderij is toegevoegd");
                exit();
            }
        }
    }
}
?>
<p><a href="schilderijList.php">Terug naar lijst</a></p>
<form action="addSchilderij.php" method="post" class="editform" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Titel</td>
            <td>
                <input type="text" name="titel" value="<?php echo $schilderij["Titel"]; ?>">
                <?php

                if (isset($titelError)) {
                    echo "<br/><span class='incorrect'>" . $titelError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Beschrijving</td><td></td></tr><tr>
            <td colspan="2">
                <textarea name="beschrijving" ><?php echo $schilderij["Beschrijving"]; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Jaar</td>
            <td>
                <input type="text"  class="number" name="jaar" value="<?php echo $schilderij["Jaar"]; ?>">
                <?php

                if (isset($jaarError)) {
                    echo "<br/><span class='incorrect'>" . $jaarError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Hoogte</td>
            <td>
                <input type="text" class="number" name="hoogte" value="<?php echo $schilderij["Hoogte"]; ?>"> cm
                <?php

                if (isset($hoogteError)) {
                    echo "<br/><span class='incorrect'>" . $hoogteError . "</span>";
                }
                ?>
            </td>
        </tr><tr>
            <td>Breedte</td>
            <td>
                <input type="text" class="number" name="breedte" value="<?php echo $schilderij["Breedte"]; ?>"> cm
                <?php

                if (isset($breedteError)) {
                    echo "<br/><span class='incorrect'>" . $breedteError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Categorie</td>
            <td>
                <select name="categorie">
                    <?php

                    foreach ($resultCategorie as $categorie) {
                        $selected = "";
                        if ($categorie["CategorieID"] == $schilderij["CategorieID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $categorie["CategorieID"] . "'>" . $categorie["Categorie_naam"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($categorieError)) {
                    echo "<br/><span class='incorrect'>" . $categorieError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Subcategorie</td>
            <td>
                <select name="subcategorie">
                    <option value="">-- Geen --</option>
                    <?php

                    foreach ($resultSubCategorie as $categorie) {
                        $selected = "";
                        if ($categorie["SubcategorieID"] == $schilderij["SubcategorieID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $categorie["SubcategorieID"] . "'>" . $categorie["Subcategorie_naam"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($subcategorieError)) {
                    echo "<br/><span class='incorrect'>" . $subcategorieError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Materiaal</td>
            <td>
                <select name="materiaal">
                    <?php

                    foreach ($resultMateriaal as $materiaal) {
                        $selected = "";
                        if ($materiaal["MateriaalID"] == $schilderij["MateriaalID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $materiaal["MateriaalID"] . "'>" . $materiaal["Materiaal_soort"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($materiaalError)) {
                    echo "<br/><span class='incorrect'>" . $materiaalError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>In lijst</td>
            <td>
                <input type="checkbox" name="lijst" value="true" <?php if ($schilderij["lijst"]) echo "checked='checked'"; ?>>
            </td>
        </tr>
        <tr>
            <td>Passepartout</td>
            <td>
                <input type="checkbox" name="passepartout" value="true" <?php if ($schilderij["passepartout"]) echo "checked='checked'"; ?>>
            </td>
        </tr>
        <tr>
            <td>Staand/liggend</td>
            <td>
                <select name="isStaand">
                    <option value="false" <?php if (!$schilderij["isStaand"]) echo "selected='selected'"; ?> >liggend</option>
                    <option value="true" <?php if ($schilderij["isStaand"]) echo "selected='selected'"; ?> >staand</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Op website
            </td>
            <td>
                <input type="checkbox" value="true" name="OpWebsite" checked="checked">
            </td>
        </tr>
        <tr>
            <td>Prijs</td>
            <td>
                &euro; <input type="text" name="prijs" class="number" value="<?php echo $schilderij["prijs"]; ?>">
            </td>
        </tr>
        <tr>
            <td>Afbeelding</td><td></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="file" name="img" accept="image/*">
                <?php

                if (isset($afbeeldingError)) {
                    echo "<span class='incorrect'>" . $afbeeldingError . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Toevoegen en naar overzicht" name="knop">
                <input type="submit" value="Toevoegen en blijven" name="knop">
            </td>
        </tr>
    </table>
</form>
<?php

renderHtmlEndAdmin();
