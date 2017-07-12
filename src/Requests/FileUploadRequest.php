<?php namespace TRMS\Carousel\Requests;

use TRMS\Carousel\Exceptions\CarouselRequestException;
use TRMS\Carousel\Models\CarouselModel;
use TRMS\Carousel\Requests\Traits\RequestTrait;

class FileUploadRequest
{
  use RequestTrait;

  public function __construct(string $responseClassName, Array $params)
  {
    $responseClass = new $responseClassName();

    if(get_parent_class($responseClass) !== CarouselModel::class){
      throw new CarouselRequestException('The classname passed in to the FileUploadRequest must be a child of CarouselModel');
    }

    if(isset($params['ZoneID'])){
      $this->params = $params;
      $this->responseClassName = $responseClassName;
      $this->baseUrl = $responseClass->getEndpoint();
    } else {
      throw new CarouselRequestException('The ZoneID parameter is required for file uploads');
    }

    $this->files = collect();
  }

  public function addFile($filepath)
  {
    try{
      $file = fopen($filepath,'rb');
      $this->files->push($file);
    } catch (\Exception $e){
      throw new CarouselRequestException('Adding file to upload request failed: '.$e->getMessage());
    }
    return $this;
  }

}