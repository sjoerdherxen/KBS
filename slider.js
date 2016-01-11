var intervalMove = 0;
// wat is dit voor kutcode

jQuery(document).ready(function ($) {
    /*
     $('#checkbox').change(function () { // dat werkt wel, NOT!!
     setInterval(function () {
     moveRight();
     }, 3000);
     });
     */
    var setIntervalMove = function() {
        clearInterval(intervalMove);
        intervalMove = setInterval(function () {
            moveRight();
        }, 10000);
    };

    var slideCount = $('#slider ul li').length;
    var slideWidth = $('#slider ul li').width();
    var slideHeight = $('#slider ul li').height();
    var sliderUlWidth = slideCount * slideWidth;

    $('#slider').css({width: slideWidth, height: slideHeight});

    $('#slider ul').css({width: sliderUlWidth, marginLeft: -slideWidth});

    $('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $('#slider ul').animate({
            left: +slideWidth
        }, 500, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    }

    function moveRight() {
        $('#slider ul').animate({
            left: -slideWidth
        }, 500, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    }

    $('a.control_prev').click(function () {
        setIntervalMove();
        moveLeft();
    });

    $('a.control_next').click(function () {
        setIntervalMove();
        moveRight();
    });

});
