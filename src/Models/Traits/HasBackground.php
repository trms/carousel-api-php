<?php namespace TRMS\Carousel\Models\Traits;

use TRMS\Carousel\Models\Media;
use TRMS\Carousel\Exceptions\CarouselModelException;

trait HasBackground
{
  public $BackgroundID;

  public function setBackground(Media $background)
  {
    $this->setBelongsTo('Background', $background);
    return $this;
  }

  public function getBackground()
  {
    if($background = $this->getBelongsTo('Background',Media::class)){
      return $background;
    }
    throw new CarouselModelException("use setBackground method to set the background media relationship");
  }
}