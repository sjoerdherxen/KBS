<?php
include './functions.php';
include './htmlHelpers.php';
renderHtmlStart("Home", "");
?>

<div>
    <?php
    // welkoms text (WelkomsTtekst asshole)
    $uitvoerDatabase = query("SELECT Welkomstekst FROM welkomstekst WHERE ID = 1", NULL);
    foreach ($uitvoerDatabase as $value1){
        foreach ($value1 as $value2){
            echo "<h4 id='welkomstekst'>$value2</h4>";
        }
    }
    ?>
</div>
<?php // slider  ?>
<script src="slider.js"></script>
<div class="slider2">
    <div id="slider">
        <a href="#" class="control_next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        <a href="#" class="control_prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <ul>
            <?php
            
            $schilderijen = query("SELECT Schilderij_ID, Titel, Img FROM schilderij ORDER BY Schilderij_ID DESC LIMIT 0,15", null);

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
<?php /*
    <div class="slider_option">
        <input type="checkbox" id="checkbox">
        <label for="checkbox">Autoplay Slider</label>
    </div> */?>
</div>

<?php

renderHtmlEnd();
?>

