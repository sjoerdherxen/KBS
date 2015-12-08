<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderij bewerken", "");

// schilderij id uit get of redirect naar lijst
$schilderijId = $_GET["id"];
if (!isset($schilderijId) || $schilderijId == "" || !is_numeric($schilderijId)) {
    header("location: schilderijList.php");
    exit();
}

$doSelectQuery = true;
$resultTechniek = query("SELECT techniekId, techniek_naam FROM techniek", null);
$resultCategorie = query("SELECT categorieId, categorie_naam FROM categorie", null);

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

    if (!isset($_POST["jaar"]) || !(is_numeric($_POST["jaar"]) || trim($_POST["jaar"]) == "")) {
        $jaarError = "Jaar is geen getal";
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
    } elseif (!in_query_result($resultCategorie, $_POST["categorie"], "categorieId")) {
        $categorieError = "Categorie bestaat niet";
        $correct = false;
    }
    $schilderij["CategorieID"] = $_POST["categorie"];
    $schilderijUpdate[] = $_POST["categorie"];

    if (!isset($_POST["techniek"]) || trim($_POST["techniek"]) == "") {
        $techniekError = "Techniek is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultTechniek, $_POST["techniek"], "techniekId")) {
        $techniekError = "Techniek bestaat niet";
        $correct = false;
    }
    $schilderij["TechniekID"] = $_POST["techniek"];
    $schilderijUpdate[] = $_POST["techniek"];

    $updateImg = false;
    if (isset($_FILES["img"]) && $_FILES["img"]["size"] > 0) {
        $imgExtension = strtolower(strrchr($_FILES["img"]["name"], "."));
        $correctExtensions = array(".png", ".jpg", ".jpeg", ".gif");

        if (!in_array($imgExtension, $correctExtensions) || $_FILES["img"]["error"] !== 0 || $_FILES["img"]["size"] == 0) {
            $afbeeldingError = "Geen afbeelding gekozen";
            $correct = false;
        } else {
            $updateImg = true;
        }
    }

    $schilderijUpdate[] = $schilderijId;
    if ($correct) {
        query("UPDATE schilderij SET titel=?, beschrijving=?, jaar=?, hoogte=?, breedte=?, categorie_naam=?, techniek_naam=? WHERE Schilderij_ID=?", $schilderijUpdate);
        if ($updateImg) {
            $resultImg = query("SELECT Img FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
            if(file_exists("./.." . $resultImg[0]["Img"])){
                unlink("./.." . $resultImg[0]["Img"]);
            }
            
            $newpath = "/content/uploads/" . $schilderijId . $imgExtension;
            move_uploaded_file($_FILES["img"]["tmp_name"], "./.." . $newpath);

            query("UPDATE schilderij SET Img = ? WHERE Schilderij_Id = ?", array($newpath, $schilderijId));
        }

        header("location: SchilderijList.php#Schilderij is aangepast");
        exit();
    } else {
        $doSelectQuery = false;
    }
}

// schilderij ophalen anders naar main
if ($doSelectQuery) {
    $resultSchilderij = query("SELECT * FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
    if ($resultSchilderij === null) {
        header("location: schilderijList.php");
        exit();
    } elseif (count($resultSchilderij) == 0) {
        header("location: schilderijList.php");
        exit();
    } else {
        // schilderij gevonden
        $schilderij = $resultSchilderij[0];
        if ($schilderij["Jaar"] == "0000") {
            $schilderij["Jaar"] = "";
        }
    }
} else {
   // $resultImg = query("SELECT Img FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
    //$schilderij["Img"] = $resultImg[0]["Img"];
}
?>
<p>
    <a href="schilderijList.php">Terug naar lijst</a>
</p>

<form action="editSchilderij.php?id=<?php echo $schilderijId; ?>" method="post" class="editform" enctype="multipart/form-data">
    <table>
        <colgroup>
            <col style="width: 140px;">
            <col style="width: 172px;">
        </colgroup>
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
            <td>Techniek</td>
            <td>
                <select name="techniek">
                    <?php

                    foreach ($resultTechniek as $techniek) {
                        $selected = "";
                        if ($techniek["techniekId"] == $schilderij["TechniekID"]) {
                            $selected = "selected='selected'";
                        }

                        echo "<option " . $selected . " value='" . $techniek["techniekId"] . "'>" . $techniek["techniek_naam"] . "</option>";
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
            <td colspan="2">Afbeelding (laat leeg om huidige afbeelding     te houden)</td>
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
                <input type="submit" value="Opslaan" name="knop" class="button">
                <input type="button" value="Verwijderen" class="button" id="verwijderen">
            </td>
        </tr>
    </table>
</form>
<div id="editSchilderijImg">
     <img src="<?php echo $schilderij["Img"] . ".?_=" . strtotime(date("Y-m-d H:i:s")); ?>">
</div>

<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u dit schilderij wilt verwijderen?")) {
            window.location = "deleteSchilderij.php?id=<?php echo $schilderijId; ?>";
        }
    };
</script>


<?php

renderHtmlEndAdmin();
