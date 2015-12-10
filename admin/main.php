<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("inlog", "");


echo "welkom: " . getUser();
?>


<script>
    if (window.location.hash != "") {
        alert(window.location.hash.substr(1));
        window.location.hash = "";
    }
</script>
<?php

//require "schilderijList.php";

renderHtmlEndAdmin();

