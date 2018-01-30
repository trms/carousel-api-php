<?php

use TRMS\Carousel\Requests\ModelRequest;
use TRMS\Carousel\Exceptions\CarouselRequestException;
use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\BulletinTag;


class ModelRequestTest extends PHPUnit_Framework_TestCase
{
  function test_when_passed_nothing_it_makes_a_url_for_getting_all_of_the_items_at_the_baseUrl()
  {
    $request = \Mockery::mock(ModelRequest::class,[Bulletin::class])->makePartial();

    $this->assertEquals('bulletins',$request->url());
  }
  function test_when_passed_an_array_it_generates_queryParams()
  {
    $request = \Mockery::mock(ModelRequest::class,[Bulletin::class,['foo'=>'bar']])->makePartial();

    $this->assertEquals(['foo'=>'bar'],$request->queryParams());
  }

  function test_when_passed_an_array_with_id_in_as_a_key_it_generates_a_url_for_requesting_a_single_item_by_id()
  {
    $request = \Mockery::mock(ModelRequest::class,[Bulletin::class,['id'=>'1']])->makePartial();

    $this->assertEquals('bulletins/1',$request->url());
  }

  function test_it_returns_a_class_name_when_asked()
  {
    $request = \Mockery::mock(ModelRequest::class,[Bulletin::class])->makePartial();

    $this->assertEquals('TRMS\Carousel\Models\Bulletin',$request->getResponseClassName());
  }

  function test_when_passed_an_id_and_other_params_it_throws_an_exception()
  {
    try{
      $request = \Mockery::mock(ModelRequest::class,[Bulletin::class,['id'=>'1','foo'=>'bar']])->makePartial();
    } catch(CarouselRequestException $e){
      return;
    }
    $this->fail('the exception was not thrown');
  }

  function test_it_can_handle_a_class_with_CarouselModel_as_a_grandparent()
  {
    $request = \Mockery::mock(ModelRequest::class,[BulletinTag::class])->makePartial();
    $this->assertEquals('bulletintags',$request->url());
  }
}