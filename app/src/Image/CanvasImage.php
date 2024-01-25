<?php

namespace Angorb\PixelCanvas\Image;

use GdImage;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class CanvasImage
{
  // config
  private string $path = __DIR__ . '/../../export/';
  // properties
  private string $title;
  private array $data;
  private array $colors;
  private GdImage $image;

  private function __construct()
  {
    $this->colors = [];
    // create a new image
    $this->image = imagecreatetruecolor(64, 64);
  }

  public function __destruct()
  {
    imagedestroy($this->image);
  }

  public function getColorDepth(): int
  {
    return count($this->colors);
  }

  public function save(string $format = 'gif')
  {
    $filename = $this->path . $this->title . '.' . $format;
    switch ($format) {
      case 'bmp':
        imagebmp($this->image, $filename);
        break;
      case 'gif':
        imagegif($this->image, $filename);
        break;
      case 'jpeg':
      case 'jpg':
        imagejpeg($this->image, $filename);
        break;
      case 'png':
        imagepng($this->image, $filename);
        break;
      default:
        throw new UnexpectedValueException('Unknown or invalid file type: .' . $format);
    }
  }

  public static function createFromRequest(ServerRequestInterface $request): self
  {
    $canvasImage = new self();

    // check if data is valid
    $data = $request->getParsedBody();
    if (!is_array($data)) {
      throw new \UnexpectedValueException('Invalid image data. Expected array, got ' . gettype($data));
    }

    if (empty($data['cells']) || count($data['cells']) !== 4096) { // TODO expand for more canvas sizes
      throw new \UnexpectedValueException('Invalid length of image data: ' . empty($data['cells'] ? '0' : count($data['cells'])));
    }

    // set the image name from the 'Name' field
    $canvasImage->title = empty($data['name']) ? time() : $data['name'];

    // start parsing the color data from the canvas
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

      $canvasImage->data[$position] = (new Pixel())
        ->setX($posX)
        ->setY($posY)
        ->setRed((int)$colorMatches[1][0])
        ->setGreen((int)$colorMatches[2][0])
        ->setBlue((int)$colorMatches[3][0]);
    }

    // create the GD Image
    foreach ($canvasImage->data as $pixel) {
      if (!in_array($pixel->getRgbString(), $canvasImage->colors)) {
        ray('Found a new color - ' . $pixel->getRgbString()); // DEBUG
        $canvasImage->colors[] = $pixel->getRgbString();
      }

      // TODO use already allocated colors instead of allocating for every pixel
      $color = imagecolorallocate(
        $canvasImage->image,
        $pixel->getRed(),
        $pixel->getGreen(),
        $pixel->getBlue()
      );

      // write out the image, pixel by pixel
      imagesetpixel($canvasImage->image, $pixel->getX(), $pixel->getY(), $color);
    }

    return $canvasImage;
  }
}
