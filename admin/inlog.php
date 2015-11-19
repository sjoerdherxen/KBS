<?php

if (isset($_POST["username"]) && isset($_POST["password"])) {
    // todo: add db check voor username/password
    if (true/* username+password is correct */) {
        $_SESSION["inlog"] = $_POST["username"];
        header("location: main.php");
    }
}
?>
<form method="post" action="#">
    <table id="inlog">
        <tr>
            <td>Naam </td>
            <td><input type="text" name="username"></td>
        </tr>
        <tr>
            <td>Wachtwoord </td>
            <td><input type="text" name="password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="button" value="Inloggen"></td>
        </tr>
    </table>
</form>
