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
    <div class="container-flex">
        <h1>Pixel Canvas</h1>
        <div class="col-sm-4 align-right">
            <form class="form-inline">
                <input id='colorpicker' class="form-control">
                <input id='session-id' type='hidden' value='<?= session_id() ?>'>
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
        <?php if (DEBUG) include __DIR__ . '/../templates/debug-controls.php'; ?>
    </div>

    <!-- JavaScript -->
    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script src="/scripts/pixel-canvas.js"></script>
    <?php Console::log('Butts.'); ?>
</body>

</html>