const rgb2hex = (rgb) => `#${rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/).slice(1).map(n => parseInt(n, 10).toString(16).padStart(2, '0')).join('')}`

$("#colorpicker").spectrum({
    color: "#000",
});

$().ready(function () {
    var colorPicker = $('#colorpicker');

    // click an individual cell
    $('.grid').mousedown(function () {
        $('.cell').hover(function () {
            $(this).css('background-color', colorPicker.spectrum('get').toRgbString());
        });
    }).mouseup(function () {
        $('.cell').unbind('mouseenter mouseleave');
    });


    // Reset the canvas to an 'off' state
    $('#reset').click(function () {
        $('.cell').css('background-color', 'black');
    });

    $('#export').click(function () {
        var cellColors = {};
        $('.cell').each(function () {
            cellColors[$(this).attr('name')] = $(this).css('background-color');
        });
        console.log(cellColors);
    });
});