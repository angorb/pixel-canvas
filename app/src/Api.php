<?php

namespace Angorb\PixelCanvas;

use Psr\Http\Message\ServerRequestInterface;

class Api
{
    public const CANVAS_WIDTH = 64;

    public function status(ServerRequestInterface $request): array
    {
        return [
            'status' => 'OK',
            'time' => \time()
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
            foreach ($data['cells'] as $index => $rgba) {
                // get color and x/y
                $x = $index % self::CANVAS_WIDTH;
                $y =  ($index - $x) / self::CANVAS_WIDTH;

                $color = [];
                \preg_match(
                    '/rgba?\((\d+),\s*(\d+),\s*(\d+),?\s*(\d?)\)/',
                    $rgba,
                    $color
                );

                $cells[$index] = [
                    'x' => $x,
                    'y' => $y,
                    'r' => $color[1],
                    'g' => $color[2],
                    'b' => $color[3],
                    'a' => $color[4] ?? 0,
                ];
            }
        }

        if (
            !\is_null($fileName)
            && !\is_null($cells)
            && \file_put_contents(
                __DIR__ . '/../data/' . $fileName,
                json_encode($cells, \JSON_FORCE_OBJECT)
            )
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
        return [];
    }

    // return a list of all saved
    public function listSaved(ServerRequestInterface $request): array
    {
        $path = \realpath(__DIR__ . '/../data/');
        $files = [];
        if ($path) {
            $found = glob($path . '/*.json');
            \ksort($found);
            foreach ($found as $file) {
                $name = \basename($file);
                $files[$name] = $file;
            }
        }
        return $files;
    }
}
