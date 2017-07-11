<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Exceptions\CarouselModelException;

class User extends CarouselModel
{
  public $id, $FirstName, $LastName, $EmailAddress, $DefaultZoneID, $IsAdmin, $SystemRights, $ZoneRights;

  public function getSaveEndpoint(){
    if($this->id){
      return "users/$this->id";
    }
    throw new CarouselModelException("New users must be created through the FrontDoor user interface");
  }

  public function getSaveMethod(){
    if($this->id){
      return "put";
    }
    throw new CarouselModelException("New users must be created through the FrontDoor user interface");
  }
}