<?php

session_start();
require './functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
// todo get data from db
echo "<div id='schilderijList'>";
foreach ($schilderijen as $schilderij) {
    echo "<a class='schilderijListItem' href='editschilderij.php?id=".$schilderij["id"]."'>";
    echo "<img src='" . $schilderij["imgsrc"] . "'>";
    echo "<div class='schilderijListItemInner'>";
    echo "Naam " . $schilderij["name"] . "<br/>";
    echo "Beschrijving " . $schilderij["description"] . "<br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";
