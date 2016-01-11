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



// eerst schilderij ophalen
$schilderijlijst = query("SELECT S.titel, S.jaar, S.hoogte, S.breedte, S.beschrijving, 
            C.Categorie_naam, SC.Subcategorie_naam, M.Materiaal_soort, S.img, S.prijs, S.lijst, 
            S.passepartout, S.isStaand
 FROM schilderij S 
  JOIN categorie C ON C.CategorieID = S.CategorieID 
  LEFT JOIN subcategorie SC ON SC.SubcategorieID = S.SubcategorieID 
  JOIN materiaal M ON M.MateriaalID = S.MateriaalID
  
  WHERE S.Schilderij_ID = ? AND S.OpWebsite = 1", $params);

if (count($schilderijlijst) != 1) {
    header("location: gallerij.php");
    exit();
}

$schilderij = $schilderijlijst[0];
$naam = "";
$commentaar = "";
$correct = true;


if (isset($_POST["naam"]) && isset($_POST["commentaar"]) && checkCaptcha($_POST["g-recaptcha-response"])) {
    $commentaar = uppercase($_POST["commentaar"]);
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
        $naamklant = str_replace("<", "&lt;", $_POST["naam"]);
        $naamklant = str_replace(">", "&gt;", $naamklant);
        $email = str_replace("<", "&lt;", $_POST["email"]);
        $email = str_replace(">", "&gt;", $email);
        $commentaar = str_replace("<", "&lt;", $_POST["commentaar"]);
        $commentaar = str_replace(">", "&gt;", $commentaar);
        $input = array($naamklant, $email, $commentaar, $_GET["id"]);
        query("insert into commentaar (Naam_klant, Email_klant, Opmerking, Schilderij_ID) VALUES (?, ?, ?, ?)", $input);
        //mailen van het commentaar
        $to = query("SELECT email FROM schilder limit 0,1", NULL);
        $to = $to[0]['email'];
        $subject = query("SELECT Titel FROM schilderij WHERE id=?", $_GET["id"]);
        $subject = "Commentaar op schilderij". $subject[0]['Titel'];
        $message = query("SELECT Titel FROM schilderij WHERE id=?", $_GET["id"]);
        $message = "Naam afzender: " . $naamklant . "\nEmail-adres afzenden: " . $email . "\nCommentaar op " . $message[0]['Titel'] . ": " . $commentaar;
        $header = "From:commentaar@hofvanellen.nl \r\n";
        mail($to, $subject, $message, $header);
        ?>
        <script>
            alert("Commentaar is toegevoegd");
        </script>
        <?php
    }
}
?>

<div class="schilderijimg">
    <img class="schilderij" alt="schilderij" src="/content/uploads/<?php print($schilderij["img"]); ?>">
</div>
<div class="row schilderijinfo">
    <div class="col-md-4">
        <div class="onderschilderij">
            <h3><?php print $schilderij["titel"] ?></h3>
            <div >

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
            <li>Grootte: <?php print $schilderij["hoogte"] ?> X <?php print $schilderij["breedte"] ?> cm</li>   
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
            <li>Orientatie: <?php print $schilderij["isStaand"] ? "staand" : "liggend"; ?> </li>   
        </ul>

    </div>
    <div class="col-md-4">
        <div class="bordercomment">
            <div class="comments">
                <div>
                    <h3 class="commentaar">Commentaar</h3>
                </div>
                <?php
                $comments = query("SELECT * FROM commentaar C where Schilderij_ID=?", $params);
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