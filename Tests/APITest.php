<?php

use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselAPIException;
use TRMS\Carousel\Models\User;
use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Group;

use TRMS\Carousel\Requests\BulletinRequest;
use TRMS\Carousel\Requests\GroupRequest;

use TRMS\Carousel\Requests\ModelRequest;

use CarouselTests\MockData\MockResponder;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class APITest extends PHPUnit_Framework_TestCase
{

  function test_you_can_connect_to_a_server()
  {
    $mock = new MockHandler([
      new Response(200),
      new Response(200),
    ]);
    $handler = HandlerStack::create($mock);

    $server = new API();

    $server->connect('foo','username','password');
    $server->client->request('GET','',['handler'=>$handler]);
    $this->assertEquals('foo/carouselapi/v1/', (string) $mock->getLastRequest()->getUri());

    $server->connect('bar','username','password');
    $server->client->request('GET','',['handler'=>$handler]);
    $this->assertEquals('bar/carouselapi/v1/', (string) $mock->getLastRequest()->getUri());
  }


  function test_the_server_will_throw_an_exception_if_the_endpoint_404s()
  {
    $mock = new MockHandler([
      new Response(404),
    ]);
    $handler = HandlerStack::create($mock);

    $server = new API();
    $server
      ->addMockHandler($handler)
      ->connect('my_server','username','password');

    try{
      $server->whoAmI();
    } catch(CarouselAPIException $e) {
      return;
    }

    $this->fail('the server did not throw an exception');
  }

  function test_the_class_will_connect_to_a_carousel_server_and_get_the_current_user()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],$mockResponder->whoAmI()),
      new Response(200,[],$mockResponder->user()),
    ]);
    $handler = HandlerStack::create($mock);

    $server = new API();
    $server
      ->addMockHandler($handler)
      ->connect('my_server','username','password');

    $loggedInUser = $server->whoAmI();

    $this->assertInstanceOf(User::class, $loggedInUser);
    $this->assertEquals('admin', $loggedInUser->id);
    $this->assertEquals('Seth', $loggedInUser->FirstName);
    $this->assertArraySubset(['id'=>'admin'],$loggedInUser->toArray());
  }

  function test_you_can_get_a_list_of_bulletins()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],$mockResponder->bulletins()),
      new Response(200,[],json_encode(['id'=>'2'])),
    ]);
    $handler = HandlerStack::create($mock);

    $server = new API();
    $request = new ModelRequest(Bulletin::class);
    $bulletins = $server
      ->addMockHandler($handler)
      ->connect('my_server','username','password')
      ->get($request);

    $group = $bulletins[0]->getGroup();

    $this->assertInstanceOf(Bulletin::class, $bulletins[0]);
    $this->assertEquals(1, $bulletins[0]->id);
    $this->assertArraySubset(['id'=>1],$bulletins[0]->toArray());
    $this->assertInstanceOf(Group::class, $group);
  }

  function test_you_can_get_a_single_bulletin_by_id()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],$mockResponder->bulletin()),
      new Response(200,[],json_encode(['id'=>'2'])),
    ]);
    $handler = HandlerStack::create($mock);

    $server = new API();
    $request = new ModelRequest(Bulletin::class,['id'=>'1']);
    $bulletin = $server
      ->addMockHandler($handler)
      ->connect('my_server','username','password')
      ->get($request);

    $group = $bulletin->getGroup();

    $this->assertInstanceOf(Bulletin::class, $bulletin);
    $this->assertEquals(1, $bulletin->id);
    $this->assertArraySubset(['id'=>1],$bulletin->toArray());
    $this->assertInstanceOf(Group::class, $group);
  }

  function test_you_can_save_an_existing_bulletin()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],$mockResponder->bulletin()),
    ]);
    $handler = HandlerStack::create($mock);

    $bulletin = new Bulletin(['id'=>'1']);
    $server = new API();

    $response = $server
      ->addMockHandler($handler)
      ->connect('server','username','password')
      ->save($bulletin);

    $this->assertEquals('server/carouselapi/v1/bulletins/1', (string) $mock->getLastRequest()->getUri());
    $this->assertEquals('PUT', (string) $mock->getLastRequest()->getMethod());
    $this->assertInstanceOf(Bulletin::class, $response);
  }

  function test_you_can_save_a_new_bulletin()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],$mockResponder->bulletin()),
    ]);
    $handler = HandlerStack::create($mock);

    $bulletin = new Bulletin();
    $server = new API();

    $response = $server
      ->addMockHandler($handler)
      ->connect('server','username','password')
      ->save($bulletin);

    $this->assertEquals('server/carouselapi/v1/bulletins', (string) $mock->getLastRequest()->getUri());
    $this->assertEquals('POST', (string) $mock->getLastRequest()->getMethod());
    $this->assertInstanceOf(Bulletin::class, $response);
  }

  function test_you_can_get_an_individual_group()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],json_encode(['id'=>'1'])),
    ]);
    $handler = HandlerStack::create($mock);

    $server = new API();
    $request = new ModelRequest(Group::class,['id'=>'1']);
    $group = $server
      ->addMockHandler($handler)
      ->connect('my_server','username','password')
      ->get($request);

    $this->assertInstanceOf(Group::class, $group);
    $this->assertEquals(1, $group->id);
    $this->assertArraySubset(['id'=>1],$group->toArray());
  }
}