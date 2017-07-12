<?php

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Media;
use TRMS\Carousel\Models\User;
use TRMS\Carousel\Models\Template;

use TRMS\Carousel\Server\API;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class HasUserTraitTest extends PHPUnit_Framework_TestCase
{
  function test_you_can_add_a_user_to_a_bulletin()
  {
    $bulletin = new Bulletin();
    $user = new User(['id'=>'1']);
    $bulletin->setUser($user);

    $this->assertEquals($user->id, $bulletin->UserID);
  }

  function test_you_can_add_a_user_to_media()
  {
    $media = new Media();
    $user = new User(['id'=>'1']);
    $media->setUser($user);

    $this->assertEquals($user->id, $media->UserID);
  }

  function test_you_can_add_a_user_to_a_template()
  {
    $template = new Template();
    $user = new User(['id'=>'1']);
    $template->setUser($user);

    $this->assertEquals($user->id, $template->UserID);
  }

  function test_if_the_user_object_has_not_been_resolved_an_api_request_will_be_made()
  {
    $mock = new MockHandler([
      new Response(200,[],json_encode(['id'=>'12'])),
    ]);
    $handler = HandlerStack::create($mock);

    $api = new API();
    $api->addMockHandler($handler);

    $bulletin = new Bulletin(['UserID'=>'12']);
    $bulletin->setApi($api);
    $user = $bulletin->getUser();

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals('12',$user->id);
  }
}