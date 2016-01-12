<?php

// start stuff
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Subcategorie&euml;n", '', "subcategorie");

$saved = false;

$toevoegenSubcategorie = [];
$doorgaan_naam = false;
$invoerDatabase = [];

// post is gedaan
if (isset($_POST["Toevoegen"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "") { // check naam is leeg
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        // check naam al bestaad
        $invoerDatabase[] = uppercase($_POST["Naam"]);
        $uitvoerDatabase = query("SELECT Subcategorie_naam FROM subcategorie WHERE Subcategorie_naam = ?", $invoerDatabase);
        if (count($uitvoerDatabase) === 0) {
            // subcat bestaat nog niet dus invoeren
            $toevoegenSubcategorie[] = uppercase($_POST["Naam"]);
            $toevoegenSubcategorie[] = uppercase($_POST["Beschrijving"]);
            query("INSERT INTO subcategorie (Subcategorie_naam, Beschrijving) VALUES (?, ?)", $toevoegenSubcategorie);
            $saved = true;
        } else {
            // bestaat al
            $errorMessage = "Toevoegen subcategorie is mislukt, subcategorie bestaat al.";

        }
    }
}

// terug naar overzicht
if ($saved && isset($_POST["Terug"])) {
    header("location:subcategorieList.php?x=1");
    exit();
} elseif ($saved && isset($_POST["Toevoegen"])){
    header("location:addSubcategorie.php?x=1");
    exit();
}
?>
<form action="addSubcategorie.php" method="post">
    <h1>Vul hier de subcategorienaam en beschrijving in:</h1>
     <?php
     if (isset ($_GET["x"])){
        if ($_GET["x"] === "1"){
            $succes = "Subcategorie is toegevoegd.";
        }
    }
    if(isset($errorMessage)){
        echo "<p class='incorrect'>$errorMessage</p>";
    }
    ?>
    <table>
        <tr>
            <td>
                Naam subcategorie*
            </td>
            <td>
                <input type="text" name="Naam" placeholder="Vul hier de naam in" style="width: 375px">
                <?php
                if (isset($succes)){
                    echo '<br>' . $succes;
                }
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
                <?php ?>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type="submit" name="Terug" value="Toevoegen en naar overzicht">
                <input type="submit" name="Toevoegen" value="Toevoegen en blijven">
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

renderHtmlEndAdmin();
