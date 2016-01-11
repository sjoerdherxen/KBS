<?php

include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Gallerij", "<script src='/content/gallerij.js'></script>");
?>

<div class="gallerij">
    <div id="gallerijcategorie">
        <?php

        $selectedcat = 0;
        if (isset($_GET['categorie'])) {
            $selectedcat = $_GET['categorie'];
            echo '<a href="gallerij.php">Alles</a> | ';
        } else {
            echo '<span class="selected">Alles</span> | ';
        }


        $categorieen = query("SELECT * FROM categorie", null);

        $i = 1;
        foreach ($categorieen as $cat) {
            if ($selectedcat == $cat["CategorieID"]) {
                echo '<span class="selected">' . $cat["Categorie_naam"] . '</a>';
            } else {
                echo '<a href="gallerij.php?categorie=' . $cat["CategorieID"] . '">' . $cat["Categorie_naam"] . '</a>';
            }
            if ($i < count($categorieen)) {
                echo " | ";
            }
            $i++;
        }
        ?>
    </div>


    <?php

// zet pagina waardes voor gallerij
    $pageSize = 20;
    $page = 1;
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        $page = $_GET["page"];
    }
    $where = " WHERE OpWebsite = 1";
    $params = [];
    if ($selectedcat != 0) {
        $where = " WHERE OpWebsite = 1 AND CategorieID = ? ";
        $params[] = $selectedcat;
    }
    // haal aantal pagina's op
    $pageCountResult = query("SELECT COUNT(*) as aantal FROM schilderij" . $where, $params);
    $pageCount = ceil($pageCountResult[0]["aantal"] / $pageSize);
    if ($page > $pageCount) {
        $page = $pageCount;
    }
    // haal schilderijen op
    $schilderijen = query("SELECT * FROM schilderij " . $where . " LIMIT " . ($page * $pageSize - $pageSize) . ", " . $pageSize, $params);

    // toon alle schilderijen
    toonSchilderijLijst($schilderijen, $page, $pageCount, $pageSize, "/gallerij.php?");
    ?>

</div>

<?php

renderHtmlEnd();
?>