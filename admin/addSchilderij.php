<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStart("Schilderij bewerken", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');

$schilderij = array();
$schilderij["Titel"] = "";
$schilderij["Beschrijving"] = "";
$schilderij["Jaar"] = "";
$schilderij["Hoogte"] = "";
$schilderij["Breedte"] = "";
$schilderij["Categorie_naam"] = "";
$schilderij["Techniek_naam"] = "";

$resultTechniek = query("SELECT techniek_naam FROM techniek", null);
$resultCategorie = query("SELECT categorie_naam FROM categorie", null);

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

    if (!is_numeric($_POST["jaar"]) && (isset($_POST["jaar"]) || trim($_POST["jaar"]) == "")) {
        $hoogteError = "Jaar is geen getal";
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
    } elseif (!in_query_result($resultCategorie, $_POST["categorie"], "categorie_naam")) {
        $categorieError = "Categorie bestaat niet";
        $correct = false;
    }
    $schilderij["Categorie_naam"] = $_POST["categorie"];
    $schilderInsert[] = $_POST["categorie"];

    if (!isset($_POST["techniek"]) || trim($_POST["techniek"]) == "") {
        $techniekError = "Techniek is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultTechniek, $_POST["techniek"], "techniek_naam")) {
        $techniekError = "Techniek bestaat niet";
        $correct = false;
    }
    $schilderij["Techniek_naam"] = $_POST["techniek"];
    $schilderInsert[] = $_POST["techniek"];

    if ($correct) {
        query("INSERT INTO schilderij (Titel, beschrijving, jaar, hoogte, breedte, categorie_naam, techniek_naam, naam_schilder) VALUES (?,?, ?, ?, ?, ?, ?, 't')", $schilderInsert);
        header("location: schilderijList.php");
        exit();
    }
}
?>
<a href="schilderijList.php">Terug naar lijst</a>
<form action="addSchilderij.php" method="post" class="editform">
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
                        if ($categorie["categorie_naam"] == $schilderij["Categorie_naam"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $categorie["categorie_naam"] . "'>" . $categorie["categorie_naam"] . "</option>";
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
            <td>Techniek</td>
            <td>
                <select name="techniek">
                    <?php

                    foreach ($resultTechniek as $techniek) {
                        $selected = "";
                        if ($techniek["techniek_naam"] == $schilderij["techniek_naam"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $techniek["techniek_naam"] . "'>" . $techniek["techniek_naam"] . "</option>";
                    }
                    ?>
                </select>
                <?php

                if (isset($techniekError)) {
                    echo "<br/>" . $techniekError;
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

renderHtmlEnd();
