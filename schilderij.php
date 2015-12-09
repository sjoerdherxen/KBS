<?php
include './htmlHelpers.php';
include './admin/functions.php';
renderHtmlStart("commentaar", "");
?>


<?php
$id = 1; // komt uit get of post

$schilderij;
?>

<div class="img">

    <img src="$schilderij" alt="Logo" >

    <div class="title">Title</div>
</div>


<?php
$naamleeg = "";
$naam = "";
$commentaar = "";
$commentaarleeg = "";
$correct = true;

if (isset($_POST["naam"]) && isset($_POST["commentaar"])) {
    $commentaar = trim($_POST["commentaar"]);
    $naam = trim($_POST["naam"]);
    if ($naam == "") {
        $naamleeg = "Naam is verplicht";
        $naamsucces = false;
        
    }
    if ($comment == ""){
        $commentaarleeg = "Dit veld mag niet leeg zijn";
        $commentaarsucces = false;
    }
    if($correct) {
        insert("insert into commentaar (?, ?, ?, ? , array(Naam_klant, Email_klant, opmerking, $_GET["id"])
    }
}
?>


<form id="form1" name="form1" method="post" action="schilderij.php">
    <input type="hidden"  name="id" value="<?php echo $id; ?>" />
    <table class="comment1">
        <tr>
            <td>
                <table class="comment2">
                    <tr>
                        <td>Naam</td>
                        <td>:</td>
                        <td><input name="naam" type="text" id="naam" size="40" /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><input name="email" type="text" id="email" size="40" /></td>
                    </tr>
                    <tr>
                        <td >Commentaar</td>
                        <td >:</td>
                        <td><textarea name="commentaar" cols="40" rows="4" id="commentaar"></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit"  name="Submit" value="Submit" /> 
                            <input type="reset" name="Submit2" value="Reset" /></td>
                    </tr>

                </table>
            </td><td>
                <div class="g-recaptcha" data-sitekey="6LdBuRITAAAAABvjWzxipScramaFIs51kveTqRUc"></div></td>
        </tr>
    </table>

</form>

<?php
renderHtmlEnd();
?>