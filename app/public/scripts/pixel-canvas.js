const rgb2hex = (rgb) => `#${rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/).slice(1).map(n => parseInt(n, 10).toString(16).padStart(2, '0')).join('')}`

$("#colorpicker").spectrum({
    color: "#fff",
    showPalette: true,
    showSelectionPalette: true,
    palette: [],
    localStorageKey: "pixel-color." + $('#session-id').val(),
});

$().ready(function () {
    var colorPicker = $('#colorpicker');

    // draw on the canvas
    $('.grid').mousedown(function () {
        $('.cell').hover(function () {
            $(this).css('background-color', colorPicker.spectrum('get').toRgbString());
        });
    }).mouseup(function () {
        $('.cell').unbind('mouseenter mouseleave');
    }).mouseleave(function () {
        $('.cell').unbind('mouseenter mouseleave');
    });

    // Reset the canvas to an 'off' state
    $('#reset').click(function () {
        console.log('Grid reset.');
        $('.cell').css('background-color', 'transparent');
    });

    // dump the cell colors somewhere
    $('#export').click(function () {
        var cellColors = {};
        $('.cell').each(function () {
            cellColors[$(this).attr('name')] = $(this).css('background-color');
        });
        var data = {
            name: $('input#export-name').val(),
            cells: cellColors
        };
        $.post('/api', data, function (response) {
            console.log(response);
        });
    });
});
