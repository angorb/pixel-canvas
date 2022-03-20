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

    // saves a matrix to a file
    public function save(ServerRequestInterface $request): array
    {
        $saved = false;
        $fileName = null;
        $cells = null;

        $data = $request->getParsedBody();

        if (!empty($data['name'])) {
            $fileName = $data['name'] . '.json';
        }

        if (!empty($data['cells']) && \count($data['cells']) > 0) {
            $cells = \json_encode($data['cells'], JSON_FORCE_OBJECT & JSON_PRETTY_PRINT);
        }

        if (
            !\is_null($fileName)
            && !\is_null($cells)
            && \file_put_contents(__DIR__ . '/../data/' . $fileName, $cells)
        ) {
            $saved = \true;
        }

        return [
            'saved' => $saved,
            'cellCount' => \count($data['cells']),
            'fileName' => $fileName
        ];
    }

    // loads a matric from a file
    public function load(ServerRequestInterface $request): array
    {
    }

    // return a list of all saved
    public function listSaved(ServerRequestInterface $request): array
    {
    }
}
