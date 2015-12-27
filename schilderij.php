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

// eerst schilderij ophalen
$schilderijlijst = query("SELECT S.titel, S.jaar, S.hoogte, S.breedte, S.beschrijving, 
            C.Categorie_naam, SC.Subcategorie_naam, M.Materiaal_soort, S.img, S.prijs, S.lijst, 
            S.passepartout, S.isStaand
 FROM Schilderij S 
  JOIN Categorie C ON C.CategorieID = S.CategorieID 
  LEFT JOIN SubCategorie SC ON SC.SubcategorieID = S.SubcategorieID 
  JOIN Materiaal M ON M.MateriaalID = S.MateriaalID
  
  WHERE S.schilderij_id = ?", $params);

if(count($schilderijlijst) != 1){
    header("location: gallerij.php");
    exit();
}

$schilderij = $schilderijlijst[0];
$naam = "";
$commentaar = "";
$correct = true;

if (isset($_POST["naam"]) && isset($_POST["commentaar"]) && checkCaptcha($_POST["g-recaptcha-response"])) {
    $commentaar = trim($_POST["commentaar"]);
    $naam = trim($_POST["naam"]);
    if ($naam == "") {
        $naamleeg = "Naam is verplicht";
        $correct = false;
    }
    if ($commentaar == "") {
        $commentaarleeg = "Commentaar is verplicht";
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

<div class="schilderijimg">
    <img class="schilderij" alt="schilderij" src="<?php print($schilderij["img"]); ?>">
</div>
<div class="row schilderijinfo">
    <div class="col-md-4">
        <div class="onderschilderij">
            <h3><?php print $schilderij["titel"] ?></h3>
            <div >
                Beschrijving
                <br>
                <div class="beschrijving"><?php print $schilderij["beschrijving"] ?></div>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <ul class="schilderij">
            <li><h3>Extra info</h3></li>
            <?php

            if ($schilderij["prijs"] != "" && $schilderij["prijs"] != null) {
                ?>
                <li>Prijs indicatie: &euro;<?php print $schilderij["prijs"] ?></li>
                <?php

            }

            if ($schilderij["jaar"] != "" && $schilderij["jaar"] != "0000" && $schilderij["jaar"] != null) {
                ?>
                <li>Jaar: <?php print $schilderij["jaar"] ?></li>
                <?php

            }
            ?>
            <li>Groote: <?php print $schilderij["hoogte"] ?> X <?php print $schilderij["breedte"] ?> cm</li>   
            <li>Catagorie: 
                <?php

                print $schilderij["Categorie_naam"];
                if ($schilderij["Subcategorie_naam"] != null) {
                    print(", ");
                    print($schilderij["Subcategorie_naam"]);
                }
                ?>
            </li>
            <li>Materiaal: <?php print $schilderij["Materiaal_soort"] ?></li>
            <li>Lijst: <?php print $schilderij["lijst"] ? "met lijst" : "zonder lijst"; ?> </li>   
            <li>Passepartout: <?php print $schilderij["passepartout"] ? "met passepartout" : "zonder passepartout"; ?> </li> 
            <li>Orientatie: <?php print $schilderij["isStaand"] ? "staand" : "liggend";  ?> </li>   
        </ul>

    </div>
    <div class="col-md-4">
        <div class="bordercomment">
            <div class="comments">
                <div>
                    <h3 class="commentaar">Commentaar</h3>
                </div>
                <?php

                $comments = query("SELECT * FROM commentaar C where schilderij_ID=?", $params);
                foreach ($comments as $comment) {
                    ?>
                    <div class="comment-box">
                        <div class="comment-naam">
                            <?php echo $comment["Naam_klant"]; ?>
                        </div>
                        <div class="comment-beschrijving"><?php echo $comment["Opmerking"]; ?></div>
                    </div>
                    <?php

                }
                ?>
            </div>
        </div>


    </div>
</div>
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



<?php

renderHtmlEnd();
?>