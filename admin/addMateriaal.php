<?php

// start stuff
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Materialen", '', "materiaal");

$saved = false;

$toevoegenMateriaal = [];
$doorgaan_naam = false;
$invoerDatabase = [];

// post is gedaan
if (isset($_POST["Toevoegen"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "") {
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        // check of materiaal al bestaat indb
        $invoerDatabase[] = uppercase($_POST["Naam"]);
        $uitvoerDatabase = query("SELECT Materiaal_soort FROM materiaal WHERE Materiaal_soort = ?", $invoerDatabase);
        if (count($uitvoerDatabase) === 0) { 
            // materiaal bestaat nog niet 
            $toevoegenMateriaal[] = uppercase($_POST["Naam"]);
            $toevoegenMateriaal[] = uppercase($_POST["Beschrijving"]);
            // add materiaal
            query("INSERT INTO materiaal (Materiaal_soort, Beschrijving) VALUES (?, ?)", $toevoegenMateriaal);
            $saved = true;
        } else {
            // bestaat al
            $errorMessage = "Toevoegen materiaal is mislukt, materiaal bestaat al.";

        }
    }
}

// terug naar overzicht
if ($saved && isset($_POST["Terug"])) {
    header("location:materiaalList.php?x=1");
    exit();
// op pagina blijven
} elseif ($saved && isset($_POST["Toevoegen"])){
    header("location:addMateriaal.php?x=1");
    exit();
}
?>

<!-- this form is used to retrieve the user data-->
<form action="addMateriaal.php" method="post">
    <h1>Vul hier de materiaal soort en beschrijving in:</h1>
    <?php
    // code die checked of de categorie daadwerkelijk is toegevoegd (wordt gestart als "toevoegen en blijven" wordt geklikt
    if (isset ($_GET["x"])){
        if ($_GET["x"] === "1"){
            $succes = "Materiaal is toegevoegd.";
        }
    }
    if(isset($errorMessage)){
        echo "<p class='incorrect'>$errorMessage</p>";
    }
    ?>
    <table>
        <tr>
            <td>
                Soort materiaal*
            </td>
            <td>
                <input type="text" name="Naam" placeholder="Vul hier de soort in" style="width: 375px">
                <?php
                // toont het eerder geïnitialiseerde succesbericht
                if (isset($error)){
                    echo '<br>' . $succes;
                }
                // deze error komt te voorschijn als er geen naam is ingevuld
                if (isset($Naamerror)) {
                    echo '<br>' . "<span class=\"incorrect\">$Naamerror</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Beschrijving materiaal
            </td>
            <td>
                <textarea rows="4" cols="50" name="Beschrijving" placeholder="Vul hier de beschrijving in"></textarea>
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
