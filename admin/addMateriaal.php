<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Materiaal", '');

$limitDatabase = [30];


$toevoegenmateriaal = [];
$doorgaan_naam = false;

if (isset($_POST["Toevoegen"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "") {
        $Naamerror = "Er moet een soort worden ingevuld.";
    } else {
        $doorgaan_naam = true;
    }
    if ($doorgaan_naam == true) {
        $toevoegenmateriaal[] = $_POST["Naam"];
        $toevoegenmateriaal[] = $_POST["Beschrijving"];
        query("INSERT INTO materiaal (materiaal_soort, Beschrijving) VALUES (?, ?)", $toevoegenmateriaal);
        $saved = true;
    }
}
$uitvoerDatabase = query("SELECT * FROM materiaal", NULL);

if ($saved) {
    ?>
    <script>
        setTimeout(function () {
            if (confirm("De wijzigingen zijn opgeslagen.\n\nWilt u terug naar het overzicht?")) {
                location = "/admin/categorieList.php";
            }
        }, 1);
    </script>
    <?php
}
?>
?>
<form action="addmateriaal.php" method="post">
    <h1>Vul hier de materiaal soort en beschrijving in:</h1>
    <table>
        <tr>
            <td>
                Soort materiaal
            </td>
            <td>
                <input type="text" name="Naam" placeholder="Vul hier de soort in" style="width: 375px">
<?php

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