<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Materiaal", "");
$query = "SELECT * FROM Materiaal";
$materiaalen = query($query, null);

echo "<a href='addMateriaal.php' id='addMateriaalLink'>Toevoegen</a>";
echo "<div id='materiaalList'>";
foreach ($materiaalen as $materiaal) {
    echo "<a class='materiaalListItem' href='editMateriaal.php?id=" . $materiaal["MateriaalID"] . "'>";
    echo "<div class='materiaalListItemInner'>";
    echo "<span class='titel'>" . $materiaal["Materiaal_soort"] . "</span><br/>  ";
    echo "<span class='beschrijving'>" . $materiaal["Beschrijving"] . "</span><br/>";
    echo "</div>";
    echo "</a>";
}
echo "</div>";
?>
<script>
    if (window.location.hash != "") {
        alert(window.location.hash.substr(1));
        window.location.hash = "";
    }
</script>
<?php

renderHtmlEndAdmin();
