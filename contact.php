
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

        $to = query("SELECT email FROM schilder limit 0,1", NULL);
        $to = $to[0]['email'];
        $subject = $_POST["contact-onderwerp"];
        $message = "naam afzender: " . $_POST["contact-voornaam"] . " " . $_POST["contact-achternaam"] . "\nemail afzender: " . $_POST['contact-email'] . "\n\n" . $_POST["contact-bericht"];
        $header = "From:contact@hofvanellen.nl \r\n";
        $verzondenmail = mail($to, $subject, $message, $header);
    }
}
?>
<div id="contact-page-content">
    <h4>Voor vragen of opmerkingen, <br>kunt u hier uw gegevens invullen en deze versturen naar Ellen van 't Hof.</h4>
</div>
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
    //dit is een stukje oefencode
    /*    if ($controle == false) {
      $testtext = "hallo dit is een stukje tekst";
      $testtext = uppercase($testtext);
      print_r($testtext);
      } */
    //einde stukje oefencode
    ?></div>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>

<div id="contact-form">
    <form method="post" action="contact.php">
        <div class="round_edge"><input type="text" name="contact-voornaam" placeholder="Voornaam" value="<?php print($contact_voornaam) ?>"></div>
        <?php print("$contact_voornaam_error"); ?>
        <div class="space-form"></div>

        <div class="round_edge"><input type="text" name="contact-achternaam" placeholder="Achternaam" value="<?php print($contact_achternaam) ?>"></div>
        <?php print("$contact_achternaam_error"); ?>
        <div class="space-form"></div>

        <div class="round_edge"><input type="email" name="contact-email" placeholder="E-mail adres" value="<?php print($contact_email) ?>"></div>
        <?php print("$contact_email_error"); ?>
        <div class="space-form"></div>

        <div class="round_edge"><input type="text" name="contact-onderwerp" placeholder="Onderwerp" value="<?php print($contact_onderwerp) ?>"></div>
        <?php print("$contact_onderwerp_error"); ?>
        <div class="space-form"></div>

        <div class="round_edge"><textarea rows="4" cols="50" name="contact-bericht" placeholder="Voer hier uw bericht in"><?php print($contact_bericht) ?></textarea></div>
        <?php print("$contact_bericht_error"); ?>

        <div class="capthapositie1">
            <div class="g-recaptcha" data-sitekey="6LdBuRITAAAAABvjWzxipScramaFIs51kveTqRUc"></div>
        </div>
        <input type="submit" name="contact-submit" value="verzenden">
    </form>
</div>

<div id="contact-foutmelding">
    <?php
    /* if (isset($_POST["contact-submit"])) {
      if ($_POST["contact-voornaam"] == "" && $_POST["contact-achternaam"] == "" && $_POST["contact-email"] == "" && $_POST["contact-onderwerp"] == "" && $_POST["contact-bericht"] == "") {
      if ($verzondenmail == true) {
      $contact_voornaam = '';
      $contact_achternaam = '';
      $contact_email = '';
      $contact_onderwerp = '';
      $contact_bericht = '';
      echo "mail is goed verzonden!";
      } else {
      echo "Er is iets misgegaan!";
      }
      }
      } */
    ?>
</div>
<?php
renderHtmlEnd();
?>
