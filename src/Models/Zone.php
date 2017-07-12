<?php namespace TRMS\Carousel\Models;

use TRMS\Carousel\Models\Traits\HasTags;
use TRMS\Carousel\Server\API;
class Zone extends CarouselModel
{
  use HasTags {
    addTag as protected traitAddTag;
    removeTag as protected traitRemoveTag;
  }
  public function addTag(ZoneTag $tag)
  {
    return $this->traitAddTag($tag);
  }
  public function removeTag(ZoneTag $tag)
  {
    return $this->traitRemoveTag($tag);
  }

  public $id, $ZoneName, $GraphicsWidth = 600, $GraphicsHeight = 800, $DaylightSavings = true, $ZoneType = 'Bulletin', $Description = 'My Awesome Zone', $TimezoneID, $Tags = [],$Pacing = 10, $ForceMonitorOn=false;

  protected $endpoint = 'zones';

  public function setProps(Array $props)
  {
    $this->setTagsFromProps($props,'TRMS\Carousel\Models\ZoneTag');
    parent::setProps($props);
  }
}