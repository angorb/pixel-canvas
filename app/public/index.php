<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Spectrum Color Picker - implement via NPM! -->
    <!-- https://bgrins.github.io/spectrum/#modes-custom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <link rel="stylesheet" href="/css/main.css">

    <title>Pixel Canvas</title>
</head>

<body>
    <div class="container-flex">
        <h1>Pixel Canvas</h1>
        <div class="col-sm-4 align-right">
            <form class="form-inline">
                <div class="d-flex p-2 mr-2" id="recentColorPicker">
                    <?php for ($i = 0; $i < 10; $i++) : ?>
                        <div class="d-block mx-1 recentColor"></div>
                    <?php endfor; ?>
                </div>
                <input id='colorpicker' class="form-control">
                <button type="button" class="btn btn-info" id="export">Export</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </form>
        </div>
        <!-- Picker Table -->
        <div class="col-sm-8">
            <div class="grid">
                <?php for ($i = 0; $i < 4096; $i++) : ?>
                    <div id='px<?= $i ?>' name='<?= $i ?>' class='cell'></div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script src="/js/pixel-canvas.js"></script>
</body>

</html>