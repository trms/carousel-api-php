<?php namespace TRMS\Carousel\Models;

class Group extends CarouselModel
{
  public $id;

  public $ZoneID, $Description, $Buletins;

  public function getSaveEndpoint(){
    if($this->id){
      return "groups/$this->id";
    }
    return "groups";
  }

}