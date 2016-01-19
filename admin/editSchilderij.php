<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderij bewerken", "", "schilderij");

// schilderij id uit get of redirect naar lijst
$schilderijId = $_GET["id"];
if (!isset($schilderijId) || $schilderijId == "" || !is_numeric($schilderijId)) {
    header("location: schilderijList.php");
    exit();
}

$doSelectQuery = true;
$resultMateriaal = query("SELECT MateriaalID, Materiaal_soort FROM materiaal", null);
$resultCategorie = query("SELECT CategorieID, Categorie_naam FROM categorie", null);
$resultSubCategorie = query("SELECT SubcategorieID, Subcategorie_naam, CategorieID FROM subcategorie", null);

// update schilderij
if (isset($_POST["knop"])) {
    $correct = true;
    $schilderij = array();
    $schilderijUpdate = array();

    // validate inputs
    if (!isset($_POST["titel"]) || trim($_POST["titel"]) == "") {
        $titelError = "Titel is verplicht";
        $correct = false;
    }
    $schilderij["Titel"] = $_POST["titel"];
    $schilderijUpdate[] = uppercase($_POST["titel"]);
    
    $schilderij["OpWebsite"] = $_POST["OpWebsite"];
    $schilderijUpdate[] = $_POST["OpWebsite"] ? 1 : 0;

    $schilderij["Beschrijving"] = $_POST["beschrijving"];
    $schilderijUpdate[] = uppercase($_POST["beschrijving"]);

    $schilderij["lijst"] = isset($_POST["lijst"]);
    $schilderijUpdate[] = $schilderij["lijst"] ? 1 : 0;

    $schilderij["passepartout"] = isset($_POST["passepartout"]);
    $schilderijUpdate[] = $schilderij["passepartout"] ? 1 : 0;

    $schilderij["isStaand"] = $_POST["isStaand"] == "true";
    $schilderijUpdate[] = $schilderij["isStaand"] ? 1 : 0;

    if (!is_numeric($_POST["jaar"]) && isset($_POST["jaar"]) && trim($_POST["jaar"]) != "") {
        $jaarError = "Jaar is geen getal";
        $correct = false;
    }
    $schilderij["Jaar"] = $_POST["jaar"];
    $schilderijUpdate[] = $_POST["jaar"] == "" ? null : $_POST["jaar"];

    if (!is_numeric($_POST["prijs"]) && isset($_POST["prijs"]) && trim($_POST["prijs"]) != "") {
        $jaarError = "Prijs is geen getal";
        $correct = false;
    }
    $schilderij["prijs"] = $_POST["prijs"];
    $schilderijUpdate[] = $_POST["prijs"] == "" ? null : $_POST["prijs"];

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
    } elseif (!in_query_result($resultCategorie, $_POST["categorie"], "CategorieID")) {
        $categorieError = "Categorie bestaat niet";
        $correct = false;
    }
    $schilderij["CategorieID"] = $_POST["categorie"];
    $schilderijUpdate[] = $_POST["categorie"];

    if (!isset($_POST["materiaal"]) || trim($_POST["materiaal"]) == "") {
        $materiaalError = "Materiaal is verplicht";
        $correct = false;
    } elseif (!in_query_result($resultMateriaal, $_POST["materiaal"], "MateriaalID")) {
        $materiaalError = "Materiaal bestaat niet";
        $correct = false;
    }
    $schilderij["MateriaalID"] = $_POST["materiaal"];
    $schilderijUpdate[] = $_POST["materiaal"];

    if (!isset($_POST["subcategorie"])) {
        $subcategorieError = "Subcategorie is fout";
        $correct = false;
    } elseif (trim($_POST["subcategorie"]) != "" && !in_query_result($resultSubCategorie, $_POST["subcategorie"], "SubcategorieID")) {
        $subcategorieError = "Subcategorie bestaat niet";
        $correct = false;
    }
    $schilderij["SubcategorieID"] = $_POST["subcategorie"];
    $schilderijUpdate[] = $_POST["subcategorie"];


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
    // nieuwe waarden naar database schrijven
    $schilderijUpdate[] = $schilderijId;
    if ($correct) {
        query("UPDATE schilderij SET Titel=?, OpWebsite=?, Beschrijving=?, lijst=?, passepartout=?, isStaand=?, Jaar=?, prijs=?, Hoogte=?, Breedte=?, CategorieID=?, MateriaalID=?, SubcategorieID=? WHERE Schilderij_ID=?", $schilderijUpdate);
        if ($updateImg) {
            $resultImg = query("SELECT Img FROM schilderij WHERE Schilderij_ID = ?", array($schilderijId));

            uploadSchilderijImg($schilderijId, $imgExtension, $resultImg[0]["Img"], null);
           }

        header("location: schilderijList.php#Schilderij " . $schilderij["Titel"] . " is aangepast");
        exit();
    } else {
        $doSelectQuery = false;
    }
}

// schilderij ophalen anders naar main
if ($doSelectQuery) {
    $resultSchilderij = query("SELECT * FROM schilderij WHERE Schilderij_ID = ?", array($schilderijId));
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
    $resultImg = query("SELECT Img FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
    $schilderij["Img"] = $resultImg[0]["Img"];
}
?>
<p>
    <a href="schilderijList.php">Terug naar lijst</a>
</p>
<div class="row">
    <div class="col-md-3">
        <!-- this form is used to retrieve the user data-->
        <form action="editSchilderij.php?id=<?php echo $schilderijId; ?>" method="post" class="editform" enctype="multipart/form-data">
            <table>
                <colgroup>
                    <col style="width: 140px;">
                    <col style="width: 172px;">
                </colgroup>
                <tr>
                    <td>Titel*</td>
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
                    <td>Hoogte*</td>
                    <td>
                        <input type="text" class="number" name="hoogte" value="<?php echo $schilderij["Hoogte"]; ?>"> cm
                        <?php

                        if (isset($hoogteError)) {
                            echo "<br/>" . $hoogteError;
                        }
                        ?>
                    </td>
                </tr><tr>
                    <td>Breedte*</td>
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
                    <td>Categorie*</td>
                    <td>
                        <select name="categorie" id="categorieSelect">
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
                            echo "<br/>" . $categorieError;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Subcategorie</td>
                    <td>
                        <select name="subcategorie" id="subcategorieSelect">
                            <option value="">--geen--</option>
                        </select>
                        <?php

                        if (isset($subcategorieError)) {
                            echo "<br/>" . $subcategorieError;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Materiaal*</td>
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
                            echo "<br/>" . $materiaalError;
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
                    <td>Prijs</td>
                    <td>
                        &euro; <input type="text" name="prijs" class="number" value="<?php echo $schilderij["prijs"]; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Op website
                    </td>
                    <td>
                        <input type="checkbox" value="true" name="OpWebsite" <?php if ($schilderij["OpWebsite"]){ echo'checked="checked"'; }?>>
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
                    <td colspan="2">
                        <input type="submit" value="Opslaan" name="knop" class="button">
                        <input type="button" value="Verwijder" class="button" id="verwijderen">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Alle velden met een ster zijn verplicht</td>
                </tr>
            </table>
        </form>
    </div>

    <div class="col-md-6">
        <div id="editSchilderijImg">
            <img src="/content/uploads/<?php echo $schilderij["Img"] . "?_=" . strtotime(date("Y-m-d H:i:s")); ?>">
        </div>
        <form action="rotate-img.php?id=<?php echo $schilderijId ?>" method="post">
                <input type="submit" value="afbeelding draaien" name="rotate_img" id="rotate_img">
                <?php ?>
        </form>
    </div>

    <div class="col-md-3">
        <div class="bordercomment">
            <div class="comments">
                <?php

                $comments = query("SELECT * FROM commentaar C where Schilderij_ID=?", [$schilderijId]);
                foreach ($comments as $comment) {
                    ?>
                    <div class="comment-box">
                        <div class="comment-naam">
                            <?php echo $comment["Naam_klant"]; ?>
                            <a class="delete-comment" data-id="<?php echo $comment["Id"]; ?>" data-name="<?php echo $comment["Naam_klant"]; ?>" href="">verwijderen</a>
                        </div>
                        <div class="comment-beschrijving"><?php echo $comment["Opmerking"]; ?></div>
                    </div>
                    <?php

                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    /* script voor pop-up verwijderen schilderij */
    $(function () {

        $("#verwijderen").click(function () {
            if (confirm("Weet u zeker dat u dit schilderij wilt verwijderen?")) {
                window.location = "deleteSchilderij.php?id=<?php echo $schilderijId; ?>";
            }
        });
        /* script voor pop-up verwijderen commentaar */
        $(".delete-comment").click(function () {
            var element = $(this);
            var name = element.data("name");
            if (confirm("Weet u zeker dat u de comment van " + name + " wilt verwijderen?")) {
                var id = element.data("id");
                $.get("/admin/deleteComment.php?id=" + id).done(function (response) {
                    if (response == "true") {
                        element.parents(".comment-box").remove();
                    } else {
                        alert("Er is een fout opgetreden");
                    }
                }).fail(function () {
                    alert("Er is een fout opgetreden");
                });
            }
        });

        var subcats = [
<?php

foreach ($resultSubCategorie as $subcategorie) {
    $selected = "false";
    if ($subcategorie["SubcategorieID"] == $schilderij["SubcategorieID"]) {
        $selected = "true";
    }

    echo "{id: " . $subcategorie["SubcategorieID"] . ", naam: '" . $subcategorie["Subcategorie_naam"] . "', categorieID: " . $subcategorie["CategorieID"] . ", selected:" . $selected . "},";
}
?>
        ];
        function updateSubcat() {
            var cat = $("#categorieSelect").val();
            var options = "<option value=''>-- Geen --</option>";
                    var selected = "";
            for (var key in subcats) {
                if (subcats[key].categorieID == cat) {
                    options += "<option value='" + subcats[key].id + "'>" + subcats[key].naam + "</option>";
                    if (subcats[key].selected) {
                        selected = subcats[key].id;
                    }
                }
            }
            $("#subcategorieSelect").html(options);
            $("#subcategorieSelect").val(selected);
        }
        updateSubcat();
        $("#categorieSelect").change(function () {
            updateSubcat();
        });
    });
</script>


<?php

renderHtmlEndAdmin();
