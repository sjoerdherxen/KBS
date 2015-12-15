<?php
include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Schilderij", "");
?>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>

<?php
$params = array($_GET["id"]);
//ALLES WAT TUSSEN COMMENTS STAAT MOET GECONTROLLEERD WORDEN OF HET WEG KAN
// query(SELECT * FROM SCHILDERIJ s JOIN CATEGORIE c ON S.CategorieID=C.CategorieID WHERE Schilderijid=?, $params);
// query(SELECT * FROM SCHILDERIJ s JOIN Subcategorie sc ON  S.CategorieID=SC.SubcategorieID WHERE Schilderijid=?, $params)
//fetch
/*
$schilderijlijst = query("SELECT * FROM SCHILDERIJ WHERE Schilderijid=?", $params) ;
$schilderij = $schilderijlijst[0];
 * */
$schilderijlijst = query("SELECT * FROM SCHILDERIJ s JOIN CATEGORIE c ON S.CategorieID=C.CategorieID WHERE Schilderijid=?", $params);
$schilderij = $schilderijlijst[0];
$schilderijlijstsub = query("SELECT * FROM SCHILDERIJ s JOIN Subcategorie sc ON  S.SubCategorieID=SC.SubcategorieID WHERE Schilderijid=?", $params);
$subcat = $schilderijlijstsub[0];
$schilderijlijstmat = query("SELECT * FROM SCHILDERIJ s JOIN MATERIAAL M ON S.MateriaalID=M.MateriaalID WHERE Schilderijid=?", $params);
$mater = $schilderijlijstmat[0];

?>
<br>
<br>

<div class="schilderijimg">

    <img src=https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/266px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg <?php /* Vragen hoe hier een plaatje in te printen*//* query(SELECT IMG FROM SCHILDERIJ WHERE Schilderij_id="$id", $params)  */ ?>
         alt="schilderij" >

    <ul class="schilderij">
        <li>Titel:<?php print $schilderij["titel"]/* query(SELECT TITEL FROM SCHILDERIJ WHERE Schilderijid=?, $params)  */ ?></li>
        <li>Jaar:<?php print $schilderij["jaar"]/* query(SELECT JAAR FROM SCHILDERIJ WHERE Schilderijid=?, $params)  */ ?></li>
        <li>Dimensies(HxB):<?php print $schilderij["hoogte"]/* query(SELECT HOOGTE FROM SCHILDERIJ WHERE Schilderijod=?, $params)  */ ?> * <?php print $schilderij["breedte"]/* query(SELECT BREEDTE FROM SCHILDERIJ WHERE Schilderijid=?, $params)  */ ?></li>   
        <li>Catagorie:<?php print $schilderij["Categorie_naam"]/* query(SELECT CATEGORIE_NAAM FROM CATEGORIE WHERE CATEGORIEID =(SELECT CATEGORIEID FROM SCHILDERIJ WHERE SCHILDERIJID = ?), $params)  */ ?>


            <?php
            $result = $subcat["SUBCATEGORIE_NAAM"];
            if (count($result) == 1) {
                print(", ");
                print($result[0]["SUBCATEGORIE_NAAM"]);
            }
            ?></li>
        <li>Materiaal:<?php print $schilderijlijstmat["Materiaal_soort"] /* query(SELECT MATERIAAL_SOORT FROM SCHILDERIJ WHERE Schilderijid=?, $params)  */ ?></li>

    </ul>




</div>
<br>
<br>
<div class="onderschilderij">
    <div class="title">Titel<?php print $schilderij["titel"]/* query(SELECT TITEL FROM SCHILDERIJ WHERE Schilderijid=?, $params)  */ ?></div>
    <div class="beschrijving">
        <a>Beschrijving</a>
        <a><?php print $schilderij["beschrijving"]/* query(SELECT TITEL FROM SCHILDERIJ WHERE Schilderijid=?,  $params)  */ ?></a>

    </div>
</div>















<?php
//  Alles hieronder is de commentaarsectie. 
//  Moet nog afgemaakt worden
//  Onderandere de error code
  
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