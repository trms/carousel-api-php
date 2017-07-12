<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Server\API;
use TRMS\Carousel\Models\Traits\HasBlocks;
use TRMS\Carousel\Models\Traits\HasBackground;
use TRMS\Carousel\Models\Traits\HasUser;
use TRMS\Carousel\Models\Traits\HasZone;

class Template extends CarouselModel
{
  use HasBlocks;
  use HasBackground;
  use HasUser;
  use HasZone;

  public $ZoneID;
  public $Name = "My Awesome Template";
  public $UserID;
  public $IsPublic = true;

  protected $endpoint = 'templates';

  public function setProps(Array $props)
  {
    $this->setBlocksFromProps($props);
    parent::setProps($props);
  }
}