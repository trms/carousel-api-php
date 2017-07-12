<?php

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Media;
use TRMS\Carousel\Models\Template;

use TRMS\Carousel\Server\API;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class HasBackgroundTraitTest extends PHPUnit_Framework_TestCase
{
  function test_you_can_add_a_background_to_a_bulletin()
  {
    $bulletin = new Bulletin();
    $background = new Media(['id'=>'1']);
    $bulletin->setBackground($background);

    $this->assertEquals($background->id, $bulletin->BackgroundID);
  }

  function test_you_can_add_a_background_to_a_template()
  {
    $template = new Template();
    $background = new Media(['id'=>'1']);
    $template->setBackground($background);

    $this->assertEquals($background->id, $template->BackgroundID);
  }

  function test_if_the_background_object_has_not_been_resolved_an_api_request_will_be_made()
  {
    $mock = new MockHandler([
      new Response(200,[],json_encode(['id'=>'12'])),
    ]);
    $handler = HandlerStack::create($mock);

    $api = new API();
    $api->addMockHandler($handler);

    $bulletin = new Bulletin(['BackgroundID'=>'12']);
    $bulletin->setApi($api);
    $background = $bulletin->getBackground();

    $this->assertInstanceOf(Media::class, $background);
    $this->assertEquals('12',$background->id);
  }
}