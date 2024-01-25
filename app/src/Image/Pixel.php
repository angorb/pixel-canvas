<?php

namespace Angorb\PixelCanvas\Image;

class Pixel
{
  // coordinates
  private int $x;
  private int $y;
  // colors
  private int $red;
  private int $green;
  private int $blue;

  public function getRgbString(): string
  {
    return "rgb({$this->red}, {$this->green}, {$this->blue})";
  }

  /**
   * Get the value of x
   */
  public function getX(): int
  {
    return $this->x;
  }

  /**
   * Set the value of x
   *
   * @return self
   */
  public function setX(int $x): self
  {
    $this->x = $x;

    return $this;
  }

  /**
   * Get the value of y
   */
  public function getY(): int
  {
    return $this->y;
  }

  /**
   * Set the value of y
   *
   * @return self
   */
  public function setY(int $y): self
  {
    $this->y = $y;

    return $this;
  }

  /**
   * Get the value of red
   */
  public function getRed(): int
  {
    return $this->red;
  }

  /**
   * Set the value of red
   *
   * @return self
   */
  public function setRed(int $red): self
  {
    $this->red = $red;

    return $this;
  }

  /**
   * Get the value of green
   */
  public function getGreen(): int
  {
    return $this->green;
  }

  /**
   * Set the value of green
   *
   * @return self
   */
  public function setGreen(int $green): self
  {
    $this->green = $green;

    return $this;
  }

  /**
   * Get the value of blue
   */
  public function getBlue(): int
  {
    return $this->blue;
  }

  /**
   * Set the value of blue
   *
   * @return self
   */
  public function setBlue(int $blue): self
  {
    $this->blue = $blue;

    return $this;
  }
}
