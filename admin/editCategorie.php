<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categorie&euml;n", '<script src="/content/editCategorie.js"></script>', "categorie");

$saved = false;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $invoerDatabase = [$_GET["id"]];
    $uitvoerDatabase = query("SELECT * FROM Categorie WHERE CategorieID = ?", $invoerDatabase);
    
// check of schiderij is gekoppeld voor verwijderen
    $schilderijResult = query("SELECT COUNT(*) c FROM Schilderij WHERE CategorieId = ?", $invoerDatabase);
    $verwijderPossible = $schilderijResult[0]["c"] == 0;
}
?>
<form action="editCategorie.php?id=<?php echo $id; ?>" method="post">
    <table>
        <?php

        foreach ($uitvoerDatabase as $value1) {
            foreach ($value1 as $key2 => $value2) {

                if ($key2 == "Categorie_naam") {
                    echo"<tr><td>Naam categorie</td>";
                    echo"<td><input type=\"text\" name=\"Categorie_Naam\" value=\"$value2\"></td></tr>";
                    $Categorie_naam = $value2;
                } elseif ($key2 == "CategorieID") {
                    echo"<input type=\"hidden\" name=\"ID\" value=\"$value2\">";
                } else {
                    echo"<tr><td>Beschrijving categorie</td>";
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
                    echo '<input type="button" value="Verwijderen" class="button" disabled="disabled" title="Categorie kan niet worden verwijderd, want er zijn schilderijen aan gekoppeld.">';
                }
                ?>
            </td>
        </tr>

    </table>
</form>


<?php

if (isset($_POST["knopje"])) {
    if (isset($_POST["Categorie_Naam"]) && $_POST["Categorie_Naam"] !== "") {
        $id = $_GET["id"];
        $invoerDatabase2 = [$_POST["Categorie_Naam"], $_POST["BEschrijving"], $_GET["id"]];
        query("UPDATE Categorie SET Categorie_naam = ?, Beschrijving = ? WHERE CategorieID = ?", $invoerDatabase2);
        header('location:categorieList.php#Wijzigingen zijn opgeslagen');
        exit();
    }
}
?>

<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u deze categorie wilt verwijderen?")) {
            window.location = "deleteCategorie.php?id=<?php echo $id; ?>";
        }
    };
</script> <?php

renderHtmlEndAdmin();
