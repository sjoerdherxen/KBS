<?php

$usernameError = "";
$passwordError = "";
$password = "";
$username = "";

$correct = true;
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $password = trim($_POST["password"]);
    $username = trim($_POST["username"]);
    if ($username == "") {
        $usernameError = "Naam is verplicht";
        $correct = false;
    }
    if ($password == "") {
        $passwordError = "Wachtwoord is verplicht";
        $correct = false;
    }
    if ($correct) {
        $query = "SELECT id FROM users WHERE username = @username AND password = @password";
        $result = query($query, array("username" => $username, "password" => $password));

        if (count($result) == 1) {
            $_SESSION["inlog"] = $_POST["username"];
            header("location: main.php");
        } else {
            $passwordError = "De combinatie naam en wachtwoord is niet goed.";
        }
    }
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
                ?>
                <tr>
                    <td></td>
                    <td><input type="submit" name="button" value="Inloggen"></td>
                </tr>
            </table>
        </form>
    </div>
</div>