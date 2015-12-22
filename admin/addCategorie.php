<?php

// start stuff
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categorie&euml;n", '', "categorie");

$saved = false; // wordt gebruikt voor popup na opslaan

$toevoegenCategorie = [];
$doorgaan_naam = false;
$invoerDatabase = [];

// post is gedaan
if (isset($_POST["Toevoegen"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "") { // check naam invoer
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        // check of categorie naam al eerder is ingevuld
        $invoerDatabase[] = $_POST["Naam"];
        $uitvoerDatabase = query("SELECT Categorie_naam FROM Categorie Where Categorie_naam = ?", $invoerDatabase);
        if (count($uitvoerDatabase) === 0) { // categorie bestaat nog niet
            $toevoegenCategorie[] = $_POST["Naam"];
            $toevoegenCategorie[] = $_POST["Beschrijving"];
            // add to db
            query("INSERT INTO Categorie (Categorie_naam, Beschrijving) VALUES (?, ?)", $toevoegenCategorie);
            $saved = true;
        } else {
            // bestaat al
            $errorMessage = "Toevoegen categorie is mislukt, categorie bestaat al.";
        }
    }
}

if ($saved) {
    ?>
    <script>
        setTimeout(function () {
            if (confirm("De categorie is toegevoegd.\n\nWilt u terug naar het overzicht?")) {
                location = "/admin/categorieList.php";
            }
        }, 1);
    </script>
    <?php

}
?>
<form action="addCategorie.php" method="post">
    <h1>Vul hier de categorienaam en beschrijving in:</h1>
    <?php
        if(isset($errorMessage)){
            echo "<p class='incorrect'>$errorMessage</p>";
        }
    ?>
    <table>
        <tr>
            <td>
                Naam categorie
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
                Beschrijving categorie
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
                <input type="submit" name="Toevoegen" value="Toevoegen">
            </td>
        </tr>
    </table>
</form>
<?php

renderHtmlEndAdmin();



/*
         * 
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        