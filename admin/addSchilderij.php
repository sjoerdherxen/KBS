<?php

// test
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderij bewerken", "");

$schilderij = array();
$schilderij["Titel"] = "";
$schilderij["Beschrijving"] = "";
$schilderij["Jaar"] = "";
$schilderij["Hoogte"] = "";
$schilderij["Breedte"] = "";
$schilderij["CategorieID"] = "";
$schilderij["SubCategorieID"] = "";
$schilderij["MateriaalID"] = "";

$resultTechniek = query("SELECT materiaalId, materiaal_naam FROM materiaal", null);
$resultCategorie = query("SELECT categorieId, categorie_naam FROM categorie", null);
$resultSubCategorie = query("SELECT subcategorieId, subcategorie_naam FROM subcategorie", null);

if (isset($_POST["knop"])) {
    $correct = true;
    $schilderij = array();
    $schilderInsert = array();

    if (!isset($_POST["titel"]) || trim($_POST["titel"]) == "") {
        $titelError = "Titel is verplicht";
        $correct = false;
    }
    $schilderij["Titel"] = $_POST["titel"];
    $schilderInsert[] = $_POST["titel"];

    $schilderij["Beschrijving"] = $_POST["beschrijving"];
    $schilderInsert[] = $_POST["beschrijving"];

    if ((!is_numeric($_POST["jaar"]) && isset($_POST["jaar"])) || trim($_POST["jaar"]) == "") {
        $jaarError = "Jaar is geen getal";
        $correct = false;
    }
    $schilderij["Jaar"] = $_POST["jaar"];
    $schilderInsert[] = $_POST["jaar"];

    if (!isset($_POST["hoogte"]) || trim($_POST["hoogte"]) == "") {
        $hoogteError = "Hoogte is verplicht";
        $correct = false;
    } elseif (!is_numeric($_POST["hoogte"])) {
        $hoogteError = "Hoogte is geen getal";
        $correct = false;
    }
    $schilderij["Hoogte"] = $_POST["hoogte"];
    $schilderInsert[] = $_POST["hoogte"];

    if (!isset($_POST["breedte"]) || trim($_POST["breedte"]) == "") {
        $breedteError = "Breedte is verplicht";
        $correct = false;
    } elseif (!is_numeric($_POST["breedte"])) {
        $breedteError = "Breedte is geen getal";
        $correct = false;
    }
    $schilderij["Breedte"] = $_POST["breedte"];
    $schilderInsert[] = $_POST["breedte"];

    if (!isset($_POST["categorie"]) || trim($_POST["categorie"]) == "") {
        $categorieError = "Categorie is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultCategorie, $_POST["categorie"], "categorieId")) {
        $categorieError = "Categorie bestaat niet";
        $correct = false;
    }
    $schilderij["CategorieID"] = $_POST["categorie"];
    $schilderInsert[] = $_POST["categorie"];

    if (!isset($_POST["materiaal"]) || trim($_POST["materiaal"]) == "") {
        $materiaalError = "Materiaal is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultTechniek, $_POST["materiaal"], "materiaalId")) {
        $materiaalError = "Materiaal bestaat niet";
        $correct = false;
    }
    $schilderij["MarteriaalID"] = $_POST["materiaal"];
    $schilderInsert[] = $_POST["materiaal"];

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
        $id = insert("INSERT INTO schilderij (Titel, beschrijving, jaar, hoogte, breedte, categorieid, materiaalid, naam_schilder) VALUES (?,?, ?, ?, ?, ?, ?, 'ellenvanthof')", $schilderInsert);


        $newpath = "/content/uploads/" . $id . $imgExtension;

        query("UPDATE schilderij SET Img = ? WHERE Schilderij_Id = ?", array($newpath, $id));

        move_uploaded_file($_FILES["img"]["tmp_name"], "./.." . $newpath);

        header("location: schilderijList.php");
        exit();
    }
}
?>
<a href="schilderijList.php">Terug naar lijst</a>
<form action="addSchilderij.php" method="post" class="editform" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Titel</td>
            <td>
                <input type="text" name="titel" value="<?php echo $schilderij["Titel"]; ?>">
                <?php

                if (isset($titelError)) {
                    echo "<br/>" . $titelError;
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
                    echo "<br/>" . $jaarError;
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
                    echo "<br/>" . $hoogteError;
                }
                ?>
            </td>
        </tr><tr>
            <td>Breedte</td>
            <td>
                <input type="text" class="number" name="breedte" value="<?php echo $schilderij["Breedte"]; ?>"> cm
                <?php

                if (isset($breedteError)) {
                    echo "<br/>" . $breedteError;
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
                        if ($categorie["categorieId"] == $schilderij["CategorieID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $categorie["categorieId"] . "'>" . $categorie["categorie_naam"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($categorieError)) {
                    echo "<br/>" . $categorieError;
                }
                ?>
            </td>
        </tr>
         <tr>
            <td>Subcategorie</td>
            <td>
                <select name="subcategorie">
                    <?php

                    foreach ($resultCategorie as $categorie) {
                        $selected = "";
                        if ($categorie["subcategorieId"] == $schilderij["SubCategorieID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $categorie["subcategorieId"] . "'>" . $categorie["subcategorie_naam"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($subcategorieError)) {
                    echo "<br/>" . $subcategorieError;
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
                        if ($materiaal["materiaalId"] == $schilderij["MateriaalID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $materiaal["materiaalId"] . "'>" . $materiaal["materiaal_soort"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($materiaalError)) {
                    echo "<br/>" . $materiaalError;
                }
                ?>
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
                    echo "<br/>" . $afbeeldingError;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Opslaan" name="knop">
            </td>
        </tr>
    </table>
</form>
<?php

renderHtmlEndAdmin();
