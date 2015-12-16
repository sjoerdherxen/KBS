<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function printspace($aantal) {
    for ($i = 0; $i < $aantal; $i++) {
        print(" ");
    }
}

function printteken($aantal, $teken) {
    for ($i = 0; $i < $aantal; $i++) {
        print($teken);
    }
}

function query($query, $params) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        $q = $pdo->prepare($query);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $q->execute($params);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

function checkCaptcha($captchaInput) {


    $clientIp = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $postfields = array(
        "secret" => "6LdBuRITAAAAADrYsJ3kWF89lQixPx0MntyZYVX0",
        "response" => $captchaInput,
        "remoteip" => $clientIp
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = json_decode(curl_exec($ch));

    return $response->success == true;
}

function toonSchilderijLijst($schilderijen, $page, $pageCount, $pageSize, $url) {
    $i = 0;
    foreach ($schilderijen as $schilderij) {
        if ($i % 4 == 0 && $i != $pageSize) {
            echo "<div class='row'>";
        }
        $i++;
        ?>
        <a href="/schilderij.php?id=<?php echo $schilderij["Schilderij_ID"] ?>" class="col-md-3"> 
            <div class="img">
                <img src="<?php echo $schilderij["Img"]; ?> " alt="Logo" >

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

        if ($i % 4 == 0 && $i != 0) {
            echo "</div>";
        }
    }
    if ($i % 4 != 0) {
        echo "</div>";
    }
    ?>

    <div style="clear: both;"></div>
    <?php

    if ($pageCount >= 2) {
        ?>
        <div id="pages-wrapper">
            <div id="pages" class="btn-group">
                <?php

                $prevPageHref = $page == 1 ? "" : 'href="'.$url.'page=' . ($page - 1) . '"';
                echo '<a class="btn btn-default prev" ' . $prevPageHref . '><span class="glyphicon glyphicon-chevron-left"></span></a>';

                for ($i = 1; $i <= $pageCount; $i++) {
                    if ($i == $page) {
                        echo "<span class='active btn btn-default btn-active'>" . $i . "</span>";
                    } else {
                        echo "<a class='btn btn-default' href='".$url."page=" . $i . "'>" . $i . "</a>";
                    }
                }

                $nextPageHref = $page == $pageCount ? "" : 'href="'.$url.'page=' . ($page + 1) . '"';
                echo '<a class="btn btn-default next" ' . $nextPageHref . '><span class="glyphicon glyphicon-chevron-right"></span></a>';
                ?>
            </div>
        </div>
        <?php

    }
}
