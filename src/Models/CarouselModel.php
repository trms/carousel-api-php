<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Server\API;

abstract class CarouselModel implements SaveableInterface
{
  public function __construct(Array $props = [])
  {
    foreach ($props as $key => $value) {
      $this->$key = $value;
    }
  }

  public function getSaveMethod(){
    if($this->id){
      return "put";
    }
    return "post";
  }

  public function getBelongsTo($relationship)
  {
    $relationshipObject = $relationship."Object";
    $relationshipID = $relationship."ID";
    if(!$this->$relationshipObject && isset($this->api) && $this->$relationshipID){
      return $this->api->getGroup($this->$relationshipID);
    } else if($this->$relationshipObject){
      return $this->$relationshipObject;
    }
    return;
  }

  public function toArray()
  {
    $public_props = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);

    $properties = collect($public_props)
      ->pluck('name')
      ->reject(function($prop){
        return is_object($this->$prop);
      })
      ->keyBy(function($propName){
        return $propName;
      })
      ->map(function($prop){
        return $this->$prop;
      });

    return $properties;
  }

  public function setApi(API $api){
    $this->api = $api;
    return $this;
  }
}