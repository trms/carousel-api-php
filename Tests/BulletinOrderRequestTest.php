<?php

use TRMS\Carousel\Server\API;

use TRMS\Carousel\Exceptions\CarouselAPIException;
use TRMS\Carousel\Exceptions\CarouselRequestException;
use TRMS\Carousel\Exceptions\CarouselModelException;

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Group;

use TRMS\Carousel\Requests\BulletinOrderRequest;
use TRMS\Carousel\Models\BulletinOrder;
use TRMS\Carousel\Models\BulletinOrderEntry;

use CarouselTests\MockData\MockResponder;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class BulletinOrderRequestTest extends PHPUnit_Framework_TestCase
{
  function setup()
  {
    $mockResponder = new MockResponder;
    $this->mock = new MockHandler([
      new Response(200,[],$mockResponder->orderEntries()),
      new Response(200,[],$mockResponder->orderEntries()),
    ]);
    $this->handler = HandlerStack::create($this->mock);
  }

  function test_you_can_get_order_entries_for_a_zone()
  {
    $request = new BulletinOrderRequest(['ZoneID'=>1]);
    $server = new API();
    $server
      ->addMockHandler($this->handler)
      ->connect('server','username','password');

    $bulletinOrder = $server->get($request);

    $this->assertEquals('server/carouselapi/v1/orderentries?ZoneID=1', (string) $this->mock->getLastRequest()->getUri());
    $this->assertEquals('GET', (string) $this->mock->getLastRequest()->getMethod());
    $this->assertInstanceOf(BulletinOrder::class, $bulletinOrder);
    $this->assertEquals(1, $bulletinOrder->ZoneID);
    $this->assertEquals(true, is_array($bulletinOrder->OrderEntries));
    $this->assertInstanceOf(BulletinOrderEntry::class, $bulletinOrder->OrderEntries[0]);
  }

  function test_you_must_supply_a_zone_id_when_requesting_order_entries_or_have_an_exception_thrown()
  {
    try{
      $request = new BulletinOrderRequest([]);
    } catch (CarouselRequestException $e){
      return;
    }
    $this->fail('The exception was not thrown');
  }

  function test_you_can_save_the_order_back_to_the_server()
  {
    $request = new BulletinOrderRequest(['ZoneID'=>1]);
    $server = new API();
    $server
      ->addMockHandler($this->handler)
      ->connect('server','username','password');

    $bulletinOrder = $server->get($request);

    $this->assertInstanceOf(BulletinOrder::class, $bulletinOrder);

    $server->save($bulletinOrder);

    $this->assertEquals('server/carouselapi/v1/orderentries', (string) $this->mock->getLastRequest()->getUri());
    $this->assertEquals('POST', (string) $this->mock->getLastRequest()->getMethod());
    $this->assertArraySubset($bulletinOrder->toArray(), json_decode((string) $this->mock->getLastRequest()->getBody(),true));
  }

  function test_trying_to_save_an_order_entry_will_throw_an_exception()
  {
    $server = new API();
    $server
      ->addMockHandler($this->handler)
      ->connect('server','username','password');

    $orderEntry = new BulletinOrderEntry(['id'=>'1']);

    try{
      $server->save($orderEntry);
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('The exception was not thrown');
  }

  function test_trying_to_create_a_bulletin_order_without_OrderEntries_on_the_props_will_throw_an_exception()
  {
    try{
      $fail = new BulletinOrder('1',['prop'=>'not an array']);
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('an exception was not thrown');
  }

  function test_trying_to_create_a_bulletin_order_without_an_id_on_each_entry_will_throw_an_exception()
  {
    try{
      $fail = new BulletinOrder('1',[['foo'=>'I dont have an id']]);
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('an exception was not thrown');
  }
}