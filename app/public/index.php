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
        return [
            'body' => $request->getParsedBody()
        ];
    });

    $router->map('GET', '/test', function (ServerRequestInterface $request): array {
        return [
            'success' => true
        ];
    });
    $router->map('POST', '/save', 'Angorb\PixelCanvas\Api::save');
    $router->map('GET', '/test2', 'Angorb\PixelCanvas\Api::test');
})->setStrategy(new League\Route\Strategy\JsonStrategy($responseFactory));


try {
    $response = $router->dispatch($request);

    // send the response to the browser
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
} catch (Exception $ex) {
    $logger->critical($ex->getMessage(), $ex->getTrace());
}
