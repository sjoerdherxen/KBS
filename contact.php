<?php
include './htmlHelpers.php';
include './admin/functions.php';
renderHtmlStart("Contact", "");
?>

<?php
/* error messages */
$contact_voornaam_error = "";
$contact_achternaam_error = "";
$contact_email_error = "";
$contact_onderwerp_error = "";
$contact_bericht_error = "";
$controle = true;
/*  voorafingestelde values forms  */
$mail = "";
$contact_voornaam = "";
$contact_achternaam = "";
$contact_email = "";
$contact_onderwerp = "";
$contact_bericht = "";
?>

<?php
if (isset($_GET["contact-submit"]) && $_GET["contact-submit"] == "verzenden") {
    
    $contact_voornaam = $_GET["contact-voornaam"];
    $contact_achternaam = $_GET["contact-achternaam"];
    $contact_email = $_GET["contact-email"];
    $contact_onderwerp = $_GET["contact-onderwerp"];
    $contact_bericht = $_GET["contact-bericht"];
    
    if (!isset($_GET["contact-voornaam"]) || $_GET["contact-voornaam"] == "") {
        $contact_voornaam_error = "voornaam is niet ingevuld!";
        $controle = false;
    }
    if (!isset($_GET["contact-achternaam"]) || $_GET["contact-achternaam"] == "") {
        $contact_achternaam_error = "achternaam is niet ingevuld!";
        $controle = false;
    }
    if (!isset($_GET["contact-email"]) || $_GET["contact-email"] == "") {
        $contact_email_error = "e-mail adres is niet ingevuld";
        $controle = false;
    }
    if (!isset($_GET["contact-onderwerp"]) || $_GET["contact-onderwerp"] == "") {
        $contact_onderwerp_error = "onderwerp is niet ingevuld!";
        $controle = false;
    }
    if (!isset($_GET["contact-bericht"]) || $_GET["contact-bericht"] == "") {
        $contact_bericht_error = "bericht is niet ingevuld!";
        $controle = false;
    }
    if ($controle == true) {

        $to = query("SELECT email FROM schilder WHERE naam_schilder = 'Thijs Ronda'", NULL);
        $to = $to[0]['email'];
        $subject = $_GET["contact-onderwerp"];
        $message = "naam afzender: " . $_GET["contact-voornaam"] . " " . $_GET["contact-achternaam"] . "\n\n" . $_GET["contact-bericht"];
        $email = $_GET["contact-email"];
        $header = "From:$email \r\n";

        $mail = mail($to, $subject, $message, $header);
    }
}
?>
<div id="contact-form">
    <form method="get" action="contact.php">
        <input type="text" name="contact-voornaam" placeholder="Voornaam" value="<?php print($contact_voornaam) ?>">
        <?php print("$contact_voornaam_error"); ?><br>
        <input type="text" name="contact-achternaam" placeholder="Achternaam" value="<?php print($contact_achternaam) ?>">
        <?php print("$contact_achternaam_error"); ?><br>
        <input type="email" name="contact-email" placeholder="E-mail adres" value="<?php print($contact_email) ?>">
        <?php print("$contact_email_error"); ?><br>
        <input type="text" name="contact-onderwerp" placeholder="onderwerp" value="<?php print($contact_onderwerp) ?>">
        <?php print("$contact_onderwerp_error"); ?><br>
        <textarea rows="4" cols="50" name="contact-bericht" placeholder="voer hier uw bericht in"><?php print($contact_bericht) ?></textarea>
        <?php print("$contact_bericht_error"); ?><br>
        <input type="submit" name="contact-submit" value="verzenden">
    </form>
</div>

<div id="contact-foutmelding">
    <?php
    if (isset($_GET["contact-submit"])) {
        if ($_GET["contact-voornaam"] == "" && $_GET["contact-achternaam"] == "" && $_GET["contact-email"] == "" && $_GET["contact-onderwerp"] == "" && $_GET["contact-bericht"] == "") {
            if ($mail) {
                echo "mail is goed verzonden!";
            } else {
                echo "Er is iets misgegaan!";
            }
        }
    }
    ?>
</div>
<?php
renderHtmlEnd();
?>