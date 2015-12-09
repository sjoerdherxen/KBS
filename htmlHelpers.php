<?php
include './functions.php';
function renderHtmlStart($title, $extra) {
    ?><html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $title; ?></title>
            <link rel="stylesheet" type="text/css" href="newcss.css">
            <link href="/content/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link rel="icon"
                  type="image/ico"
                  href="content/favicon.ico">
            <script src="/content/jquery-1.11.3.min.js"></script>
            <script src="/content/bootstrap/js/bootstrap.min.js"></script>
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <?php
            echo $extra;
            ?>
            <!--Commentaar -->
        </head>
        <body>
            <div class="content">
                <div class="menu">
                    <br>

                    <ul class="ulmenu">
                        <li class="limenu"><img id="headlogo" src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo"></li>
                        <!-- even kijken hoe we het logo een link kunnen geven zonder dat deze verandert in .ulmenu<a href="url"></a>-->
                        <li class="limenu"><a href="/hoofdpagina.php" id="menutext">Home</a></li>
                        <li class="limenu"><a href="/gallerij.php" id="menutext">Gallerij</a></li>
                        <li class="limenu"><a href="/zoeken.php" id="menutext">Zoeken</a></li> 
                        <li class="limenu"><a href="/contact.php" id="menutext">Contact</a></li>    

                    </ul>
                </div>           



                <?php
            }

            function renderHtmlEnd() {
                ?>
                <footer class="footermenu">
                    <ul>
                        <li><a href="url" id="menutext">Contact</a></li>
                        <li><a href="url" id="menutext">Sitemap</a></li>
                        <li><a id="menutext">Powered by Windesheim</a></li>

                    </ul>
                </footer>
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
            <link href="/content/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <script src="/content/jquery-1.11.3.min.js"></script> 
            <script src="/content/bootstrap/js/bootstrap.min.js"></script>
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
                    <li><a href="/admin/subcategorieList.php">Subcategori&euml;n</a></li>
                    <li><a href="/admin/materiaalList.php">Materialen</a></li>
                    <li><a href="/admin/main.php">Contactgegevens</a></li>
                    <li class="menu-right"><a href="/admin/uitloggen.php">Uitloggen</a></li>
                    <li class="menu-right"><a href="/admin/account.php"><?php echo $_SESSION["inlog"]; ?></a></li>
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
