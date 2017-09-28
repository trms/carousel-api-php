<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Exceptions\CarouselModelException;

class BulletinBlock extends CarouselModel
{
  public $BlockType = 'Text';
  public $Name = 'My Awesome Block';

  public function getSaveEndpoint()
  {
    throw new CarouselModelException('Bulletin Blocks cannot be directly saved but are part of a Bulletin or Template');
  }

  public function setMedia(Media $media)
  {
    if($media->Type === 'Sound' || $media->Type === 'Background'){
      throw new CarouselModelException('Sound and Background Media cannot be added to a block.');
    }
    $this->setBelongsTo('Media', $media);
    $this->BlockType = $media->Type;
  }

  public function getMedia()
  {
    if($this->BlockType !== 'Picture' && $this->BlockType !== 'Video'){
      return null;
    }
    if($media = $this->getBelongsTo('Media',Media::class)){
      return $media;
    }
    throw new CarouselModelException("use setMedia method to set the block's media relationship");
  }
}