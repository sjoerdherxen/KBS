<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categorie&euml;n", '');

if (isset($_GET["id"])) {
    $invoerDatabase = [$_GET["id"]];
    $uitvoerDatabase = query("SELECT * FROM Categorie WHERE Categorie_naam = ?", $invoerDatabase);
    ?>
    <form>
        <table>
            <?php
            foreach ($uitvoerDatabase as $value1) {
                foreach ($value1 as $key2 => $value2) {
                    if ($key2 == "Categorie_naam") {
                        echo"<tr><td>Naam categorie/td>";
                        echo"<td><input type=\"text\" name=\"Categorie_naam\" value=\"$value2\"></td></tr>";
                    } else {
                        echo"<tr><td>Beschrijving categorie</td>";
                        echo"<td><textarea rows=\"4\" cols=\"50\" name=\"Beschrijving\">$value2</textarea></td></tr>";
                    }
                }
            }
            ?>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Opslaan" name="knop" class="button">
                    <input type="button" value="Verwijderen" class="button" id="verwijderen">
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</form>
 


<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u deze categorie wilt verwijderen?")) {
            window.location = "deleteCategorie.php?Naam=<?php echo $uitvoerDatabase[0]["Categorie_naam"]; ?>";
        }
    };
</script>
<?php
renderHtmlEndAdmin();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

