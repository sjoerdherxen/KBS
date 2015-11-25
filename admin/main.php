<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStart("inlog", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');


echo "welkom: " . getUser();
?>
<a href="uitloggen.php">uitloggen</a>
<?php

renderHtmlEnd();

