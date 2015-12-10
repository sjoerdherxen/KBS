<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Contact", '<script src="/content/editCategorie.js"></script>');

$uitvoerDatabase = query("SELECT * FROM schilder", NULL);

foreach ($uitvoerDatabase as $value1) {
    foreach ($value1 as $key2 => $value2) {
        if ($key2 == "Woonplaats") {
            $woonplaats = $value2;
        } elseif ($key2 == "Gebdat") {
            $gebdat = $value2;
        } elseif ($key2 == "Adres") {
            $adres = $value2;
        } elseif ($key2 == "Email") {
            $email = $value2;
        } elseif ($key2 == "Telefoon") {
            $tel = $value2;
        } elseif ($key2 == "Naam_schilder") {
            $naam = $value2;
        }
    }
}

?>
<form action="editContactgegevens.php" method="post">
    <table>
        <tr>
            <td>
                Naam:
            </td>
            <td>
                <input type="text" name="Naam_schilder" value="<?php echo $naam; ?>">
            </td>
        </tr>
        <tr>
            <td>
                Geboortedatum:
            </td>
            <td>
                <input type="date" name="Gebdat" value="<?php echo $gebdat; ?>">
            </td>
        </tr>
        <tr>
            <td>
                Adres:
            </td>
            <td>
                <input type="text" name="Adres" value="<?php echo $adres; ?>">
            </td>
        </tr>
        <tr>
            <td>
                Woonplaats:
            </td>
            <td>
                <input type="text" name="Woonplaats" value="<?php echo $woonplaats; ?>">
            </td>
        </tr>
        <tr>
            <td>
                Telefoonnummer:
            </td>
            <td>
                <input type="text" name="Telefoon" value="<?php echo $tel; ?>">
            </td>
        </tr>
        <tr>
            <td>
                Email:
            </td>
            <td>
                <input type="email" name="Email" value="<?php echo $email; ?>">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="knopske" value="Opslaan">
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST["knopske"])) {
    if (isset($_POST["Naam_schilder"]) && $_POST["Naam_schilder"] !== "" && isset($_POST["Email"]) && $_POST["Email"] !== ""){
        if (isset($_POST["Telefoon"]) && $_POST["Telefoon"] !== ""){
            $telefoon1 = $_POST["Telefoon"];
        } else {
            $telefoon1 = NULL;
        }
        if (isset($_POST["Woonplaats"]) && $_POST["Woonplaats"] !== ""){
            $woonplaats1 = $_POST["Woonplaats"];
        } else {
            $woonplaats1 = NULL;
        }
        if (isset($_POST["Adres"]) && $_POST["Adres"] !== ""){
            $adres1 = $_POST["Adres"];
        } else {
            $adres1 = NULL;
        }
        if (isset($_POST["Gebdat"]) && $_POST["Gebdat"] !== ""){
            $gebdat1 = $_POST["Gebdat"];
        } else {
            $gebdat1 = NULL;
        }
        $naam1 = $_POST["Naam_schilder"];
        $email1 = $_POST["Email"];
        $invoerDatabase = [$naam1, $email1, $telefoon1, $woonplaats1, $adres1, $gebdat1];
        var_dump($invoerDatabase);
        query("UPDATE Schilder SET Naam_schilder=?, Email=?, Telefoon=?, Woonplaats=?, Adres=?, Gebdat=?", $invoerDatabase);
        ?>
<script>

    alert("Wijzigingen zijn opgeslagen");

</script>
        <?php
        header('location:main.php#Wijzigingen zijn opgeslagen');
        exit();
    } else {
        echo "hoi :D";
    }
}

renderHtmlEndAdmin();
