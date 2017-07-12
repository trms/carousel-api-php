<?php namespace TRMS\Carousel\Models;

class BulletinBlock extends CarouselModel
{
  public function getSaveEndpoint()
  {
    throw new CarouselModelException('Bulletin Blocks cannot be directly saved');
  }
}