<?php

namespace Angorb\PixelCanvas;

class Console
{
    public static function log(string $message)
    {
        echo "<script>console.log('{$message}');</script>";
    }
}
