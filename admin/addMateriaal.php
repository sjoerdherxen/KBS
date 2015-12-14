<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Materiaalen", '');

$limitDatabase = [30];
$saved = false;

$toevoegenMateriaal = [];
$doorgaan_naam = false;
$invoerDatabase = [];

if (isset($_POST["Toevoegen"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "") {
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        $toevoegenMateriaal[] = $_POST["Naam"];
        $toevoegenMateriaal[] = $_POST["Beschrijving"];
        $invoerDatabase[] = $_POST["Naam"];
        $uitvoerDatabase = query("SELECT Materiaal_soort FROM Materiaal Where Materiaal_soort = ?", $invoerDatabase);
        if (count($uitvoerDatabase) === 0) {
            query("INSERT INTO Materiaal (Materiaal_soort, Beschrijving) VALUES (?, ?)", $toevoegenMateriaal);
            $saved = true;
        } else {
            ?>
            <script>
                alert("Toevoegen materiaal is mislukt, materiaal bestaat al.");
            </script>
            <?php
        }
    }
}

if ($saved) {
    ?>
    <script>
        setTimeout(function () {
            if (confirm("Het materiaal is toegevoegd.\n\nWilt u terug naar het overzicht?")) {
                location = "/admin/materiaalList.php";
            }
        }, 1);
    </script>
    <?php
}
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