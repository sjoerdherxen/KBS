<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderij bewerken", "");

// schilderij id uit get of redirect naar main
$schilderijId = $_GET["id"];
if (!isset($schilderijId) || $schilderijId == "" || !is_numeric($schilderijId)) {
    header("location: main.php");
    exit();
}

$doSelectQuery = true;
$resultTechniek = query("SELECT techniek_naam FROM techniek", null);
$resultCategorie = query("SELECT categorie_naam FROM categorie", null);

// update schilderij
if (isset($_POST["knop"])) {
    $correct = true;
    $schilderij = array();
    $schilderijUpdate = array();

    if (!isset($_POST["titel"]) || trim($_POST["titel"]) == "") {
        $titelError = "Titel is verplicht";
        $correct = false;
    }
    $schilderij["Titel"] = $_POST["titel"];
    $schilderijUpdate[] = $_POST["titel"];

    $schilderij["Beschrijving"] = $_POST["beschrijving"];
    $schilderijUpdate[] = $_POST["beschrijving"];

    if (!is_numeric($_POST["jaar"]) && (isset($_POST["jaar"]) || trim($_POST["jaar"]) == "")) {
        $hoogteError = "Jaar is geen getal";
        $correct = false;
    }
    $schilderij["Jaar"] = $_POST["jaar"];
    $schilderijUpdate[] = $_POST["jaar"];

    if (!isset($_POST["hoogte"]) || trim($_POST["hoogte"]) == "") {
        $hoogteError = "Hoogte is verplicht";
        $correct = false;
    } elseif (!is_numeric($_POST["hoogte"])) {
        $hoogteError = "Hoogte is geen getal";
        $correct = false;
    }
    $schilderij["Hoogte"] = $_POST["hoogte"];
    $schilderijUpdate[] = $_POST["hoogte"];

    if (!isset($_POST["breedte"]) || trim($_POST["breedte"]) == "") {
        $breedteError = "Breedte is verplicht";
        $correct = false;
    } elseif (!is_numeric($_POST["breedte"])) {
        $breedteError = "Breedte is geen getal";
        $correct = false;
    }
    $schilderij["Breedte"] = $_POST["breedte"];
    $schilderijUpdate[] = $_POST["breedte"];

    if (!isset($_POST["categorie"]) || trim($_POST["categorie"]) == "") {
        $categorieError = "Categorie is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultCategorie, $_POST["categorie"], "categorie_naam")) {
        $categorieError = "Categorie bestaat niet";
        $correct = false;
    }
    $schilderij["Categorie_naam"] = $_POST["categorie"];
    $schilderijUpdate[] = $_POST["categorie"];

    if (!isset($_POST["techniek"]) || trim($_POST["techniek"]) == "") {
        $techniekError = "Techniek is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultTechniek, $_POST["techniek"], "techniek_naam")) {
        $techniekError = "Techniek bestaat niet";
        $correct = false;
    }
    $schilderij["Techniek_naam"] = $_POST["techniek"];
    $schilderijUpdate[] = $_POST["techniek"];
    $schilderijUpdate[] = $schilderijId;
    if ($correct) {
        query("UPDATE schilderij SET titel=?, beschrijving=?, jaar=?, hoogte=?, breedte=?, categorie_naam=?, techniek_naam=? WHERE Schilderij_ID=?", $schilderijUpdate);
        $succes = "Schilderij is aangepast.";
    } else {
        $doSelectQuery = false;
    }
}

// schilderij ophalen anders naar main
if ($doSelectQuery) {
    $resultSchilderij = query("SELECT * FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
    if ($resultSchilderij === null) {
        header("location: main.php");
        exit();
    } elseif (count($resultSchilderij) == 0) {
        header("location: main.php");
        exit();
    } else {
        // schilderij gevonden
        $schilderij = $resultSchilderij[0];
        if ($schilderij["Jaar"] == "0000") {
            $schilderij["Jaar"] = "";
        }
    }
}
?>
<a href="schilderijList.php">Terug naar lijst</a>
<?php

if (isset($succes)) {
    echo $succes;
}
?>
<form action="editSchilderij.php?id=<?php echo $schilderijId; ?>" method="post" class="editform">
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
                <input type="submit" value="Opslaan" name="knop" class="button">
                <input type="button" value="Verwijderen" class="button" id="verwijderen">
            </td>
        </tr>
    </table>
</form>
<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u dit schilderij wilt verwijderen?")) {
            window.location = "deleteSchilderij.php?id=<?php echo $schilderijId; ?>";
        }
    };
</script>


<?php

renderHtmlEndAdmin();
