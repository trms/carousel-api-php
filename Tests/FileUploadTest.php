<?php

use TRMS\Carousel\Server\API;
use TRMS\Carousel\Requests\FileUploadRequest;
use TRMS\Carousel\Models\Bulletin;

use TRMS\Carousel\Exceptions\CarouselAPIException;

use CarouselTests\MockData\MockResponder;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class TestCase extends PHPUnit_Framework_TestCase
{
  function test_you_can_upload_a_bulletin_from_a_file()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],json_encode([
        'Bulletins'=>[['id'=>'1']]
      ])),
    ]);

    $handler = HandlerStack::create($mock);

    $filepath = 'Tests/MockData/mock_file.png';
    $fileUpload = new FileUploadRequest(Bulletin::class,['ZoneID'=>1]);
    $fileUpload->addFile($filepath);

    $server = new API();
    $server
      ->addMockHandler($handler)
      ->connect('server','username','password');

    $bulletins = $server->upload($fileUpload);

    $this->assertInstanceOf(Bulletin::class, $bulletins->first());
    $this->assertEquals($bulletins->first()->id, '1');
    $this->assertEquals('server/carouselapi/v1/bulletins', (string) $mock->getLastRequest()->getUri());
    $this->assertEquals('POST', (string) $mock->getLastRequest()->getMethod());
    $this->assertGreaterThan(150000,$mock->getLastRequest()->getBody()->stream->getSize(), 'the file is big');
  }

  function test_you_can_upload_multiple_bulletins_at_once()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(200,[],json_encode([
        'Bulletins'=>[['id'=>'1']]
      ])),
      new Response(200,[],json_encode([
        'Bulletins'=>[['id'=>'2']]
      ])),
    ]);

    $handler = HandlerStack::create($mock);

    $filepath = 'Tests/MockData/mock_file.png';
    $fileUpload = new FileUploadRequest(Bulletin::class,['ZoneID'=>1]);
    $fileUpload->addFile($filepath)->addFile($filepath);

    $server = new API();
    $server
      ->addMockHandler($handler)
      ->connect('server','username','password');

    $bulletins = $server->upload($fileUpload);

    $this->assertInstanceOf(Bulletin::class, $bulletins[0]);
    $this->assertInstanceOf(Bulletin::class, $bulletins[1]);
    $this->assertEquals($bulletins[0]->id, '1');
    $this->assertEquals($bulletins[1]->id, '2');
  }

  function test_failed_uploads_will_return_an_exception()
  {
    $mockResponder = new MockResponder;
    $mock = new MockHandler([
      new Response(500,[],json_encode(['Message'=>'File Upload Failed'])),
    ]);

      $handler = HandlerStack::create($mock);

      $filepath = 'Tests/MockData/mock_file.png';
      $fileUpload = new FileUploadRequest(Bulletin::class,['ZoneID'=>1]);
      $fileUpload->addFile($filepath);

      $server = new API();
      $server
      ->addMockHandler($handler)
      ->connect('server','username','password');

      $bulletins = $server->upload($fileUpload);

      $this->assertInstanceOf('TRMS\Carousel\Exceptions\CarouselAPIException', $bulletins->first());
    }

  }