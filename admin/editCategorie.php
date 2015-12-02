<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStart("inlog", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');

$uitvoerDatabase = query("SELECT * FROM Categorie", NULL);
?>
<table border="1">
<?php
foreach ($uitvoerDatabase as $value1) {
    foreach ($value1 as $key2 => $value2) {
        if ($key2 == "Categorie_naam") {
            echo "<tr><td>$value2</td>";
        } elseif ($key2 == "Beschrijving") {
            if ($value2 !== NULL && $value2 !== "") {
                echo "<td>$value2</td>";
            } else {
                echo"<td>Geen beschijving ingevuld</td>";
            }
            echo'<td><a href="</td></tr>';
        }
    }
}
?>

</table>
    <?php
    renderHtmlEnd();

    /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

