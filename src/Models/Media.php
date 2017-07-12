<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Models\Traits\HasUser;
use TRMS\Carousel\Models\Traits\HasZone;
use TRMS\Carousel\Models\Traits\HasTags;

use TRMS\Carousel\Server\API;

class Media extends CarouselModel
{
  use HasUser;
  use HasZone;
  use HasTags {
    addTag as protected traitAddTag;
    removeTag as protected traitRemoveTag;
  }
  public function addTag(MediaTag $tag)
  {
    return $this->traitAddTag($tag);
  }
  public function removeTag(MediaTag $tag)
  {
    return $this->traitRemoveTag($tag);
  }

  public $id, $Type, $IsDeleted = false, $IsPublic = true,$Name="My Awesome Media";

  protected $endpoint = 'media';

  public function setProps(Array $props)
  {
    $this->setTagsFromProps($props,'TRMS\Carousel\Models\MediaTag');
    parent::setProps($props);
  }
}