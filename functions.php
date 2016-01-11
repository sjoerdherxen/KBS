<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// spaties printen
function printspace($aantal) {
    for ($i = 0; $i < $aantal; $i++) {
        print(" ");
    }
}

//print teken
function printteken($aantal, $teken) {
    for ($i = 0; $i < $aantal; $i++) {
        print($teken);
    }
}

// query op db uitvoeren 
function query($query, $params) {
    try {
        // connectie maken
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        // query opbouwe
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
/*

  //query op db uitvoeren
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

function toonSchilderijLijst($schilderijen, $page, $pageCount, $pageSize, $url) {
    $i = 0;
    $rowAmount = floor(count($schilderijen) / 4);
    $extra = count($schilderijen) % 4;
    echo "<div class='row'>";
    $col = 0;
    if (count($schilderijen) == 0) {
        echo "<p style='text-align:center;'>Er zijn geen schilderijen gevonden.</p>";
    } else {
        foreach ($schilderijen as $schilderij) {
            if ($i == 0) {
                echo "<div class='col-sm-3'>";
                $col++;
            }
            $i++;
            ?>
            <a href="/schilderij.php?id=<?php echo $schilderij["Schilderij_ID"] ?>" class=""> 
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
    //if ($i % 4 != 0) {
    // einde rij indien niet pagina vullende content
    //    echo "</div>";
    //}
    echo "</div>";
    ?>

    <div style="clear: both;"></div>
    <?php

// pager
    if ($pageCount >= 2) {
        ?>
        <div id="pages-wrapper">
            <div id="pages" class="btn-group">
                <?php

                //prev button
                $prevPageHref = $page == 1 ? "" : 'href="' . $url . 'page=' . ($page - 1) . '"';
                echo '<a class="btn btn-default prev" ' . $prevPageHref . '><span class="glyphicon glyphicon-chevron-left"></span></a>';

                for ($i = 1; $i <= $pageCount; $i++) {
                    if ($i == $page) {
                        // current
                        echo "<span class='active btn btn-default btn-active'>" . $i . "</span>";
                    } else {
                        // other pages
                        echo "<a class='btn btn-default' href='" . $url . "page=" . $i . "'>" . $i . "</a>";
                    }
                }

                // next button
                $nextPageHref = $page == $pageCount ? "" : 'href="' . $url . 'page=' . ($page + 1) . '"';
                echo '<a class="btn btn-default next" ' . $nextPageHref . '><span class="glyphicon glyphicon-chevron-right"></span></a>';
                ?>
            </div>
        </div>
        <?php

    }
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
