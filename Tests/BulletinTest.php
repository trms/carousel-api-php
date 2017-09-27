<?php

use CarouselTests\MockData\MockResponder;

use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Template;
use TRMS\Carousel\Models\Group;
use TRMS\Carousel\Models\BulletinBlock;
use TRMS\Carousel\Models\Media;


use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselModelException;
use TRMS\Carousel\Requests\ModelRequest;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

use Carbon\Carbon;

class BulletinTest extends PHPUnit_Framework_TestCase
{

  function test_bulletin_blocks_serialize_correctly()
  {
    $bulletin = new Bulletin();

    $block1 = new BulletinBlock(['BlockType'=>'Text','Text'=>'foobarbaz']);
    $block2 = new BulletinBlock(['BlockType'=>'Rectangle']);

    $bulletin->Blocks = [$block1, $block2];

    $this->assertEquals(['BlockType'=>'Text','Text'=>'foobarbaz'],  $bulletin->toArray()['Blocks'][0]);
    $this->assertEquals(['BlockType'=>'Rectangle'],  $bulletin->toArray()['Blocks'][1]);
  }

  function test_the_resolvePartial_method_will_get_partial_bulletins_from_the_api()
  {
    $mockApi = \Mockery::mock(API::class);
    $mockApi->shouldReceive('get')
      ->once()
      ->andReturn(new Bulletin(['Blocks'=>[[],[]]]));

    $bulletin = new Bulletin(['id'=>'1','PartialBulletin'=>true],$mockApi);
    $bulletin->resolvePartial();

    $this->assertEquals(2, count($bulletin->Blocks));
    $this->assertInstanceOf(BulletinBlock::class, $bulletin->Blocks[0]);
    $this->assertEquals(false, $bulletin->PartialBulletin);
    \Mockery::close();
  }

  function test_calling_resolvePartial_on_a_non_partial_will_not_use_the_api()
  {
    $mockApi = \Mockery::mock(API::class);
    $mockApi->shouldNotReceive('get')
      ->andReturn(new Bulletin(['Blocks'=>[[],[]]]));

    $bulletin = new Bulletin(['id'=>'1','PartialBulletin'=>false],$mockApi);

    $bulletin->resolvePartial();

    \Mockery::close();
  }

  function test_calling_resolvePartial_on_a_new_bulletin_will_result_in_an_exception()
  {

    $bulletin = new Bulletin(['id'=>'1','PartialBulletin'=>true]);

    try{
      $bulletin->resolvePartial();
    } catch(CarouselModelException  $e){
      return;
    }

    $this->fail('the exception was not called');
  }

  function test_you_can_add_a_group_relationship_after_instantiation()
  {
    $bulletin = new Bulletin();
    $group = new Group(['id'=>'15','ZoneID'=>'1']);
    $bulletin->setGroup($group);
    $this->assertEquals($group->id, $bulletin->toArray()['GroupID']);
    $this->assertEquals($group, $bulletin->getGroup());
    $this->assertFalse(isset($bulletin->toArray()['GroupObject']));
  }

  function test_if_the_group_object_has_not_been_resolved_an_api_request_will_be_made()
  {
    $mock = new MockHandler([
      new Response(200,[],json_encode(['id'=>'12'])),
    ]);
    $handler = HandlerStack::create($mock);

    $api = new API();
    $api->addMockHandler($handler);

    $bulletin = new Bulletin(['GroupID'=>'12']);
    $bulletin->setApi($api);
    $group = $bulletin->getGroup();

    $this->assertInstanceOf(Group::class, $group);
    $this->assertEquals('12',$group->id);
  }

  function test_getting_the_group_on_new_bulletins_with_no_group_set_will_throw_an_exception()
  {
    $bulletin = new Bulletin();
    try{
      $bulletin->getGroup();
    } catch (CarouselModelException $e){
      return;
    }

    $this->fail('the exception was not thrown');
  }

  function test_an_array_of_bulletin_params_passed_to_the_constructor_sets_them_on_the_bulletin()
  {
    $mockBulletins = json_decode(MockResponder::bulletins(),true);
    $bulletinProps = $mockBulletins[0];

    $bulletin = new Bulletin($bulletinProps);

    $this->assertEquals($bulletinProps['id'], $bulletin->id);
    $this->assertEquals($bulletinProps['Description'], $bulletin->Description);
    $this->assertEquals($bulletinProps['DateTimeOn'], $bulletin->DateTimeOn);
    $this->assertEquals($bulletinProps['WeekdayOnOff'], $bulletin->WeekdayOnOff);
    $this->assertEquals($bulletinProps['IsRepeating'], $bulletin->IsRepeating);
    $this->assertEquals($bulletinProps['LastUpdate'], $bulletin->LastUpdate);
  }

  function test_the_on_off_and_cycle_times_default_to_a_reasonable_value()
  {
    $thisMorning = Carbon::parse('12am');
    $tonight = Carbon::parse('23:59:59');

    $bulletin = new Bulletin;

    $this->assertEquals($thisMorning->format(\DateTime::W3C), $bulletin->DateTimeOn);
    $this->assertEquals($tonight->format(\DateTime::W3C), $bulletin->DateTimeOff);
    $this->assertEquals($thisMorning->format(\DateTime::W3C), $bulletin->CycleTimeOn);
    $this->assertEquals($tonight->format(\DateTime::W3C), $bulletin->CycleTimeOff);
  }

  function test_you_can_set_the_bulletins_display_times_individually()
  {
    $now = Carbon::now();
    $tomorrow = Carbon::now()->addDays(1);
    $bulletin = new Bulletin;

    $bulletin
      ->setDateTimeOn($now)
      ->setDateTimeOff($tomorrow);

    $this->assertEquals($now->format(\DateTime::W3C), $bulletin->DateTimeOn);
    $this->assertEquals($tomorrow->format(\DateTime::W3C), $bulletin->DateTimeOff);
  }

  function test_you_can_set_the_bulletins_display_times_together_as_a_set()
  {
    $now = Carbon::now();
    $tomorrow = Carbon::now()->addDays(1);
    $bulletin = new Bulletin;

    $this->assertFalse($bulletin->IsScheduled);

    $bulletin
      ->setSchedule($now,$tomorrow);

    $this->assertTrue($bulletin->IsScheduled);
    $this->assertEquals($now->format(\DateTime::W3C), $bulletin->DateTimeOn);
    $this->assertEquals($tomorrow->format(\DateTime::W3C), $bulletin->DateTimeOff);
  }

  function test_you_can_set_the_bulletins_cycle_times_individually()
  {
    $on = Carbon::parse('11am');
    $off = Carbon::parse('2pm');

    $bulletin = new Bulletin;

    $bulletin
      ->setCycleTimeOn($on)
      ->setCycleTimeOff($off);

    $this->assertEquals($on->setTime(11,00,00)->format(\DateTime::W3C), $bulletin->CycleTimeOn);
    $this->assertEquals($off->setTime(14,00,00)->format(\DateTime::W3C), $bulletin->CycleTimeOff);
  }

  function test_you_can_set_the_bulletins_cycle_times_together_as_a_set()
  {
    $on = Carbon::parse('11am');
    $off = Carbon::parse('2pm');

    $bulletin = new Bulletin;

    $bulletin
      ->setCycleTimes($on, $off);

    $this->assertEquals($on->setTime(11,00,00)->format(\DateTime::W3C), $bulletin->CycleTimeOn);
    $this->assertEquals($off->setTime(14,00,00)->format(\DateTime::W3C), $bulletin->CycleTimeOff);
  }

  function test_you_can_turn_all_days_on_and_off()
  {
    $bulletin = new Bulletin;
    $this->assertEquals(127, $bulletin->WeekdayOnOff);

    $bulletin->setDaysOnAll(false);
    $this->assertEquals(0, $bulletin->WeekdayOnOff);

    $bulletin->setDaysOnAll(true);
    $this->assertEquals(127, $bulletin->WeekdayOnOff);
  }

  function test_you_can_turn_weekends_and_weekdays_on_and_off()
  {
    $bulletin = new Bulletin;

    $bulletin->setDaysOnWeekend(false);
    $this->assertEquals(62, $bulletin->WeekdayOnOff);

    $bulletin->setDaysOnWeekdays(false);
    $this->assertEquals(0, $bulletin->WeekdayOnOff);

    $bulletin->setDaysOnWeekdays();
    $this->assertEquals(62, $bulletin->WeekdayOnOff);

    $bulletin->setDaysOnWeekend();
    $this->assertEquals(127, $bulletin->WeekdayOnOff);
  }

  function test_you_can_turn_individual_days_on_and_off()
  {
    $bulletin = new Bulletin;

    $bulletin
      ->setDaysOnMonday(false)
      ->setDaysOnTuesday(false)
      ->setDaysOnWednesday(false);

    $this->assertEquals(113, $bulletin->WeekdayOnOff);

    $bulletin
      ->setDaysOnFriday(false)
      ->setDaysOnThursday(false)
      ->setDaysOnMonday();

    $this->assertEquals(67, $bulletin->WeekdayOnOff);

    $bulletin
      ->setDaysOnSaturday(false)
      ->setDaysOnSunday(false)
      ->setDaysOnTuesday();

    $this->assertEquals(6, $bulletin->WeekdayOnOff);
  }

}