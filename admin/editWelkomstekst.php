<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Welkomstekst", "", "Welkomteskst");

if (isset($_POST["verzendknop"])){
    if (isset($_POST["Beschrijving"]) && $_POST["Beschrijving"] !== ""){
        var_dump($_POST["Beschrijving"]);
        $invoerDatabase = [$_POST["Beschrijving"]];
        query("UPDATE Welkomstekst SET Beschrijving = ? WHERE ID = 1", $invoerDatabase);
    }
}

$uitvoerDatabase = query("SELECT Beschrijving FROM Welkomstekst", NULL);
foreach ($uitvoerDatabase as $value1){
    foreach ($value1 as $value2){
        if (trim($value2) === ""){
            $waarde = NULL;
        } else {
            $waarde = $value2;
        }
    }
}
?>
<form action="editWelkomstekst.php" method="post">
    <table>
        <tr>
            <td>
                Tekst:
            </td>
        </tr>
        <tr>
            <td>
                <textarea name="Beschrijving" rows="4" cols="50"
                          placeholder="Vul de welkomstekst (die op de hoofdpagina wordt weergeven) hier in"><?php echo $waarde; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="button" name="empty" value="Leegmaken">
                <input type ="submit" name="verzendknop" value="Opslaan">
            </td>
        </tr>
    </table>
</form>


<?php
renderHtmlEndAdmin();
