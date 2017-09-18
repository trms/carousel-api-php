<?php namespace TRMS\Carousel\Requests;

use TRMS\Carousel\Exceptions\CarouselRequestException;
use TRMS\Carousel\Models\BulletinOrder;
use TRMS\Carousel\Requests\Traits\RequestTrait;

class BulletinOrderRequest extends ModelRequest
{

  public function __construct(Array $params=[])
  {
    $this->responseClassName = BulletinOrder::class;
    $this->baseUrl = 'orderentries';

    if(isset($params['ZoneID']) === false){
      throw new CarouselRequestException('You must specify a ZoneID when requesting Bulletin Order');
    }

    $this->queryParams = $params;
  }
}