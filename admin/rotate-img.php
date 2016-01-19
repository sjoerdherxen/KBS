<?php

include 'functions.php';
if (!isset($_POST["rotate_img"])) {
    header("location:index.php");
    exit();
} else {
    $schilderijId = $_GET["id"];
    $resultImg = query("SELECT Img FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
    $schilderij["Img"] = $resultImg[0]["Img"];
    $image = "/content/uploads/" . $schilderij["Img"];
    $angle = 90;
    $bgd_color = 0;
    $newimage = imagerotate($image, $angle, $bgd_color);    
    imagealphablending($newimg, false);
    imagesavealpha($newimage, false); 
    imagejpeg($newimage, $image, 100);
    header("location:editschilderij.php?id=$_GET[id]");
    exit();
}
?>