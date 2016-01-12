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
<form action="editSubcategorie.php?id=<?php echo $id; ?>" method="post">
    <table>
        <?php

        foreach ($uitvoerDatabase as $value1) {
            foreach ($value1 as $key2 => $value2) {

                if ($key2 == "Subcategorie_naam") {
                    echo"<tr><td>Naam subcategorie*</td>";
                    echo"<td><input type=\"text\" name=\"Subcategorie_Naam\" value=\"$value2\"></td></tr>";
                    $Subcategorie_naam = $value2;
                } elseif ($key2 == "SubcategorieID") {
                    echo"<input type=\"hidden\" name=\"ID\" value=\"$value2\">";
                } else {
                    echo"<tr><td>Beschrijving subcategorie</td>";
                    echo"<td><textarea rows=\"4\" cols=\"50\" name=\"BEschrijving\">$value2</textarea></td></tr>";
                    $Beschrijving = $value2;
                }
            }
        }
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

    </table>
</form>

<?php

if (isset($_POST["knopje"])) {
    if (isset($_POST["Subcategorie_Naam"]) && $_POST["Subcategorie_Naam"] !== "") {
        $id = $_GET["id"];
        $invoerDatabase2 = [uppercase($_POST["Subcategorie_Naam"]), uppercase($_POST["BEschrijving"]), $_GET["id"]];
        query("UPDATE subcategorie SET Subcategorie_naam = ?, Beschrijving = ? WHERE SubcategorieID = ?", $invoerDatabase2);
        header('location:subcategorieList.php#Wijzigingen zijn opgeslagen');
        exit();
    }
}
?>

<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u deze subcategorie wilt verwijderen?")) {
            window.location = "deleteSubcategorie.php?id=<?php echo $id; ?>";
        }
    };
</script> <?php

renderHtmlEndAdmin();

/*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        
