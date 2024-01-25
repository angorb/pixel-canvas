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

        // set the image name from the 'Name' field
        $imageName = empty($data['name']) ? time() : $data['name'];

        // start parsing the color data from the canvas
        $imageData = [];
        foreach ($data['cells'] as $position => $cell) {
            // pattern for rgb and rgba: rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3}),?\s?(\d{1,3})\)
            $colorMatches  = [];
            preg_match_all(
                '/rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3}),?\s?(\d{1,3})?\)/',
                $cell,
                $colorMatches,
                PREG_PATTERN_ORDER
            );

            // parse the position to x,y
            $posY = (int)floor(($position) / 64);
            $posX = ($position) % 64;

            $imageData[$position] = [
                'coordinates' => [
                    'x' => $posX,
                    'y' => $posY,
                ],
                'color' => [
                    'r' => $colorMatches[1][0], // TODO
                    'g' => $colorMatches[2][0],
                    'b' => $colorMatches[3][0],
                ],
            ];
        }

        ray($imageData);

        // create a new image
        $image = imagecreatetruecolor(64, 64);
        ray('GD image created'); // DEBUG
        $colorsList = [];
        foreach ($imageData as $pixel) {

            $colorString = (int)$pixel['color']['r'] . ':' .
                (int)$pixel['color']['g'] . ':' .
                (int)$pixel['color']['g'];

            if (!in_array($colorString, $colorsList)) {
                ray('Found a new color - ' . $colorString);
                $colorsList[] = $colorString;
            }

            $color = imagecolorallocate(
                $image,
                (int)$pixel['color']['r'],
                (int)$pixel['color']['g'],
                (int)$pixel['color']['b'],
            );
            imagesetpixel($image, $pixel['coordinates']['x'], $pixel['coordinates']['y'], $color);
        }

        ray('image data set: ' . count($colorsList) . ' colors found', $colorsList); // DEBUG

        $outputFile = __DIR__ . '/../export/' . $imageName . '.gif';
        imagegif($image, $outputFile);
        imagedestroy($image);

        ray($outputFile); // DEBUG

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
