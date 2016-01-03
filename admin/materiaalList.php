<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Materiaal", "", "materiaal");

// materialen ophalen
$query = "SELECT * FROM Materiaal";
$materiaalen = query($query, null);

$succes = "";

if(isset($_GET["x"])){
    if($_GET["x"] === "1"){
        $succes = "Materiaal is toegevoegd.";
    }
}

echo "<table><tr><td><a href='addMateriaal.php' id='addMateriaalLink'>Toevoegen</a></td><td>$succes</td></tr></table>";

echo "<div id='materiaalList'>";
// materialen tonen
foreach ($materiaalen as $materiaal) {
    echo "<a class='materiaalListItem' href='editMateriaal.php?id=" . $materiaal["MateriaalID"] . "'>";
    echo "<div class='materiaalListItemInner'>";
    echo "<span class='titel'>" . $materiaal["Materiaal_soort"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $materiaal["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";

renderHtmlEndAdmin();
