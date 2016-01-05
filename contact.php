<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>
<?php
include './htmlHelpers.php';
//include './admin/functions.php';
include './functions.php';
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
if (isset($_POST["contact-submit"]) && $_POST["contact-submit"] == "verzenden") {

    $contact_voornaam = $_POST["contact-voornaam"];
    $contact_achternaam = $_POST["contact-achternaam"];
    $contact_email = $_POST["contact-email"];
    $contact_onderwerp = $_POST["contact-onderwerp"];
    $contact_bericht = $_POST["contact-bericht"];

    if (!isset($_POST["contact-voornaam"]) || $_POST["contact-voornaam"] == "") {
        $contact_voornaam_error = "voornaam is niet ingevuld!";
        $controle = false;
    }
    if (!isset($_POST["contact-achternaam"]) || $_POST["contact-achternaam"] == "") {
        $contact_achternaam_error = "achternaam is niet ingevuld!";
        $controle = false;
    }
    if (!isset($_POST["contact-email"]) || $_POST["contact-email"] == "") {
        $contact_email_error = "e-mail adres is niet ingevuld";
        $controle = false;
    }
    if (!isset($_POST["contact-onderwerp"]) || $_POST["contact-onderwerp"] == "") {
        $contact_onderwerp_error = "onderwerp is niet ingevuld!";
        $controle = false;
    }
    if (!isset($_POST["contact-bericht"]) || $_POST["contact-bericht"] == "") {
        $contact_bericht_error = "bericht is niet ingevuld!";
        $controle = false;
    }
    if ($controle == true && checkCaptcha($_POST["g-recaptcha-response"])) {

        $to = query("SELECT email FROM schilder WHERE naam_schilder = 'Thijs Ronda'", NULL);
        $to = $to[0]['email'];
        $subject = $_POST["contact-onderwerp"];
        $message = "naam afzender: " . $_POST["contact-voornaam"] . " " . $_POST["contact-achternaam"] . "\n\n" . $_POST["contact-bericht"];
        $email = $_POST["contact-email"];
        $header = "From:$email \r\n";
        $verzondenmail = mail($to, $subject, $message, $header);
    }
}
?>
<div id="contact-foutmelding"> <?php
    if ($controle == true && isset($_POST["contact-submit"])) {
        if ($verzondenmail) {
            $contact_voornaam = '';
            $contact_achternaam = '';
            $contact_email = '';
            $contact_onderwerp = '';
            $contact_bericht = '';
            echo 'De mail is goed verzonden!';
        } else {
            echo 'De mail is niet goed verzonden,<br>probeer het later opnieuw';
        }
    }
    ?></div>
<div id="contact-form">
    <form method="post" action="contact.php">
        <input style="border-radius: 10px" type="text" name="contact-voornaam" placeholder="Voornaam" value="<?php print($contact_voornaam) ?>">
        <?php print("$contact_voornaam_error"); ?>
        <div class="space-form"></div>
        
        <input style="border-radius: 10px" type="text" name="contact-achternaam" placeholder="Achternaam" value="<?php print($contact_achternaam) ?>">
        <?php print("$contact_achternaam_error"); ?>
        <div class="space-form"></div>
        
        <input style="border-radius: 10px" type="email" name="contact-email" placeholder="E-mail adres" value="<?php print($contact_email) ?>">
        <?php print("$contact_email_error"); ?>
        <div class="space-form"></div>
        
        <input style="border-radius: 10px" type="text" name="contact-onderwerp" placeholder="onderwerp" value="<?php print($contact_onderwerp) ?>">
        <?php print("$contact_onderwerp_error"); ?>
        <div class="space-form"></div>
        
        <textarea style="border-radius: 10px" rows="4" cols="50" name="contact-bericht" placeholder="voer hier uw bericht in"><?php print($contact_bericht) ?></textarea>
        <?php print("$contact_bericht_error"); ?>
        
        <div class="capthapositie1">
            <div class="g-recaptcha" data-sitekey="6LdBuRITAAAAABvjWzxipScramaFIs51kveTqRUc"></div>
        </div>
        <div class="space-form"></div>
        <input type="submit" name="contact-submit" value="verzenden">
    </form>
</div>

<div id="contact-foutmelding">
</div>
<?php
renderHtmlEnd();
?>