<?php

include 'functions.php';
if (!isset($_POST["rotate_img"])) {
    header("location:index.php");
    exit();
} else {
    $schilderijId = $_GET["id"];
    $resultImg = query("SELECT Img FROM schilderij WHERE schilderij_id = ?", array($schilderijId));
    $schilderij["Img"] = $resultImg[0]["Img"];
    $imagepath = "./../content/uploads/" . $schilderij["Img"];
    $angle = 90;
    $bgd_color = 0;
    $extension = strtolower(strrchr($imagepath, "."));

    switch ($extension) {
        case '.jpg':
        case '.jpeg':
            $image = imagecreatefromjpeg($imagepath);
            break;
        case '.png':
            $image = imagecreatefrompng($imagepath);
            break;
        case '.gif':
            $image = imagecreatefromgif($imagepath);
            break;
    }

    $newimage = imagerotate($image, $angle, $bgd_color);
    imagealphablending($newimage, false);
    imagesavealpha($newimage, false);
    //imagejpeg($newimage, $imagepath, 100);
    unlink($imagepath);

    switch (strtolower($extension)) {
        case '.jpg':
        case '.jpeg':
            imagejpeg($newimage, $imagepath, 100);
            break;
        case '.png':
            imagepng($newimage, $imagepath, 9);
            break;
        case '.gif':
            imagegif($newimage, $imagepath);
            break;
    }
    
// rescale image
    resizeImg(1150, $imagepath, $extension, 75);
    
    $smallimagepath = "./../content/uploads/small_" . $schilderij["Img"];
    copy($imagepath, $smallimagepath);
    resizeImg(228, $smallimagepath, $extension, 50);
    header("location:editSchilderij.php?id=$_GET[id]");
    exit();
}
?>