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

/* TE DOEN
 * 
 * TOEVOEGEN CONFIRMATIE WANNEER EEN COMMENTAAR IS TOEGEVOEGD DOOR MIDDEL VAN POP UP IN HETZELFDE TABBLAD
 * OPMAAK COMMENTAAR BOX
 * PRINT COMMENTAAR UIT DATABASE VAN DAT SPECIFIEKE SCHILDERIJ 
 *   */

$schilderijlijst = query("SELECT S.titel, S.jaar, S.hoogte, S.breedte, S.beschrijving, C.Categorie_naam, SC.Subcategorie_naam, M.Materiaal_soort, S.img
 FROM Schilderij S 
  JOIN Categorie C ON C.CategorieID = S.CategorieID 
  LEFT JOIN SubCategorie SC ON SC.SubcategorieID = S.SubcategorieID 
  JOIN Materiaal M ON M.MateriaalID = S.MateriaalID
  
  WHERE S.schilderij_id = ?", $params);

$schilderij = $schilderijlijst[0];
?>
<br>
<br>

<div class="schilderijimg">

    <img class="schilderij" alt="schilderij" src="<?php print($schilderij["img"]); ?>">

    <ul class="schilderij">
        <li>Titel: <?php print $schilderij["titel"] ?></li>
        <li>Jaar: <?php print $schilderij["jaar"] ?></li>
        <li>Dimensies: <?php print $schilderij["hoogte"] ?> * <?php print $schilderij["breedte"] ?></li>   
        <li>Catagorie: <?php print $schilderij["Categorie_naam"] ?>


            <?php
            $result = $schilderij;
            if (count($schilderij) == 1) {
                print(", ");
                print($schilderij[0]["Subcategorie_naam"]);
            }
            ?></li>
        <li>Materialen: <?php print $schilderij["Materiaal_soort"] ?></li>

    </ul>



    <?php
    $comments = query("SELECT * FROM commentaar C join schilderij S on Cm.Schilderij_ID = S.Schilderij_ID 
             where schilderij_ID=?", $params);
    $opmerkingen = $comments;
    ?>
</div>
<br>
<br>
<div class="onderschilderij">
    <div class="title"><?php print $schilderij["titel"] ?></div>
    <div >
        Beschrijving
        <br>
        <div class="beschrijving"><?php print $schilderij["beschrijving"] ?></div>

    </div>
</div>

<div class="bordercomment">
    <div class="comments">
        <div>
            <h3 class="commentaar">Commentaar</h3>
        </div>

        <?php/* print $opmerkingen["Naam_klant"] */?>
         <?php  /*print $opmerkingen["Opmerking"] */?> 





    </div>


    <?php
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
            $correct = false;
        }
        if ($commentaar == "") {
            $commentaarleeg = "Dit veld mag niet leeg zijn";
            $commentaarsucces = false;
            $correct = false;
        }
        if ($correct) {
            $input = array($_POST["naam"], $_POST["email"], $_POST["commentaar"], $_GET["id"]);
            query("insert into commentaar (naam_klant, email_klant, opmerking, schilderij_id) VALUES (?, ?, ?, ?)", $input);
            ?>
            <script>
                alert("Commentaar is toegevoegd");
            </script>
            <?php
        }
    }
    ?>

    <div class="capthapositie">
        <form id="form1" name="form1" method="post" action="schilderij.php?id=<?php echo $_GET["id"]; ?>">
            <input type="hidden"  name="id" value="<?php echo $id; ?>" />
            <table class="comment1">


                <tr>
                    <td class="commentaar">Naam</td>
                    <td>:</td>
                    <td><input name="naam" type="text" id="naam" size="40"/>
                        <?PHP
                        if (isset($naamleeg)) {
                            echo $naamleeg;
                        }
                        ?></td>
                </tr>
                <tr>
                    <td class="commentaar">Email</td>
                    <td>:</td>
                    <td><input name="email" type="email" id="email" size="40" /></td>
                </tr>
                <tr>
                    <td class="commentaar">Commentaar</td>
                    <td >:</td>
                    <td><textarea name="commentaar" cols="42" rows="4" id="opmerking" ></textarea>
                        <?PHP
                        if (isset($commentaarleeg)) {
                            echo $commentaarleeg;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>

                    <td>

                        <div class="capthapositie1">

                            <div class="g-recaptcha" data-sitekey="6LdBuRITAAAAABvjWzxipScramaFIs51kveTqRUc"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="submit"  name="Submit" value="Submit">

                </tr>

            </table>



        </form>
    </div>
</div>


<?php
renderHtmlEnd();
?>