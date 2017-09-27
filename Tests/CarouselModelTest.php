<?php

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselModelException;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class CarouselModelTest extends PHPUnit_Framework_TestCase
{
  function test_a_persisted_model_has_a_save_function_that_uses_the_api_it_was_created_with()
  {
    $apiMock = \Mockery::mock(API::class);
    $apiMock->shouldReceive('save')
      ->once()
      ->andReturn(new Bulletin(['id'=>'1']));

    $bulletin = new Bulletin(['id'=>'1'],$apiMock);

    $bulletin->save();

    \Mockery::close();
  }

  function test_calling_save_on_a_model_without_an_api_will_throw_a_carousel_model_exception()
  {
    $bulletin = new Bulletin(['id'=>'1']);

    try{
      $bulletin->save();
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('the exception was not thrown');
  }

  function test_calling_save_on_a_non_persisted_model_will_throw_a_carousel_model_exception()
  {
    $apiMock = \Mockery::mock(API::class);
    $apiMock->shouldNotReceive('save');

    $bulletin = new Bulletin([],$apiMock);

    try{
      $bulletin->save();
    } catch(CarouselModelException $e){
      \Mockery::close();
      return;
    }

    $this->fail('the exception was not thrown');

  }

  function test_a_persisted_model_has_a_delete_function_that_uses_the_api_it_was_created_with()
  {
    $apiMock = \Mockery::mock(API::class);
    $apiMock->shouldReceive('delete')
      ->once()
      ->andReturn(new Bulletin(['id'=>'1']));

    $bulletin = new Bulletin(['id'=>'1'],$apiMock);

    $bulletin->delete();

    \Mockery::close();
  }

  function test_calling_delete_on_a_model_without_an_api_will_throw_a_carousel_model_exception()
  {
    $bulletin = new Bulletin(['id'=>'1']);

    try{
      $bulletin->delete();
    } catch(CarouselModelException $e){
      return;
    }

    $this->fail('the exception was not thrown');
  }

  function test_calling_delete_on_a_non_persisted_model_will_throw_a_carousel_model_exception()
  {
    $apiMock = \Mockery::mock(API::class);
    $apiMock->shouldNotReceive('delete');

    $bulletin = new Bulletin([],$apiMock);

    try{
      $bulletin->delete();
    } catch(CarouselModelException $e){
      \Mockery::close();
      return;
    }

    $this->fail('the exception was not thrown');

  }
}