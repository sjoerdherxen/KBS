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
            <div class="divcontent">
                
                <br>
                
                <ul class="ulmenu">
                    <li class="limenu"><img id="headlogo" src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo"></li>
                    <li class="limenu"><a href="url" id="menutext">   Home</a></li>
                    <li class="limenu"><a href="url" id="menutext">Gallerij</a></li>
                    <li class="limenu"><a href="url" id="menutext">Kopen</a></li>
                    <li class="limenu"><a href="url" id="menutext">Contact</a></li>                
                </ul>
                               
                              
                <footer class="footermenu">
                    <ul>
                        <li><a href="url" id="menutext">Contact</a></li>
                        <li><a href="url" id="menutext">Sitemap</a></li>
                        <li><a id="menutext">Powered by Windesheim</a></li>

                    </ul>
                </footer>
            
            <?php
        }

        function renderHtmlEnd() {
            ?>
            </div>
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
                    <li><a href="/admin/categorieList.php">Categorie&euml;n</a></li>
                    <li><a href="/admin/main.php">Schilder technieken</a></li>
                    <li><a href="/admin/main.php">Overig</a></li>
                    <li class="menu-right"><a href="/admin/uitloggen.php">Uitloggen</a></li>
                    <li class="menu-right"><span><?php echo $_SESSION["inlog"]; ?></span></li>
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
