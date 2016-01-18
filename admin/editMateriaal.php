<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Materiaal", '<script src="/content/editMateriaal.js"></script>', "materiaal");

$saved = false;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $invoerDatabase = [$_GET["id"]];
    $uitvoerDatabase = query("SELECT * FROM materiaal WHERE MateriaalID = ?", $invoerDatabase);

// check of schiderij is gekoppeld voor verwijderen
    $schilderijResult = query("SELECT COUNT(*) c FROM schilderij WHERE MateriaalID = ?", $invoerDatabase);
    $verwijderPossible = $schilderijResult[0]["c"] == 0;
    
}
if (!isset($uitvoerDatabase) || count($uitvoerDatabase) == 0) {
    header("location:materiaalList.php");
    exit();
}

// verwerken gegevens formulier en naar database schrijven
if (isset($_POST["knopje"])) {
    if (isset($_POST["Materiaal_Soort"]) && $_POST["Materiaal_Soort"] !== "") {
        $id = $_GET["id"];
        $invoerDatabase2 = [uppercase($_POST["Materiaal_Soort"]), uppercase($_POST["BEschrijving"]), $_GET["id"]];
        query("UPDATE materiaal SET Materiaal_soort = ?, Beschrijving = ? WHERE MateriaalID = ?", $invoerDatabase2);
        header('location:materiaalList.php#Wijzigingen zijn opgeslagen');
        exit();
    } else {
        $Naamerror = "Er moet een soort worden ingevuld.";
    }
}
?>

<!-- this form is used to retrieve the user data-->
<form action="editMateriaal.php?id=<?php echo $id; ?>" method="post">
    <h1>Pas hier de categorienaam en/of beschrijving aan.</h1>
    <table>
        <?php
        foreach ($uitvoerDatabase as $value1) {
            foreach ($value1 as $key2 => $value2) {

                if ($key2 == "Materiaal_soort") {
                    echo"<tr><td>Soort materiaal*</td>";
                    echo"<td><input type=\"text\" name=\"Materiaal_Soort\" value=\"$value2\">";
                    if (isset($Naamerror)) {
                    echo '<br>' . "<span class=\"incorrect\">$Naamerror</span>";
                    }
                    echo "</td></tr>";
                    $Materiaal_soort = $value2;
                } elseif ($key2 == "MateriaalID") {
                    echo"<input type=\"hidden\" name=\"ID\" value=\"$value2\">";
                } else {
                    echo"<tr><td>Beschrijving materiaal</td>";
                    echo"<td><textarea rows=\"4\" cols=\"50\" name=\"BEschrijving\">$value2</textarea></td></tr>";
                    $Beschrijving = $value2;
                }
            }
        }
        ?>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Opslaan" name="knopje">
                <?php

                if ($verwijderPossible) {
                    echo '<input type="button" value="Verwijderen" class="button" id="verwijderen">';
                } else {
                    echo '<input type="button" value="Verwijderen" class="button" disabled="disabled" title="Materiaal kan niet worden verwijderd, want er zijn schilderijen aan gekoppeld.">';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Alle velden met een ster zijn verplicht
            </td>
        </tr>
    </table>
</form>
<!-- script voor pup-up verwijderen -->
<script>
    document.getElementById("verwijderen").onclick = function () {
        if (confirm("Weet u zeker dat u dit materiaal wilt verwijderen?")) {
            window.location = "deleteMateriaal.php?id=<?php echo $id; ?>";
        }
    };
</script> <?php

$schilderijen = query("SELECT * FROM schilderij WHERE MateriaalID = ?", [$id]);
toonSchilderijLijst($schilderijen);

renderHtmlEndAdmin();
