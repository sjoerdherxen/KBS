<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Subcategorie&euml;n", '', "subcategorie");

$limitDatabase = [30];
$saved = false;

$toevoegenSubcategorie = [];
$doorgaan_naam = false;
$invoerDatabase = [];

if (isset($_POST["Toevoegen"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "") {
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        $toevoegenSubcategorie[] = $_POST["Naam"];
        $toevoegenSubcategorie[] = $_POST["Beschrijving"];
        $invoerDatabase[] = $_POST["Naam"];
        $uitvoerDatabase = query("SELECT Subcategorie_naam FROM Subcategorie Where Subcategorie_naam = ?", $invoerDatabase);
        if (count($uitvoerDatabase) === 0) {
            query("INSERT INTO Subcategorie (Subcategorie_naam, Beschrijving) VALUES (?, ?)", $toevoegenSubcategorie);
            $saved = true;
        } else {
            ?>
            <script>
                alert("Toevoegen subcategorie is mislukt, subcategorie bestaat al.");
            </script>
            <?php
        }
    }
}

if ($saved) {
    ?>
    <script>
        setTimeout(function () {
            if (confirm("De subcategorie is toegevoegd.\n\nWilt u terug naar het overzicht?")) {
                location = "/admin/subcategorieList.php";
            }
        }, 1);
    </script>
    <?php
}


?>
<form action="addSubcategorie.php" method="post">
    <h1>Vul hier de subcategorienaam en beschrijving in:</h1>
    <table>
        <tr>
            <td>
                Naam subcategorie
            </td>
            <td>
                <input type="text" name="Naam" placeholder="Vul hier de naam in" style="width: 375px">
<?php

if (isset($Naamerror)) {
    echo '<br>' . "<span class=\"incorrect\">$Naamerror</span>";
}
?>
            </td>
        </tr>
        <tr>
            <td>
                Beschrijving subcategorie
            </td>
            <td>
                <textarea rows="4" cols="50" name="Beschrijving" placeholder="Vul hier de beschrijving in"></textarea>
                <?php
                ?>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type="submit" name="Toevoegen" value="Toevoegen">
            </td>
        </tr>
    </table>
</form>     
<?php
renderHtmlEndAdmin();