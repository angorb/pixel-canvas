<?php

use Angorb\PixelCanvas\Console;

require_once __DIR__ . '/../config/bootstrap.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- Spectrum Color Picker - implement via NPM? - https://bgrins.github.io/spectrum/#modes-custom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <link rel="stylesheet" href="/css/main.css">

    <title>Pixel Canvas</title>
</head>

<body>
    <nav class="nav navbar">
        <h1>Pixel Canvas</h1>
    </nav>
    <div class="container">
        <!-- Picker Table -->
        <div class="col-sm-8 offset-sm-2 my-3">
            <input id='colorpicker'>
            <div class="grid">
                <?php for ($i = 0; $i < 4096; $i++) : ?>
                    <div id='px<?= $i ?>' name='<?= $i ?>' class='cell'></div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="col-sm-8 offset-sm-2 ml-2 my-2">
            <form class>
                <div class="form-row">
                    <div class="col-8">
                        <input type="text" class="form-control d-inline col-sm-3" id="export-name" placeholder="My Pixel Art" lenth="10">
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-success" id="save">Save</button>
                    </div>
                </div>
                <div class=" form-row">
                    <div class="col-8">
                        <select id="saved-file-select" class="form-select"></select>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-warning" id="load">Load</button>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-danger" id="reset">Reset</button>
                        <input id='session-id' type='hidden' value='<?= session_id() ?>'>
                    </div>
                </div>
            </form>
        </div>
        <?php if (DEBUG) {
            include __DIR__ . '/../templates/debug-controls.php';
        } ?>
    </div>

    <!-- JavaScript -->
    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/hexcolor.js"></script>
    <script src="/scripts/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script src="/scripts/pixel-canvas.js"></script>
    <?php Console::log('Butts. ' . time()); ?>
</body>

</html>