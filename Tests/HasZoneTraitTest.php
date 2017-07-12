<?php

use TRMS\Carousel\Models\Template;
use TRMS\Carousel\Models\Zone;
use TRMS\Carousel\Models\Media;

use TRMS\Carousel\Server\API;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class HasZoneTraitTest extends PHPUnit_Framework_TestCase
{

  function test_you_can_add_a_zone_to_a_template()
  {
    $template = new Template();
    $zone = new Zone(['id'=>'1']);
    $template->setZone($zone);

    $this->assertEquals($zone->id, $template->ZoneID);
  }

  function test_you_can_add_a_zone_to_media()
  {
    $media = new Media();
    $zone = new Zone(['id'=>'1']);
    $media->setZone($zone);

    $this->assertEquals($zone->id, $media->ZoneID);
  }

  function test_if_the_zone_object_has_not_been_resolved_an_api_request_will_be_made()
  {
    $mock = new MockHandler([
      new Response(200,[],json_encode(['id'=>'12'])),
    ]);
    $handler = HandlerStack::create($mock);

    $api = new API();
    $api->addMockHandler($handler);

    $template = new Template(['ZoneID'=>'12']);
    $template->setApi($api);
    $zone = $template->getZone();

    $this->assertInstanceOf(Zone::class, $zone);
    $this->assertEquals('12',$zone->id);
  }
}