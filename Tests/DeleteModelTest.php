<?php

use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselAPIException;
use TRMS\Carousel\Models\Bulletin;

use CarouselTests\MockData\MockResponder;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class DeleteModelTest extends PHPUnit_Framework_TestCase
{
  function test_you_can_delete_a_bulletin()
  {
    $mock = new MockHandler([
      new Response(204)
    ]);
    $handler = HandlerStack::create($mock);

    $mockResponder = new MockResponder;
    $bulletinProps = json_decode($mockResponder->bulletin(),true);
    $bulletin = new Bulletin($bulletinProps);

    $server = new API();
    $server
      ->addMockHandler($handler)
      ->connect('server','username','password')
      ->delete($bulletin);

    $this->assertTrue($bulletin->IsDeleted);
    $this->assertEquals("server/carouselapi/v1/bulletins/$bulletin->id", (string) $mock->getLastRequest()->getUri());
    $this->assertEquals('DELETE', (string) $mock->getLastRequest()->getMethod());
  }

  function test_failed_deletions_throw_an_exception()
  {
    $mock = new MockHandler([
      new Response(500),
      new Response(404),
      new Response(401)
    ]);
    $handler = HandlerStack::create($mock);

    $mockResponder = new MockResponder;
    $bulletinProps = json_decode($mockResponder->bulletin(),true);
    $bulletin = new Bulletin($bulletinProps);

    $server = new API();
    $server
      ->addMockHandler($handler)
      ->connect('server','username','password');


    try{
      $server->delete($bulletin);
    } catch (CarouselAPIException $e){
      $this->assertTrue(true,"500 exception caught");
    }

    try{
      $server->delete($bulletin);
    } catch (CarouselAPIException $e){
      $this->assertTrue(true,"404 exception caught");
    }

    try{
      $server->delete($bulletin);
    } catch (CarouselAPIException $e){
      $this->assertTrue(true,"401 exception caught");
      return;
    }

    $this->fail('the exceptions did not throw');
  }
}

