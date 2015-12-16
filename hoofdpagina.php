<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

include './functions.php';
include './htmlHelpers.php';
renderHtmlStart("Home", "");
?>

<div>
    <?php
    $uitvoerDatabase = query("SELECT Beschrijving FROM Welkomstekst WHERE ID = 1", NULL);
    foreach ($uitvoerDatabase as $value1){
        foreach ($value1 as $value2){
            echo "<td>$value2</td></tr>";
        }
    }
    ?>
</div>

<script src="slider.js"></script>
<div class="slider2">
    <div id="slider">
        <a href="#" class="control_next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        <a href="#" class="control_prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <ul>
            <?php

            $schilderijen = query("SELECT schilderij_id, titel, img FROM schilderij ORDER BY schilderij_id DESC LIMIT 0,6", null);

            $i = 0;
            foreach ($schilderijen as $schilderij) {
                if ($i % 3 == 0 && $i != count($schilderijen)) {
                    echo "<li>";
                }
                echo "<a href='/schilderij.php?id=" . $schilderij["schilderij_id"] . "'>";
                echo "<img src='" . $schilderij["img"] . "'>";
                echo "<span class='slider-titel'>" . $schilderij["titel"] . "</span>";
                echo "</a>";
                
                $i++;
                if ($i % 3 == 0) {
                    echo "</li>";
                }
            }
            ?>
        </ul>  
    </div>

    <div class="slider_option">
        <input type="checkbox" id="checkbox">
        <label for="checkbox">Autoplay Slider</label>
    </div> 
</div>

<?php

renderHtmlEnd();
?>

