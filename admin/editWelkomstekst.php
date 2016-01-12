<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Welkomsttekst", "", "Welkomsttekst");

$naamerror = false;

if (isset($_POST["verzendknop"])){
    if (isset($_POST["Beschrijving"]) && $_POST["Beschrijving"] !== ""){
        $invoerDatabase = [$_POST["Beschrijving"]];
        query("UPDATE welkomstekst SET Welkomstekst = ? WHERE ID = 1", $invoerDatabase);
    } else {
        $naamerror = true;
    }
}

$uitvoerDatabase = query("SELECT Welkomstekst FROM welkomstekst", NULL);
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
                <textarea name="Beschrijving" rows="20" cols="75" id="text"
                          placeholder="Vul de welkomstekst (die op de hoofdpagina wordt weergeven) hier in"><?php echo $waarde; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <?php if ($naamerror === true){echo"Er moet een beschrijving worden ingevuld";} ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="button" name="empty" value="Leegmaken" id="leegmaakknop">
                <input type ="submit" name="verzendknop" value="Opslaan">
            </td>
        </tr>
    </table>
</form>

<script>
    document.getElementById("leegmaakknop").onclick=function(){
        document.getElementById("text").value="";
    }
</script>

<?php
if (isset($_POST["verzendknop"])){
    if ($_POST["verzendknop"] == "Opslaan") {
        header("location: editWelkomstekst.php#Welkomsttekst is aangepast");
        exit();
    }
}


renderHtmlEndAdmin();
