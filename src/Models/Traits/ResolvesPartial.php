<?php namespace TRMS\Carousel\Models\Traits;

use TRMS\Carousel\Exceptions\CarouselModelException;
use TRMS\Carousel\Requests\ModelRequest;
use TRMS\Carousel\Models\Bulletin;

trait ResolvesPartial
{
  public function resolvePartial()
  {
    if(!$this->PartialBulletin){
      return $this;
    }
    if(!$this->api){
      throw new CarouselModelException('Calling resolvePartial on unsaved bulletins is not allowed. Use the API save method to save this bulletin on the server.');
    }
    $request = new ModelRequest(Bulletin::class, ['id'=>$this->id]);
    $result = $this->api->get($request);
    $this->applyPartialProps($result);
    $this->PartialBulletin = false;
    return $this;
  }

  private function applyPartialProps($serverResponse)
  {
    $props = collect($serverResponse->toArray())->filter(function($value, $key){
      return empty($this->$key) && $this->$key !== false && $this->$key !== 0;
    })->toArray();

    $this->setProps($props);
    $this->setBlocksFromProps($serverResponse->toArray());
  }
}