<?php namespace TRMS\Carousel\Requests\Traits;

trait RequestTrait
{
  public $params;
  public $files;
  public $queryParams;
  public $id;
  protected $baseUrl = "/";
  protected $responseClassName = '';

  public function url()
  {
    if($this->id){
      return $this->baseUrl."/".$this->id;
    } else {
      return $this->baseUrl;
    }
  }

  public function queryParams(){
    return $this->queryParams;
  }

  public function params(){
    return $this->params;
  }

  public function getResponseClassName()
  {
    return $this->responseClassName;
  }
}