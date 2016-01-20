<?php

// start stuff
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Subcategorie&euml;n", '', "subcategorie");

$saved = false;

$toevoegenSubcategorie = [];
$doorgaan_naam = false;
$invoerDatabase = [];
$postnaam = "";
$postbeschrijving = "";
$postcat = "";

// post is gedaan
if (isset($_POST["Toevoegen"]) || isset($_POST["Terug"])) {
    if (!isset($_POST["Naam"]) || $_POST["Naam"] == "" || !is_numeric($_POST["categorie"])) { // check naam is leeg
        $Naamerror = "Er moet een naam worden ingevuld.";
    } else {
        // check naam al bestaad
        $invoerDatabase[] = uppercase($_POST["Naam"]);
        $uitvoerDatabase = query("SELECT Subcategorie_naam FROM subcategorie WHERE Subcategorie_naam = ?", $invoerDatabase);
        if (count($uitvoerDatabase) === 0) {
            // subcat bestaat nog niet dus invoeren
            $toevoegenSubcategorie[] = uppercase($_POST["Naam"]);
            $toevoegenSubcategorie[] = uppercase($_POST["Beschrijving"]);
            $toevoegenSubcategorie[] = $_POST["categorie"];
            query("INSERT INTO subcategorie (Subcategorie_naam, Beschrijving, CategorieID) VALUES (?, ?, ?)", $toevoegenSubcategorie);
            $saved = true;
        } else {
            // bestaat al
            $errorMessage = "Toevoegen subcategorie is mislukt, subcategorie bestaat al.";
        }
    }

    $postnaam = $_POST["Naam"];
    $postbeschrijving = $_POST["Beschrijving"];
    $postcat = $_POST["categorie"];
}

// terug naar overzicht
if ($saved && isset($_POST["Terug"])) {
    header("location:subcategorieList.php?x=1");
    exit();
// op pagina blijven
} elseif ($saved && isset($_POST["Toevoegen"])) {
    header("location:addSubcategorie.php?x=1");
    exit();
}
?>

<!-- this form is used to retrieve the user data-->
<form action="addSubcategorie.php" method="post">
    <h1>Vul hier de subcategorienaam en beschrijving in:</h1>
    <?php

    // code die checked of de categorie daadwerkelijk is toegevoegd (wordt gestart als "toevoegen en blijven" wordt geklikt
    if (isset($_GET["x"])) {
        if ($_GET["x"] === "1") {
            $succes = "Subcategorie is toegevoegd.";
        }
    }
    if (isset($errorMessage)) {
        echo "<p class='incorrect'>$errorMessage</p>";
    }
    ?>
    <table>
        <tr>
            <td>
                Naam subcategorie*
            </td>
            <td>
                <input type="text" name="Naam" placeholder="Vul hier de naam in" style="width: 375px" value="<?php echo $postnaam ?>">
                <?php

                // toont het eerder geïnitialiseerde succesbericht
                if (isset($succes)) {
                    echo '<br>' . $succes;
                }
                // deze error komt te voorschijn als er geen naam is ingevuld
                if (isset($Naamerror)) {
                    echo '<br>' . "<span class=\"incorrect\">$Naamerror</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Valt onder categorie*
            </td>
            <td>
                <select name='categorie' style='width: 375px;'>
                    <?php

                    $categorieen = query("SELECT * FROM categorie", null);
                    foreach ($categorieen as $cat) {
                        if ($cat["CategorieID"] == $postcat) {
                            echo "<option value='" . $cat["CategorieID"] . "' selected>" . $cat["Categorie_naam"] . "</option>";
                        } else {
                            echo "<option value='" . $cat["CategorieID"] . "' >" . $cat["Categorie_naam"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Beschrijving subcategorie
            </td>
            <td>
                <textarea rows="4" cols="50" name="Beschrijving" placeholder="Vul hier de beschrijving in"><?php echo $postbeschrijving ?></textarea>
                <?php ?>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type="submit" name="Terug" value="Toevoegen en naar overzicht">
                <input type="submit" name="Toevoegen" value="Toevoegen en blijven">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href="schilderijList.php"><button type="button"><span style="color: #333333">Terug naar lijst</span></button></a>
            </td>
        </tr>
        <tr>
            <td>
                Alle velden met een ster zijn verplicht
            </td>
        </tr>
    </table>
</form>     
<?php

renderHtmlEndAdmin();
