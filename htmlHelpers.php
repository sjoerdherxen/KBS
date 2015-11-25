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
        <body><?php

        }

        function renderHtmlEnd() {
            ?>
        </body>
    </html>
    <?php

}
