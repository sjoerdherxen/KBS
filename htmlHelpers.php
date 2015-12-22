<?php

function renderHtmlStart($title, $extra) {// top van html voor klant gedeelte
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

                    <ul id="ulmenu">
                        <li class="limenu"><a href="url" target="_blank"> <img id="headlogo" src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo"></a></li>
                        <!-- even kijken hoe we het logo een link kunnen geven zonder dat deze verandert in .ulmenu<a href="url"></a>-->
                        <li class="limenu"><a href="/hoofdpagina.php" class="menutext">Home</a></li>
                        <li class="limenu"><a href="/gallerij.php" class="menutext">Gallerij</a></li>
                        <li class="limenu"><a href="/zoeken.php" class="menutext">Zoeken</a></li> 
                        <li class="limenu"><a href="/contact.php" class="menutext">Contact</a></li>    


                    </ul>
                </div>           



                <?php

            }

            function renderHtmlEnd() { // einde klant gedeelte
                ?>
                <footer class="footermenu">
                    <ul>
                        <li><a href="/contact.php" class="menutext">Contact</a></li>
                        <li><a class="menutext">Powered by Windesheim</a></li>

                    </ul>
                </footer>
            </div>
        </body>
    </html>
    <?php

}

function renderHtmlStartAdmin($title, $extra, $page) {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $title; ?></title>
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
                    <li><a href="/admin/main.php" <?php if ($page == "main") echo "class='active'"; ?>>Home</a></li>
                    <li><a href="/admin/schilderijList.php" <?php if ($page == "schilderij") echo "class='active'"; ?>>Schilderijen</a></li>
                    <li><a href="/admin/categorieList.php" <?php if ($page == "categorie") echo "class='active'"; ?>>Categorie&euml;n</a></li>
                    <li><a href="/admin/subcategorieList.php" <?php if ($page == "subcategorie") echo "class='active'"; ?>>Subcategori&euml;n</a></li>
                    <li><a href="/admin/materiaalList.php" <?php if ($page == "materiaal") echo "class='active'"; ?>>Materialen</a></li>
                    <li><a href="/admin/editContactgegevens.php" <?php if ($page == "contact") echo "class='active'"; ?>>Contactgegevens</a></li>
                    <li class="menu-right"><a href="/admin/uitloggen.php">Uitloggen</a></li>
                    <li class="menu-right"><a href="/admin/account.php" <?php if ($page == "account") echo "class='active'"; ?>><?php echo $_SESSION["inlog"]; ?></a></li>
                </ul>
            </div>
            <script>
                if (window.location.hash != "") {
                    alert(window.location.hash.substr(1));
                    window.location.hash = "";
                }
            </script>
            <div id="content">
                <?php

            }

            function renderHtmlEndAdmin() {
                ?>
            </div>
        </body>
    </html>
    <?php

}
