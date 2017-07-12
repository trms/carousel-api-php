<?php

use CarouselTests\MockData\MockResponder;

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Template;
use TRMS\Carousel\Models\BulletinBlock;


use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselModelException;


class HasBlocksTraitTest extends PHPUnit_Framework_TestCase
{

  function test_you_instantiate_a_bulletin_with_blocks()
  {
    $props = json_decode(MockResponder::bulletin(),true);
    $bulletin = new Bulletin($props);

    $this->assertInstanceOf(BulletinBlock::class, $bulletin->Blocks[0]);
  }

  function test_you_instantiate_a_template_with_blocks()
  {
    $props = json_decode(MockResponder::template(),true);
    $template = new Template($props);

    $this->assertInstanceOf(BulletinBlock::class, $template->Blocks[0]);
  }

  function test_you_can_add_a_block_to_a_bulletin()
  {
    $bulletin = new Bulletin();

    $block = new BulletinBlock();
    $bulletin->addBlock($block);

    $this->assertInstanceOf(BulletinBlock::class, $bulletin->Blocks[0]);
  }

  function test_you_can_add_a_block_to_a_template()
  {
    $template = new Template();

    $block = new BulletinBlock();
    $template->addBlock($block);

    $this->assertInstanceOf(BulletinBlock::class, $template->Blocks[0]);
  }

  function test_you_can_remove_a_block_from_a_bulletin()
  {
    $bulletin = new Bulletin();

    $block1 = new BulletinBlock();
    $block2 = new BulletinBlock();

    $bulletin->Blocks = [$block1, $block2];

    $bulletin->removeBlock($block1);

    $this->assertEquals(1, count($bulletin->Blocks));
    $this->assertEquals($block2, $bulletin->Blocks[0]);
  }


}