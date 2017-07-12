<?php namespace TRMS\Carousel\Models;

class Group extends CarouselModel
{
  public $id;

  public $ZoneID, $Description, $Buletins;

  protected $endpoint = 'groups';

}