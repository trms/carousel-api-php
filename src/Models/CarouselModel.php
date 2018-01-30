<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Server\API;
use TRMS\Carousel\Requests\ModelRequest;
use TRMS\Carousel\Exceptions\CarouselModelException;

abstract class CarouselModel implements SaveableInterface
{

  protected $endpoint = 'set $endpoint on the child';
  protected $api;

  public function __construct(Array $props = [],API $api=null)
  {
    if($api){
      $this->setApi($api);
    }
    $this->setProps($props);

  }

  public function setProps(Array $props)
  {
    foreach ($props as $key => $value) {
      if(is_array($value) === false){
        $this->$key = $value;
      }
    }
  }

  public function save()
  {
    if(!$this->api || !$this->id){
      throw new CarouselModelException("You must use the API's save() method to save new models");
    }
    $this->api->save($this);
  }

  public function delete()
  {
    if(!$this->api || !$this->id){
      throw new CarouselModelException("why would you try to delete a model that has never been persisted?");
    }
    $this->api->delete($this);
  }

  public function getSaveMethod(){
    if(isset($this->id)){
      return "put";
    }
    return "post";
  }

  public function getSaveEndpoint()
  {
    if(isset($this->id)){
      return "$this->endpoint/$this->id";
    }
    return $this->endpoint;
  }

  public function getEndpoint()
  {
    return $this->endpoint;
  }

  public function getBelongsTo(string $relationship, string $relationshipClass='')
  {
    $relationshipObject = $relationship."Object";
    $relationshipID = $relationship."ID";

    if(!$relationshipClass){
      $relationshipClass = "TRMS\\Carousel\\Models\\$relationship";
    }
    if(isset($this->$relationshipObject) === false && $this->getApi() && $this->$relationshipID){
      return $this->getApi()->get(new ModelRequest($relationshipClass,['id'=>$this->$relationshipID]));
    } else if(isset($this->$relationshipObject)){
      return $this->$relationshipObject;
    }
    return;
  }

  public function setBelongsTo(string $relationship, CarouselModel $object)
  {
    $relationshipObject = $relationship."Object";
    $relationshipID = $relationship."ID";

    $this->$relationshipObject = $object;
    $this->$relationshipID = $object->id;
  }

  public function toArray()
  {
    $public_props = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);

    $properties = collect($public_props)
      ->pluck('name')
      ->reject(function($propName){
        return is_object($this->$propName);
      })
      ->keyBy(function($propName){
        return $propName;
      })
      ->map(function($propName){
        return $this->$propName;
      })
      ->map(function($property){
        return $this->flattenRelationships($property);
      })
      ->reject(function($property){
        return is_null($property);
      })
      ->toArray();

    return $properties;
  }

  public function __toString()
  {
    return json_encode($this->toArray(),true);
  }

  private function flattenRelationships($relationship)
  {
    if(!is_array($relationship) && !is_object($relationship)){
      return $relationship;
    }

    if(is_array($relationship)){
      return array_map(function($r){
        return $this->flattenRelationships($r);
      },$relationship);
    }

    if(is_object($relationship)){
      return $relationship->toArray();
    }
  }

  public function setApi(API $api)
  {
    $this->api = $api;
    return $this;
  }

  public function getApi()
  {
    return $this->api;
  }
}