<?php

function renderHtmlStart($title, $extra) {
    ?><html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $title; ?></title>
            <link rel="stylesheet" type="text/css" href="newcss.css">
            <link rel="icon"
                  type="image/ico"
                  href="content/favicon.ico">
                  <?php
                  echo $extra;
                  ?>
            <!--Commentaar -->
        </head>
        <body>
            <br>
            <ul class="ulmenu">
                <li class="limenu"><a href="url" id="menutext">   Home</a></li>
                <li class="limenu"><a href="url" id="menutext">Gallerij</a></li>
                <li class="limenu"><a href="url" id="menutext">Kopen</a></li>
                <li class="limenu"><a href="url" id="menutext">Contact</a></li>                
            </ul>


            
            <footer class="footermenu">
                <ul>
                    <li><a href="url">Contact</a></li>
                    <li><a href="url">Sitemap</a></li>
                    <li>Powered by Windesheim</li>
                    
                </ul>
                
                
                
                
            </footer>
            <?php
        }

        function renderHtmlEnd() {
            ?>
        </body>
    </html>
    <?php
}

function renderHtmlStartAdmin($title, $extra) {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $title; ?></title>
            <link rel="stylesheet" type="text/css" href="newcss.css">
            <link rel="icon" type="image/ico" href="/content/favicon.ico">
            <link href="/newcss.css" type="text/css" rel="stylesheet">
            <link href="/content/admin.css" type="text/css" rel="stylesheet">
    <?php
    echo $extra;
    ?>
            <!--Commentaar -->
        </head>
        <body>
            <div id="navigation">
                <ul>
                    <li><a href="/admin/main.php">Home</a></li>
                    <li><a href="/admin/schilderijList.php">Schilderijen</a></li>
                    <li><a href="/admin/categorie.php">Categorie&euml;n</a></li>
                    <li><a href="/admin/main.php">Schilder technieken</a></li>
                    <li><a href="/admin/main.php">Overig</a></li>
                    <li class="menu-right"><span><?php echo $_SESSION["inlog"]; ?></span></li>
                    <li class="menu-right"><a href="/admin/uitloggen.php">Uitloggen</a></li>
                </ul>
            </div>
    <?php
}

function renderHtmlEndAdmin() {
    ?>
        </body>
    </html>
            <?php
        }
        