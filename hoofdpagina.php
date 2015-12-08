<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include './htmlHelpers.php';
renderHtmlStart("Home", "");
?>


<script src="slider.js"></script>
<div class="slider2">
    <div id="slider">
        <a href="#" class="control_next">>></a>
        <a href="#" class="control_prev"><</a>
        <ul>
            <li>SLIDE 1</li>
            <li style="background: #aaa;">SLIDE 2</li>
            <li>SLIDE 3</li>
            <li style="background: #aaa;">SLIDE 4</li>
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

