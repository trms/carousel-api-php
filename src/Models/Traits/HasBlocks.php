<?php namespace TRMS\Carousel\Models\Traits;

use TRMS\Carousel\Models\BulletinBlock;

trait HasBlocks
{

  public $Blocks = [];

  private function setBlocksFromProps($props)
  {
    if(isset($props['Blocks'])){
      foreach ($props['Blocks'] as $blockprops) {
        $this->addBlock(new BulletinBlock($blockprops));
      }
    }
  }

  public function addBlock(BulletinBlock $block)
  {
    array_push($this->Blocks, $block);
    return $this;
  }

  public function removeBlock(BulletinBlock $block)
  {
    $this->Blocks = collect($this->Blocks)
      ->reject(function($b) use ($block){
        return $b === $block;
      })
      ->values()
      ->toArray();
    return $this;
  }
}