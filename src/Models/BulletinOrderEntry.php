<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Exceptions\CarouselModelException;
use TRMS\Carousel\Models\BulletinOrderEntry;

class BulletinOrderEntry extends CarouselModel
{
  public function __construct(Array $props)
  {
    if(isset($props['id']) === false){
      throw new CarouselModelException('BulletinOrderEntry must have an id in its props. This value will always come from the Carousel Server and should not be instantiated by a consumer');
    }
    parent::__construct($props);
  }

  public function getSaveEndpoint()
  {
    throw new CarouselModelException('BulletinOrderEntry is not a saveable entity');
  }
}