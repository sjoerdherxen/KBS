<?php

include './htmlHelpers.php';
include './functions.php';
renderHtmlStart("Gallerij", "<script src='/content/gallerij.js'></script>");
?>

<div class="gallerij">
    <?php

    $pageSize = 20;
    $page = 1;
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        $page = $_GET["page"];
    }
    $pageCountResult = query("SELECT COUNT(*) as aantal FROM Schilderij", null);
    $pageCount = ceil($pageCountResult[0]["aantal"] / $pageSize);
    if ($page > $pageCount) {
        $page = $pageCount;
    }

    $schilderijen = query("SELECT * FROM schilderij LIMIT " . ($page * $pageSize - $pageSize) . ", " . $pageSize, null);
//echo "<div class='row'>";
    toonSchilderijLijst($schilderijen, $page, $pageCount, $pageSize, "/gallerij.php?");
    ?>

</div>

<?php

renderHtmlEnd();
?>