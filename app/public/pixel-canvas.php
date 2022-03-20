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
            <div class="grid">
                <?php for ($i = 0; $i < 4096; $i++) : ?>
                    <div id='px<?= $i ?>' name='<?= $i ?>' class='cell'></div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="col-sm-8 offset-sm-2 ml-2 my-2 align-right">
            <form class="form-inline">
                <input id='colorpicker' class="form-control">
                <input id='session-id' type='hidden' value='<?= session_id() ?>'>
                <div class="col-auto">
                    <label class="sr-only" for="export-name">Name</label>
                    <input type="text" class="form-control mb-2" id="export-name" placeholder="My Pixel Art">
                </div>
                <button type="button" class="btn btn-success" id="save">Save</button>
                <button type="button" class="btn btn-info" id="export">Export</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </form>
        </div>
        <?php if (DEBUG) include __DIR__ . '/../templates/debug-controls.php'; ?>
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
