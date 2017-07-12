<?php namespace TRMS\Carousel\Requests;

use TRMS\Carousel\Exceptions\CarouselRequestException;
use TRMS\Carousel\Models\CarouselModel;
use TRMS\Carousel\Requests\Traits\RequestTrait;

class ModelRequest
{
  use RequestTrait;

  public function __construct(string $responseClassName, Array $params=[])
  {
    $responseClass = new $responseClassName();

    if(get_parent_class($responseClass) !== CarouselModel::class){
      throw new CarouselRequestException('The classname passed in to the ModelRequest must be a child of CarouselModel');
    }

    $this->responseClassName = $responseClassName;
    $this->baseUrl = $responseClass->getEndpoint();

    if(isset($params['id'])){
      $this->id = $params['id'];
    } else {
      $this->queryParams = $params;
    }

    if(isset($params['id']) && count($params) > 1){
      throw new CarouselRequestException('Having additional parameters with the id is not supported');
    }

  }
}