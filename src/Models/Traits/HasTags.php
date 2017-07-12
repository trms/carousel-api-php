<?php namespace TRMS\Carousel\Models\Traits;

use TRMS\Carousel\Models\Tag;

trait HasTags
{

  public $Tags = [];

  private function setTagsFromProps(Array $props, string $tagClassName)
  {
    if(isset($props['Tags'])){
      foreach ($props['Tags'] as $tagprops) {
        $this->addTag(new $tagClassName($tagprops));
      }
    }
  }

  public function addTag(Tag $tag)
  {
    $found = collect($this->Tags)
      ->filter(function($t) use ($tag){
        return $t->id === $tag->id;
      })
      ->first();

    if(!$found){
      array_push($this->Tags, $tag);
    }

    return $this;
  }

  public function removeTag(Tag $tag)
  {
    $this->Tags = collect($this->Tags)
      ->reject(function($t) use ($tag){
        return $t->id === $tag->id;
      })
      ->values()
      ->toArray();
    return $this;
  }
}