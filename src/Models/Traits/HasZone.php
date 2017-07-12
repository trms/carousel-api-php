<?php namespace TRMS\Carousel\Models\Traits;

use TRMS\Carousel\Models\Zone;
use TRMS\Carousel\Exceptions\CarouselModelException;

trait HasZone
{
  public $ZoneID;

  public function setZone(Zone $zone)
  {
    $this->setBelongsTo('Zone', $zone);
    return $this;
  }

  public function getZone()
  {
    if($zone = $this->getBelongsTo('Zone')){
      return $zone;
    }
    throw new CarouselModelException("use setZone method to set the zone relationship");
  }
}