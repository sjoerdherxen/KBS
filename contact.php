<?php
include './htmlHelpers.php';
renderHtmlStart("Contact", "");
?>

<?php
$contact_voornaam_error = "";
$contact_achternaam_error = "";
$contact_email_error = "";
$contact_onderwerp_error = "";
$contact_bericht_error = "";
?>

<?php
if (isset($_GET["contact-submit"]) && $_GET["contact-submit"] == "verzenden") {
    if (!isset($_GET["contact-voornaam"])) {
        $contact_voornaam_error = "voornaam is niet ingevuld!";
    }
    if (!isset($_GET["contact-achternaam"])) {
        $contact_achternaam_error = "achternaam is niet ingevuld!";
    }
    if (!isset($_GET["contact-email"])) {
        $contact_email_error = "e-mail adres is niet ingevuld";
    }
    if (!isset($_GET["contact-onderwerp"])) {
        $contact_onderwerp_error = "onderwerp is niet ingevuld!";
    }
    if (!isset($_GET["contact-bericht"])) {
        $contact_bericht_error = "bericht is niet ingevuld!";
    }
    if (isset($_GET["contact-voornaam"]) && isset($_GET["contact-achternaam"]) && isset($_GET["contact-email"]) && isset($_GET["contact-onderwerp"]) && $_GET["contact-bericht"]) {
        $to = $_GET["contact-email"];
        $subject = $_GET["contact-onderwerp"];
        $message = "naam afzender: " . $_GET["contact-voornaam"] . " " . $_GET["contact-achternaam"] . "\ncontact gegevens: " . $_GET["contact-email"] . "\n\n" . $_GET["contact-bericht"];
        mail($to, $subject, $message);
    }
}
?>
<div id="contact-form">
    <form method="get" action="contact.php">
        <input type="text" name="contact-voornaam" placeholder="Voornaam"><br>
        <?php print("$contact_voornaam_error"); ?>
        <input type="text" name="contact-achternaam" placeholder="Achternaam"><br>
        <?php print("$contact_achternaam_error"); ?>
        <input type="email" name="contact-email" placeholder="E-mail adres"><br>
        <?php print("$contact_email_error"); ?>
        <input type="text" name="contact-onderwerp" placeholder="onderwerp"><br>
        <?php print("$contact_onderwerp_error"); ?>
        <textarea rows="4" cols="50" name="contact-bericht" placeholder="voer hier uw bericht in"></textarea><br>
        <?php print("$contact_bericht_error"); ?>
        <input type="submit" name="contact-submit" value="verzenden">
    </form>
</div>

<?php
renderHtmlEnd();
?>