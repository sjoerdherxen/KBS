<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categorie&euml;n", '<script src="/content/editSubcategorie.js"></script>', "subcategorie");

$saved = false;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $invoerDatabase = [$_GET["id"]];
    $uitvoerDatabase = query("SELECT * FROM subcategorie WHERE SubcategorieID = ?", $invoerDatabase);




// check of schiderij is gekoppeld voor verwijderen
    $schilderijResult = query("SELECT COUNT(*) c FROM schilderij WHERE SubcategorieID = ?", $invoerDatabase);
    $verwijderPossible = $schilderijResult[0]["c"] == 0;
}
if (!isset($uitvoerDatabase) || count($uitvoerDatabase) == 0) {
    header("location:subcategorieList.php");
    exit();
}
?>

<!-- this form is used to retrieve the user data-->
<form action="editSubcategorie.php?id=<?php echo $id; ?>" method="post">
    <table>
        <?php 
        $subcat = $uitvoerDatabase[0];

        echo"<tr><td>Naam subcategorie*</td>";
        echo"<td><input type=\"text\" name=\"Subcategorie_Naam\" value=\"" . $subcat["Subcategorie_naam"] . "\"></td></tr>";

        echo"<tr><td>Valt onder categorie*</td>";
        echo"<td><select name='categorie' style='width: 199px;'>";
        $categorieen = query("SELECT * FROM categorie", null);
        foreach ($categorieen as $cat) {
            if ($cat["CategorieID"] == $subcat["CategorieID"]) {
                echo "<option value='" . $cat["CategorieID"] . "' selected>" . $cat["Categorie_naam"] . "</option>";
            } else {
                echo "<option value='" . $cat["CategorieID"] . "' >" . $cat["Categorie_naam"] . "</option>";
            }
        }
        echo"</select></td></tr>";

        echo"<input type=\"hidden\" name=\"ID\" value=\"" . $subcat["SubcategorieID"] . "\">";

        echo"<tr><td>Beschrijving subcategorie</td>";
        echo"<td><textarea rows=\"4\" cols=\"50\" name=\"BEschrijving\">" . $subcat["Beschrijving"] . "</textarea></td></tr>";
        ?>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Opslaan" name="knopje">
                <?php

                if ($verwijderPossible) {
                    echo '<input type="button" value="Verwijderen" class="button" id="verwijderen">';
                } else {
                    echo '<input type="button" value="Verwijderen" class="button" disabled="disabled" title="Subcategorie kan niet worden verwijderd, want er zijn schilderijen aan gekoppeld.">';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Alle velden met een ster zijn verplicht
            </td>
        </tr>
    </table>
</form>

<?php

// verwerken van formulier gegevens en naar database schrijven
if (isset($_POST["knopje"])) {
    if (isset($_POST["Subcategorie_Naam"]) && $_POST["Subcategorie_Naam"] !== "" && is_numeric($_POST["categorie"])) {
        $id = $_GET["id"];
        $invoerDatabase2 = [uppercase($_POST["Subcategorie_Naam"]), uppercase($_POST["BEschrijving"]),$_POST["categorie"], $_GET["id"]];
        query("UPDATE subcategorie SET Subcategorie_naam = ?, Beschrijving = ?, CategorieID = ? WHERE SubcategorieID = ?", $invoerDatabase2);
        header('location:subcategorieList.php#Wijzigingen zijn opgeslagen');
        exit();
    }
}
?>

<!-- script voor pop-up verwijderen -->
<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u deze subcategorie wilt verwijderen?")) {
            window.location = "deleteSubcategorie.php?id=<?php echo $id; ?>";
        }
    };
</script> <?php

$schilderijen = query("SELECT * FROM schilderij WHERE SubcategorieID = ?", [$id]);
toonSchilderijLijst($schilderijen);

renderHtmlEndAdmin();

/*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        
