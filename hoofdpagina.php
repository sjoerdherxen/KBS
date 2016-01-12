<?php

include './functions.php';
include './htmlHelpers.php';
renderHtmlStart("Home", "");
?>

<div>
    <?php

    // welkoms text (WelkomsTtekst asshole)
    $uitvoerDatabase = query("SELECT Welkomstekst FROM welkomstekst WHERE ID = 1", NULL);
    foreach ($uitvoerDatabase as $value1) {
        foreach ($value1 as $value2) {
            echo "<h4 id='welkomstekst'>$value2</h4>";
        }
    }
    ?>
</div>
<?php // slider   ?>
<script src="slider.js"></script>
<div class="slider2">
    <a href="#" class="control_next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    <a href="#" class="control_prev"><span class="glyphicon glyphicon-chevron-left"></span></a>

    <div id="slider">
        <ul>
            <?php

            $categorieen = query("SELECT CategorieID FROM schilderij WHERE OpWebsite = 1 GROUP BY CategorieID HAVING COUNT(*) >= 3 LIMIT 0,5", null);
            $query = "";
            $union = "";
            $param = [];
            $j = 1;
            foreach ($categorieen as $cat) {
                $query .= $union . "SELECT Schilderij_ID, Titel, Img FROM schilderij WHERE OpWebsite = 1 AND CategorieID = " . $cat["CategorieID"] . " LIMIT 0," . $j * 3;
                $param[] = $cat["CategorieID"];
                $union = " UNION ";

                $j++;
            }

           $schilderijen = query($query, $param);

            $i = 0;
            foreach ($schilderijen as $schilderij) {
                if ($i % 3 == 0 && $i != count($schilderijen)) {
                    echo "<li>";
                }
                echo "<a href='/schilderij.php?id=" . $schilderij["Schilderij_ID"] . "'>";
                echo "<div style='background-image:url(\"/content/uploads/" . $schilderij["Img"] . "\"); '></div>";
                echo "<span class='slider-titel'>" . $schilderij["Titel"] . "</span>";
                echo "</a>";

                $i++;
                if ($i % 3 == 0) {
                    echo "</li>";
                }
            }
            ?>
        </ul>  
    </div>
</div>

<?php

renderHtmlEnd();
?>

