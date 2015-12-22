<?php
 // start stuff
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Account", "", "account");

// na de post
if (isset($_POST["oldpassword"])) {
    $wachtwoordHash = hash("sha256", $_POST["oldpassword"]);
    // query voor checken huidige wachtwoord
    $result = query("SELECT * FROM gebruikers WHERE username = ? AND wachtwoord = ?", array($_SESSION["inlog"], $wachtwoordHash));
   
    if (count($result) === 0) { // ww is niet goed
        $errorMessage = "Huidig wachtwoord klopt niet";
    } elseif ($_POST["newpassword"] != $_POST["new2password"]) { // nieuwe ww zijn niet gelijk
        $errorMessage = "Nieuwe wachtwoorden zijn niet gelijk aan elkaar";
    } elseif (strlen($_POST["newpassword"]) < 4) {// te kort
        $errorMessage = "Nieuwe wachtwoord moet minimaal 5 karakters lang zijn";
    } else { // invoer is goed update de db
        $newpassword = hash("sha256", $_POST["newpassword"]);
        query("UPDATE gebruikers SET wachtwoord = ? WHERE username = ?", array($newpassword, $_SESSION["inlog"]));
        $successMessage = "Wachtwoord is aangepast";
    }
}
?>

<div>
    <?php

    if (isset($successMessage)) { // bij success tonen
        echo $successMessage;
    }
    ?>
    <form method="post" action="account.php">
        <table>
            <tr>
                <td>Huidige wachtwoord</td>
                <td><input type="password" name="oldpassword"></td>
            </tr>
            <tr>
                <td>Nieuw wachtwoord</td>
                <td><input type="password" name="newpassword"></td>
            </tr>
            <tr>
                <td>Herhaal wachtwoord</td>
                <td><input type="password" name="new2password"></td>
            </tr>
            <?php

            if (isset($errorMessage)) { // niet goed message
                echo "<tr><td colspan='2' class='incorrect'>" . $errorMessage . "</td></tr>";
            }
            ?>
            <tr>
                <td></td>
                <td><input type="submit" value="Veranderen"></td>
            </tr>
        </table>
    </form>
</div>

<?php

renderHtmlEndAdmin();

