<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Exceptions\CarouselModelException;
use TRMS\Carousel\Models\BulletinOrderEntry;

class BulletinOrder extends CarouselModel
{
  protected $endpoint = 'orderentries';

  public function __construct(string $ZoneID, Array $props)
  {
    $this->ZoneID = $ZoneID;
    $this->setOrderEntries($props);
  }

  private function setOrderEntries($props)
  {
    $this->OrderEntries = collect($props)->map(function($entry){
      if(is_array($entry) === false){
        throw new CarouselModelException('The properties passed to the the BulletinOrder constructor must be an associative array of OrderEntry properties.  This value almost always comes from the Carousel Server and should not be instantiated by a consumer.');
      }
      return new BulletinOrderEntry($entry);
    })->toArray();
  }
}