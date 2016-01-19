<?php

date_default_timezone_set("Europe/Amsterdam");

function isLoggedIn() {
    return isset($_SESSION['inlog']) && $_SESSION['inlog'] != "";
}

function getUser() {
    return $_SESSION['inlog'];
}

// query op db uitvoeren
function query($query, $params) {
    try {
// connectie maken
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
//$pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
        $q = $pdo->prepare($query);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// uitvoeren
        $q->execute($params);
//get results
        $result = $q->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null; // drop connection
        return $result;
    } catch (PDOException $e) {
        return null;
    }
}

function insert($query, $params) { // check query function returns id of inserted record
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
//$pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
        $q = $pdo->prepare($query);
        $q->execute($params);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return null;
    }
}

/*

  // query op db uitvoeren
  function query($query, $params) {
  try {
  // connectie maken
  $pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
  // query opbouwe
  $q = $pdo->prepare($query);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  // uitvoeren
  $q->execute($params);
  //get results
  $result =  $q->fetchAll(PDO::FETCH_ASSOC);
  $pdo = null;// drop connection
  return $result;
  } catch (PDOException $e) {
  return null;
  }
  }

  function insert($query, $params) { // check query function returns id of inserted record
  try {
  $pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
  $q = $pdo->prepare($query);
  $q->execute($params);
  return $pdo->lastInsertId();
  } catch (PDOException $e) {
  return null;
  }
  }

 */

function in_query_result($data, $search, $column) {
// check of waarde in query result staat
//wordt gebruikt in schilderij edit/add
    foreach ($data as $item) {
        if ($item[$column] == $search) {
            return true;
        }
    }
    return false;
}

function uploadSchilderijImg($id, $imgExtension, $old, $preupload) {
    if ($old != null) {
        if (file_exists("./../content/uploads/" . $old)) {
            unlink("./../content/uploads/" . $old);
        }
        if (file_exists("./../content/uploads/small_" . $old)) {
            unlink("./../content/uploads/small_" . $old);
        }
    }

    $newpath = "./../content/uploads/" . $id . $imgExtension;
    $smallpath = "./../content/uploads/small_" . $id . $imgExtension;

    query("UPDATE schilderij SET Img = ? WHERE Schilderij_ID = ?", array($id . $imgExtension, $id));
    if ($preupload == null) {
        move_uploaded_file($_FILES["img"]["tmp_name"], $newpath);
    } else {
        copy($preupload, $newpath);
        unlink($preupload);
    }
    copy($newpath, $smallpath);

    resizeImg(1150, $newpath, $imgExtension, 75);
    resizeImg(228, $smallpath, $imgExtension, 50);
 
}

function checkCaptcha($captchaInput) {
    $clientIp = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $postfields = array(
        "secret" => "6LdBuRITAAAAADrYsJ3kWF89lQixPx0MntyZYVX0",
        "response" => $captchaInput,
        "remoteip" => $clientIp
    );
// curl doet post request naar google
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // zet op 1 bij upload

    $response = json_decode(curl_exec($ch));

    return $response->success == true;
}

function uppercase($text) {
    if (gettype($text) == "string") {
        $text = trim($text);
        if (str_word_count($text) > 1) {
            $text = preg_replace('/([.!?])\s*(\w)/e', "strtoupper('\\1 \\2')", ucfirst(strtolower($text)));
            return $text;
        } elseif (str_word_count($text) == 1) {
            $text = ucfirst($text);
            return $text;
        } else {
            return $text;
        }
    } else {
        return $text;
    }
}

function showSmallImagesList($queryresult, $count) {
    echo "<div class='schilderijPreviewList'>";
    if ($count[0]["count"] > count($queryresult)) {
        echo "<span class='glyphicon glyphicon-plus schilderijPreviewListPlus'></span>";
    }
    foreach ($queryresult as $schilderij) {
        echo "<div class='schilderijListItemImg' style='background-image: url(\"/content/uploads/small_" . $schilderij["Img"] . "?_=" . strtotime(date("Y-m-d H:i:s")) . "\");'></div>";
    }

    echo "</div>";
}

function toonSchilderijLijst($schilderijen) {
    echo '<div class="gallerij">';
    $i = 0;
    $rowAmount = floor(count($schilderijen) / 4);
    $extra = count($schilderijen) % 4;
    echo "<div class='row'>";
    $col = 0;
    if (count($schilderijen) == 0) {
        echo "<p style='text-align:center;'>Er zijn hiervan geen schilderijen.</p>";
    } else {
        foreach ($schilderijen as $schilderij) {
            if ($i == 0) {
                echo "<div class='col-sm-3'>";
                $col++;
            }
            $i++;
            ?>
            <a href="/admin/editSchilderij.php?id=<?php echo $schilderij["Schilderij_ID"] ?>" class=""> 
                <div class="img">
                    <img src="/content/uploads/small_<?php echo $schilderij["Img"]; ?> " alt="Logo" >

                    <div class="title">
                        <?php echo $schilderij["Titel"]; ?>
                    </div>
                    <div class="extraInfo">
                        <?php echo $schilderij["Hoogte"]; ?> x <?php echo $schilderij["Breedte"]; ?> cm
                    </div>
                    <div class="extraInfoRight">
                        <?php echo $schilderij["Jaar"] == "0000" ? "" : $schilderij["Jaar"]; ?>
                    </div>
                </div> 
            </a>
            <?php

            if (($col > $extra && $i >= $rowAmount) || ($col <= $extra && $i > $rowAmount)) {
// einde rij
                echo "</div>";
                $i = 0;
            }
        }
    }

    echo "</div>";
    echo '<div style="clear: both;"></div>';
    echo "</div>";
    echo '<div style="clear: both;"></div>';
}

function resizeImg($newWidth, $targetFile, $extension, $verkleining) {
    //get image size from $src handle
    list($width, $height) = getimagesize($targetFile);

    $newHeight = ($height / $width) * $newWidth;

    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    $src = null;
    switch (strtolower($extension)) {
        case '.jpg':
        case '.jpeg':
            $src = imagecreatefromjpeg($targetFile);
            break;
        case '.png':
            $src = imagecreatefrompng($targetFile);
            break;
        case '.gif':
            $src = imagecreatefromgif($targetFile);
            break;
    }
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    //allow transparency for pngs
    imagealphablending($tmp, false);
    imagesavealpha($tmp, false);

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }

    //handle different image types.
    //imagepng() uses quality 0-9
    switch (strtolower($extension)) {
        case '.jpg':
        case '.jpeg':
            imagejpeg($tmp, $targetFile, $verkleining);
            break;
        case '.png':
            imagepng($tmp, $targetFile, round($verkleining/11.1111111), 2);
            break;
        case '.gif':
            imagegif($tmp, $targetFile);
            break;
    }

    //destroy image resources
    imagedestroy($tmp);
    imagedestroy($src);
}
