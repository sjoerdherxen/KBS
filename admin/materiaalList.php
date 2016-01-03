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

echo "<a href='addMateriaal.php' id='addMateriaalLink'>Toevoegen</a>";
echo "<div id='materiaalList'>";
// door lijst materialen gaan en tonen
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
