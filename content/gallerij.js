$(function () {
    var  timer;
    
    $(".img").mouseleave(function (e) {
        clearTimeout(timer);
    });
    
    $(".img").mousemove(function () {
        $img = $(this);
        //lastMoveOnImg = new Date().getTime();
        clearTimeout(timer);
        timer = setTimeout(function () {
            openLargeImg($img);
        }, 1000);

    });

    

    function openLargeImg(element) {
        var height = element.height();

        var imgHeight = element.children("img").height();
        element.children(".title").css({"top": imgHeight + "px"});

        var imgHeightMetTitle = imgHeight + element.children(".title").height();
        element.children(".extraInfo").css({"top": imgHeightMetTitle + 12 + "px"});
        element.children(".extraInfoRight").css({"top": imgHeightMetTitle + 12 + "px"});

        element.height(height);
        element.addClass("hover");

        element.mouseleave(function () {
            element.removeClass("hover");
            element.children(".title").css("top", 0);
            element.children(".extraInfo").css("top", 0);
            element.children(".extraInfoRight").css("top", 0);
        });
    }
});