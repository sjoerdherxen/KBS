<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Schilderijen", "");
$query = "SELECT * FROM schilderij";
$schilderijen = query($query, null);

echo "<a href='addSchilderij.php' id='addSchilderijLink'>Toevoegen</a>";
echo "<div id='schilderijList'>";
foreach ($schilderijen as $schilderij) {
    echo "<a class='schilderijListItem' href='editschilderij.php?id=" . $schilderij["Schilderij_ID"] . "'>";
    echo "<div class='schilderijListItemImg' style='background-image: url(\"" . $schilderij["Img"] . "\");'></div>";
    echo "<div class='schilderijListItemInner'>";
    echo "<span class='titel'>" . $schilderij["Titel"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $schilderij["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();
