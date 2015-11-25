<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStart("inlog", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');


echo "welkom: " . getUser();
?>
<a href="uitloggen.php">uitloggen</a><br/>
<a href="schilderijList.php">schilderijen</a>

<?php

//require "schilderijList.php";

renderHtmlEnd();

