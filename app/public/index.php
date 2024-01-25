<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$logger = new Monolog\Logger('pixel-canvas');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../log/app.log'));

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$router = new League\Route\Router;
$responseFactory = new Laminas\Diactoros\ResponseFactory();

// map a route
$router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
    // hacky but it works for now
    $response = new Laminas\Diactoros\Response\RedirectResponse('pixel-canvas.php');
    return $response;
});

// JSON API
$router->group('/api', function ($router) {

    $router->map('POST', '/', function (ServerRequestInterface $request): array {
        ray($request->getParsedBody()); // DEBUG

        // check if data is valid
        $data = $request->getParsedBody();
        if (!is_array($data)) {
            throw new UnexpectedValueException('Invalid image data. Expected array, got ' . gettype($data));
        }

        if (empty($data['cells']) || count($data['cells']) !== 4096) { // TODO expand for more canvas sizes
            throw new UnexpectedValueException('Invalid length of image data: ' . empty($data['cells'] ? '0' : count($data['cells'])));
        }

        // start parsing the color data from the canvas
        foreach ($data['cells'] as $position => $cell) {
            // pattern for rgb and rgba: rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3}),?\s?(\d{1,3})\)
            $colorMatches  = [];
            preg_match_all(
                '/rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3}),?\s?(\d{1,3})?\)/',
                $cell,
                $colorMatches
            );

            // parse the position to x,y
            $posY = floor(($position) / 64);
            $posX = ($position) % 64;

            // DEBUG
            ray($posX . ',' . $posY, $colorMatches);
            if ($position > 65) break;
        }

        return [
            'body' => $request->getParsedBody()
        ];
    });

    $router->map('GET', '/test', function (ServerRequestInterface $request): array {
        return [
            'success' => true
        ];
    });

    $router->map('GET', '/test2', 'Angorb\PixelCanvas\Api::test');
})->setStrategy(new League\Route\Strategy\JsonStrategy($responseFactory));


try {
    $response = $router->dispatch($request);

    // send the response to the browser
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
} catch (Exception $ex) {
    $logger->critical($ex->getMessage(), $ex->getTrace());
}
