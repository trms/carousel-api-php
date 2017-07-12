<?php

use TRMS\Carousel\Models\Template;
use TRMS\Carousel\Models\BulletinBlock;

class TemplateTest extends PHPUnit_Framework_TestCase
{
  function test_template_blocks_serialize_correctly()
  {
    $template = new Template();

    $block1 = new BulletinBlock(['BlockType'=>'Text','Text'=>'foobarbaz']);
    $block2 = new BulletinBlock(['BlockType'=>'Rectangle']);

    $template->Blocks = [$block1, $block2];

    $this->assertEquals(['BlockType'=>'Text','Text'=>'foobarbaz'],  $template->toArray()['Blocks'][0]);
    $this->assertEquals(['BlockType'=>'Rectangle'],  $template->toArray()['Blocks'][1]);
  }

}