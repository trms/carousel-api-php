<?php

use CarouselTests\MockData\MockResponder;

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Media;
use TRMS\Carousel\Models\Zone;

use TRMS\Carousel\Models\BulletinTag;
use TRMS\Carousel\Models\ZoneTag;
use TRMS\Carousel\Models\MediaTag;


use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselModelException;


class HasTagsTraitTest extends PHPUnit_Framework_TestCase
{

  function test_you_instantiate_a_bulletin_with_tags()
  {
    $props = json_decode(MockResponder::bulletin(),true);
    $bulletin = new Bulletin($props);

    $this->assertInstanceOf(BulletinTag::class, $bulletin->Tags[0]);
  }

  function test_you_instantiate_a_zone_with_tags()
  {
    $props = json_decode(MockResponder::zones(),true)[0];
    $zone = new Zone($props);

    $this->assertInstanceOf(ZoneTag::class, $zone->Tags[0]);
  }

  function test_you_instantiate_media_with_tags()
  {
    $props = json_decode(MockResponder::media(),true)[0];
    $media = new Media($props);

    $this->assertInstanceOf(MediaTag::class, $media->Tags[0]);
  }

  function test_you_can_add_a_tag_to_a_bulletin()
  {
    $bulletin = new Bulletin();

    $tag = new BulletinTag();
    $bulletin->addTag($tag);

    $this->assertInstanceOf(BulletinTag::class, $bulletin->Tags[0]);
  }

  function test_you_cannot_add_a_media_tag_to_a_bulletin()
  {
    $bulletin = new Bulletin();

    $tag = new MediaTag();
    try{
      $bulletin->addTag($tag);
    } catch (\TypeError $e){
      return;
    }

    $this->fail('an type error was not thrown');
  }

  function test_you_cannot_add_2_tags_with_the_same_id_to_a_bulletin()
  {
    $bulletin = new Bulletin();

    $tag = new BulletinTag(['id'=>'1']);
    $tag = new BulletinTag(['id'=>'1']);
    $bulletin->addTag($tag);

    $this->assertEquals(1, count($bulletin->Tags));
  }

  function test_you_can_remove_a_tag_from_a_bulletin()
  {
    $bulletin = new Bulletin();

    $tag1 = new BulletinTag(['id'=>'1']);
    $tag2 = new BulletinTag(['id'=>'2']);

    $bulletin->Tags = [$tag1, $tag2];

    $bulletin->removeTag($tag1);

    $this->assertEquals(1, count($bulletin->Tags));
    $this->assertEquals($tag2, $bulletin->Tags[0]);
  }


}