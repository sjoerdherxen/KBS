<?php
include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Schilderij", "");
?>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>

<?php
/*
  $id = $_GET["id"]; // komt uit get of post
 */
$schilderij;
?>
<br>
<br>

<div class="schilderijimg">

    <img src=https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/266px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg
         alt="schilderij" >
    
    <ul>
        <li>Titel:<?php /*query(SELECT TITEL FROM SCHILDERIJ WHERE Schilderij_id="$id", $params)  */  ?></li>
        <li>Jaar:<?php /*query(SELECT JAAR FROM SCHILDERIJ WHERE Schilderij_id="$id", $params)  */  ?></li>
        <li>Dimensies(HxB):<?php /*query(SELECT HOOGTE FROM SCHILDERIJ WHERE Schilderij_id="$id", $params)  */  ?> * <?php /*query(SELECT BREEDTE FROM SCHILDERIJ WHERE Schilderij_id=$id, $params)  */  ?></li>   
        <li>Catagorie:<?php /*query(SELECT CATAGORIE FROM SCHILDERIJ WHERE Schilderij_id="$id", $params)  */  ?></li>
        <li>Materiaal:<?php /*query(SELECT MATERIAAL FROM SCHILDERIJ WHERE Schilderij_id="$id", $params)  */  ?></li>
        
    </ul>
    
    

    <div class="title">Titel<?php /*query(SELECT TITEL FROM SCHILDERIJ WHERE Schilderij_id=$id, $params)  */  ?></div>
</div>

<div class="beschrijving">Beschrijving</div>


<!-- hier komt de rest van de schilderij-->













<?php
//  Alles hieronder is de commentaarsectie. 
//  Moet nog afgemaakt worden
//  Onderandere de error code
//  
/*


  $naamleeg = "";
  $naam = "";
  $commentaar = "";
  $commentaarleeg = "";
  $correct = true;

  if (isset($_POST["naam"]) && isset($_POST["commentaar"]) && checkCaptcha($_POST["g-recaptcha-response"])) {
  $commentaar = trim($_POST["commentaar"]);
  $naam = trim($_POST["naam"]);
  if ($naam == "") {
  $naamleeg = "Naam is verplicht";
  $naamsucces = false;

  }
  if ($commentaar == ""){
  $commentaarleeg = "Dit veld mag niet leeg zijn";
  $commentaarsucces = false;
  }
  if($correct) {
  query("insert into commentaar (naam_klant, email_klant, opmerking, schilderij_id) VALUES (?, ?, ?, ?)", array($_POST["Naam_klant"] , $_POST["Email_klant"], $_POST["opmerking"], $_GET["id"]));
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
  <td><input name="naam" type="text" id="naam" size="40"/>
  <?PHP if (isset($naamleeg)){
  echo $naamleeg;
  }
  ?></td>
  </tr>
  <tr>
  <td>Email</td>
  <td>:</td>
  <td><input name="email" type="text" id="email" size="40" /></td>
  </tr>
  <tr>
  <td >Commentaar</td>
  <td >:</td>
  <td><textarea name="commentaar" cols="40" rows="4" id="commentaar" ></textarea>
  <?PHP  if (isset($commentaarleeg)){
  echo $commentaarleeg;

  } ?>
  </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input type="submit"  name="Submit" value="Submit" />
  <input type="reset" name="Submit2" value="Reset" /></td>
  </tr>

  </table>
  </td><td>

  <?php


  ?>

  <div class="g-recaptcha" data-sitekey="6LdBuRITAAAAABvjWzxipScramaFIs51kveTqRUc"></div></td>

  </tr>
  </table>

  </form>
  <?php
 */
?>


<?php
renderHtmlEnd();
?>