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
                <div class="bovenmenu">
                    <span class="menutext">
                        <?php

                        //result is uitgezet omdat het email adres nu nog niet geshowed hoeft te worden!!

                        $result = query("SELECT Email, Telefoon FROM schilder LIMIT 0,1", null);
                        echo "Tel: " . $result[0]["Telefoon"] . " | Email:" . $result[0]["Email"] . " | ";
                        ?>
                    </span>
                    <a class="menutext" href="/admin/">Login</a> &nbsp; &nbsp;  
                </div>

                <div class="menu">
                    <span class="menu-hofvanellen">Hof van Ellen</span>
                    <ul class="nav nav-pills" id="ulmenu">

                        <li ><a href="http://hofvanellen.nl/schilderij.php?id=1" class="bootstrapoveride"><img id="headlogo" src="/content/uploads/IMG_2309.jpeg" alt="Logo"></a></li>
                        <li role="presentation" class="topmenu"><a href="/hoofdpagina.php" class="menutext">Home</a></li>
                        <li role="presentation" class="topmenu"><a href="/gallerij.php" class="menutext">Galerij</a></li>
                        <li role="presentation" class="topmenu"><a href="/zoeken.php" class="menutext">Zoeken</a></li>
                        <li role="presentation" class="topmenu"><a href="/contact.php" class="menutext">Contact</a></li> 
                    </ul>
                    <div class="line">

                    </div>
                </div>  
                <div class="contentcontent">








                    <?php

                }

                function renderHtmlEnd() { // einde klant gedeelte
                    ?>
                </div>
                <footer class="footermenu">
                    <ul>
                        <li><a href="/contact.php" class="menutext">Contact</a></li>
                        <li class="menutext">Powered by Windesheim</li>

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
                    <li><a href="/admin/editWelkomstekst.php" <?php if ($page == "Welkomsttekst") echo "class='active'"; ?>>Welkomsttekst</a></li>
                    <li class="menu-right"><a href="/admin/uitloggen.php">Uitloggen</a></li>
                    <li class="menu-right"><a href="/admin/account.php" <?php if ($page == "account") echo "class='active'"; ?>><?php echo $_SESSION["inlog"]; ?></a></li>
                    <li class="menu-right"><a target="_blank" href="/hoofdpagina.php">Website</a></li>
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
