<?php

include './htmlHelpers.php';
include './admin/functions.php';
renderHtmlStart("Gallerij", "");
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
    $i = 0;
    foreach ($schilderijen as $schilderij) {
        if ($i % 4 == 0 && $i != $pageSize) {
            echo "<div class='row'>";
        }
        $i++;
        ?>
        <a href="/afbeelding.php?id=<?php echo $schilderij["Schilderij_ID"] ?>" class="col-md-3"> 
            <div class="img">
                <img src="<?php echo $schilderij["Img"]; ?> " alt="Logo" >

                <div class="title">
                    <?php echo $schilderij["Titel"] . " > " . ($i % 4); ?>
                </div>
            </div> 
        </a>
        <?php

        if ($i % 4 == 0 && $i != 0) {
            echo "</div>";
        }
    }
    if ($i % 4 != 0) {
        echo "</div>";
    }
    ?>

    <div style="clear: both;"></div>
    <div id="pages-wrapper">
        <div id="pages" class="btn-group">
            <?php

            $prevPageHref = $page == 1 ? "" : 'href="gallerij.php?page=' . ($page - 1) . '"';
            echo '<a class="btn btn-default" ' . $prevPageHref . '><span class="glyphicon glyphicon-chevron-left"><</span></a>';

            for ($i = 1; $i <= $pageCount; $i++) {
                if ($i == $page) {
                    echo "<span class='active btn btn-default btn-active'>" . $i . "</span>";
                } else {
                    echo "<a class='btn btn-default' href='/gallerij.php?page=" . $i . "'>" . $i . "</a>";
                }
            }

            $nextPageHref = $page == $pageCount ? "" : 'href="gallerij.php?page=' . ($page + 1) . '"';
            echo '<a class="btn btn-default" ' . $nextPageHref . '><span class="glyphicon glyphicon-chevron-right">></span></a>';
            ?>
        </div>
    </div>

</div>

<?php

renderHtmlEnd();
?>