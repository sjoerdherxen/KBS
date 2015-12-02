<?php



session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStart("inlog", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');

$limitDatabase = [30];


$toevoegenCategorie = [];
$doorgaan_naam = false;

if (isset($_POST["Toevoegen"])){
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == ""){
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        $doorgaan_naam = true;
    }
    if ($doorgaan_naam == true){
        $toevoegenCategorie[] = $_POST["Naam"];
        $toevoegenCategorie[] = $_POST["Beschrijving"];
        query("INSERT INTO Categorie (Categorie_naam, Beschrijving) VALUES (?, ?)", $toevoegenCategorie);
    }
}
$uitvoerDatabase = query("SELECT * FROM Categorie", NULL);
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
<table border="1">
    <tr>
        <th>
            Naam Categorie
        </th>
        <th>
            Beschrijving Categorie
        </th>
    </tr>
            <?php
            foreach ($uitvoerDatabase as $value1){
                foreach ($value1 as $key2 => $value2){
                    if ($key2 == "Categorie_naam"){
                        echo "<tr><td>$value2</td>";
                    } elseif ($key2 == "Beschrijving"){
                        if ($value2 !== NULL && $value2 !== ""){
                            echo "<td>$value2</td></tr>";
                        } else {
                            echo"<td>Geen beschijving ingevuld</td></tr>";
                        }
                    }
                }
            }
            ?>
</table>       
<?php
renderHtmlEnd();



/* 
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

