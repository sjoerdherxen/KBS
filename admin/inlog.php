<?php

// niet via hier openen ga naar /admin/index.php

$usernameError = "";
$passwordError = "";
$password = "";
$username = "";
$correct = true;
if ($_SESSION["attempts"] == null) {
    $_SESSION["attempts"] = 0;
}
// check post
if (isset($_POST["username"]) && isset($_POST["password"])) {

    $_SESSION["attempts"] ++;

    if ($_SESSION["attempts"] < 3 || checkCaptcha($_POST["g-recaptcha-response"])) {
        $password = trim($_POST["password"]);
        $username = trim($_POST["username"]);
        if ($username == "") { // check naam input
            $usernameError = "Naam is verplicht";
            $correct = false;
        }
        if ($password == "") { // check ww input
            $passwordError = "Wachtwoord is verplicht";
            $correct = false;
        }
        if ($correct) {
            // check combi naam+ww
            $password = hash("sha256", $password);
            $query = "SELECT Username FROM gebruikers WHERE Username = ? AND Wachtwoord = ?";
            $result = query($query, array($username, $password));

            if (count($result) == 1) { // correct
                $_SESSION["inlog"] = $_POST["username"];
                $_SESSION["attempts"] = null;
                header("location: main.php");
                exit();
            } elseif ($result === null) { // database fout
                $passwordError = "Er kan geen verbinding worden gemaakt met de database, probeer het later opnieuw";
            } else {
                $passwordError = "De combinatie naam en wachtwoord is niet goed.";
            }
        }
    } else {
        $passwordError = "Captcha is niet goed gekeurd";
    }
}

if ($_SESSION["attempts"] >= 3) {
    ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
    <?php

}
?>


<div id="inlog-background">
    <div id="inlog">
        <form method="post" action="#">
            <table id="inlog-inner">
                <colgroup>
                    <col style="width: 100px">
                    <col style="width: 200px">
                </colgroup>
                <tr>
                    <td>Naam </td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                </tr>
                <?php

                if ($usernameError != "") {
                    echo "<tr><td></td><td class='incorrect'>" . $usernameError . "</td></tr>";
                }
                ?>
                <tr>
                    <td>Wachtwoord </td>
                    <td><input type="password" name="password"></td>
                </tr>
                <?php

                if ($passwordError != "") {
                    echo "<tr><td></td><td class='incorrect'>" . $passwordError . "</td></tr>";
                }
                if ($_SESSION["attempts"] >= 3) {
                    ?>
                    <tr>
                        <td colspan="2">
                            <div class="g-recaptcha" data-sitekey="6LdBuRITAAAAABvjWzxipScramaFIs51kveTqRUc"></div>
                        </td>
                    </tr>
                    <?php

                }
                ?>
                <tr>
                    <td></td>
                    <td><input type="submit" name="button" value="Inloggen">
                        <a href="/hoofdpagina.php"><button type="button"><span style="color: rgb(51, 51, 51);">Terug naar website</span></button></a>
                </tr>
            </table>
        </form>
    </div>
</div>