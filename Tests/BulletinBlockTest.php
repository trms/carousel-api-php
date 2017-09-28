<?php
use TRMS\Carousel\Models\BulletinBlock;
use TRMS\Carousel\Models\Media;
use TRMS\Carousel\Exceptions\CarouselModelException;

use TRMS\Carousel\Server\API;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class BulletinBlockTest extends PHPUnit_Framework_TestCase
{
  function test_you_can_set_a_picture_media_relationship_and_it_will_set_the_block_params_accordingly()
  {
    $block = new BulletinBlock();
    $picture = new Media(['id'=>'1','Type'=>'Picture']);
    $video = new Media(['id'=>'2','Type'=>'Video']);

    $block->setMedia($picture);

    $this->assertEquals($picture->id, $block->MediaID);
    $this->assertEquals($picture, $block->MediaObject);
    $this->assertEquals('Picture',$block->BlockType);

    $block->setMedia($video);

    $this->assertEquals($video->id, $block->MediaID);
    $this->assertEquals($video, $block->MediaObject);
    $this->assertEquals('Video',$block->BlockType);
  }

  function test_a_Sound_media_cannot_be_added_to_a_block_and_throws_an_exception()
  {
    $block = new BulletinBlock();
    $sound = new Media(['id'=>'1','Type'=>'Sound']);

    try{
      $block->setMedia($sound);
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('the exception was not thrown');
  }

  function test_a_Background_media_cannot_be_added_to_a_block_and_throws_an_exception()
  {
    $block = new BulletinBlock();
    $background = new Media(['id'=>'1','Type'=>'Background']);

    try{
      $block->setMedia($background);
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('the exception was not thrown');
  }

  function test_you_can_get_the_background_media_relationship()
  {
    $block = new BulletinBlock();
    $picture = new Media(['id'=>'1','Type'=>'Picture']);

    $block->setMedia($picture);
    $media = $block->getMedia();

    $this->assertEquals($picture,$media);
  }

  function test_if_the_media_object_has_not_been_resolved_an_api_request_will_be_made()
  {
    $mock = new MockHandler([
      new Response(200,[],json_encode(['id'=>'12'])),
    ]);
    $handler = HandlerStack::create($mock);

    $api = new API();
    $api->addMockHandler($handler);

    $block = new BulletinBlock(['BlockType'=>'Picture','MediaID'=>'12']);
    $block->setApi($api);
    $media = $block->getMedia();

    $this->assertInstanceOf(Media::class, $media);
    $this->assertEquals('12',$media->id);
  }

  function test_using_getMedia_on_a_non_media_using_block_will_return_null()
  {
    $block = new BulletinBlock();
    $block->BlockType === 'Text';

    $media = $block->getMedia();

    $this->assertEquals(null, $media);

    $block->BlockType === 'Rectangle';

    $this->assertEquals(null, $media);
  }
}