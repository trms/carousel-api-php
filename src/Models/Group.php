<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Models\Traits\HasZone;

class Group extends CarouselModel
{
  use HasZone;

  public $id;

  public $ZoneID, $Description, $Buletins;

  protected $endpoint = 'groups';

}