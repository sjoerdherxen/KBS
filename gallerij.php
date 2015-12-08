<?php

include './htmlHelpers.php';
include './admin/functions.php';
renderHtmlStart("Gallerij", "");
?>

<div class="gallerij">
    <?php

    $page = 1;
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        $page = $_GET["page"];
    }
    $pageCountResult = query("SELECT COUNT(*) as aantal FROM Schilderij", null);
    $pageCount = ceil($pageCountResult[0]["aantal"] / 20);
    if ($page > $pageCount) {
        $page = $pageCount;
    }

    $schilderijen = query("SELECT * FROM schilderij LIMIT " . ($page * 20 - 20) . ", 20", null);

    foreach ($schilderijen as $schilderij) {
        ?>

        <div class="img">
            <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
                <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
            </a>
            <div class="title">Title</div>
        </div>
    <?php } ?>
    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
        <br>

    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
        <br>

    </div>
    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
    </div>

    <div class="img">
        <a target="_parent" href="http://s9.postimg.org/6wmkzix6n/logo.jpg">
            <img src="http://s9.postimg.org/6wmkzix6n/logo.jpg" alt="Logo" >
        </a>
        <div class="title">Title</div>
        <br>

    </div>
</div>

<?php

renderHtmlEnd();
?>