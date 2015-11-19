<?php
session_start();
require './functions.php';
if(!isLoggedIn()){
    header("location: index.php");
}
// todo get data from db
echo "<div id='schilderijList'>";
foreach ($schilderijen as $schilderij) {
    echo "<div class='schilderijListItem'>";
    echo "<img src='".$schilderij["imgsrc"]."'>";
    
    echo "</div>";
}
echo "</div>";
