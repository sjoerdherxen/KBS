<?php



session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStart("inlog", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');



if (isset($_POST["Toevoegen"])){
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == ""){
        $Naamerror = "Er moet een naam worden ingevuld.";
    }
    if (!isset($_POST["Beschrijving"]) || $_POST["Beschrijving"] == ""){
        $Beschrijvingerror = "Er moet een beschrijving worden ingevuld.";
    }
}
?>
<form action="Categorieen.php" method="post">
   <h1>Vul hier de categorienaam en beschrijving in:</h1>
   <table>
        <tr>
            <td>
                Naam categorie:
            </td>
            <td>
                <input type="text" name="Naam" placeholder="Vul hier de naam in" style="width: 375px">
                <?php
                if (isset($Naamerror)){
                    echo '<br>' . "<span class=\"incorrect\">$Naamerror</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Beschrijving categorie:
            </td>
            <td>
                <textarea rows="4" cols="50" name="Beschrijving" placeholder="Vul hier de beschrijving in"></textarea>
                <?php
                if (isset($Beschrijvingerror)){
                    echo '<br>' . "<span class=\"incorrect\">$Beschrijvingerror</span>";
                }
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

renderHtmlEnd();



/* 
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

