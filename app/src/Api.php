<?php

namespace Angorb\PixelCanvas;

use Psr\Http\Message\ServerRequestInterface;

class Api
{
    public function test(ServerRequestInterface $request): array
    {
        return [
            'hey' => 'gotcha'
        ];
    }
}
