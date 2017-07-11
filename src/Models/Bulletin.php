<?php namespace TRMS\Carousel\Models;

use \DateTime;
use Carbon\Carbon;
use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselModelException;

class Bulletin extends CarouselModel
{
  public $id;
  public $IsAlert = false;
  public $Type = 'Standard';

  public $Description = "";

  public $DateTimeOn;
  public $DateTimeOff;
  public $CycleTimeOff;
  public $CycleTimeOn;

  public $IsScheduled = false;

  public $WeekdayOnOff = 127;

  public $IsRepeating = false;
  public $RepeatInterval = 0;

  public $TrackImpressions = false;


  public $UseSystemDwellTime = true;
  public $DwellTime = 0;
  public $WebEnabled = true;

  public $SuppressBackgroundAudio = false;

  public $IsDeleted = false;

  //relationships
  public $GroupID;
  public $GroupObject;
  public $UserID;
  public $TransitionID;
  public $SoundID;
  public $BackgroundID;
  public $Tags = [];
  public $Blocks = [];

  public function __construct(Array $props = [],API $api=null)
  {
    $this->resetSchedule()->resetCycleTimes();
    if($api){
      $this->api = $api;
    }
    parent::__construct($props);
  }

  public function getSaveEndpoint(){
    if($this->id){
      return "bulletins/$this->id";
    }
    return "bulletins";
  }

  public function setGroup(Group $group)
  {
    $this->GroupID = $group->id;
    $this->GroupObject = $group;
    return $this;
  }

  public function getGroup()
  {
    $group = $this->getBelongsTo('Group');
    if($group){
      return $group;
    }
    throw new CarouselModelException("use setGroup method to set the group relationship for new bulletins");
  }

  public function resetSchedule()
  {
    $this->IsScheduled = false;
    $this->DateTimeOn = Carbon::now()->setTime(0,0,0)->format(DateTime::W3C);
    $this->DateTimeOff = Carbon::now()->setTime(23,59,59)->format(DateTime::W3C);
    return $this;
  }

  public function resetCycleTimes()
  {
    $this->CycleTimeOn = Carbon::now()->setTime(0,0,0)->format(DateTime::W3C);
    $this->CycleTimeOff = Carbon::now()->setTime(23,59,59)->format(DateTime::W3C);
    return $this;
  }

  public function setDaysOnAll(bool $boolean=true)
  {
    if($boolean){
      $this->WeekdayOnOff = 127;
    } else {
      $this->WeekdayOnOff = 0;
    }
    return $this;
  }

  public function setDaysOnWeekend(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[0] = $boolean;
    $dayArray[6] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnWeekdays(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[1] = $boolean;
    $dayArray[2] = $boolean;
    $dayArray[3] = $boolean;
    $dayArray[4] = $boolean;
    $dayArray[5] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnSaturday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[0] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnFriday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[1] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnThursday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[2] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnWednesday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[3] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnTuesday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[4] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnMonday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[5] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  public function setDaysOnSunday(bool $boolean=true)
  {
    $dayArray = $this->bitfieldToArray($this->WeekdayOnOff);

    $dayArray[6] = $boolean;

    $bitfield = $this->arrayToBitField($dayArray);
    $this->WeekdayOnOff = $bitfield;
    return $this;
  }

  private function bitfieldToArray(int $int)
  {
    $array = [];
    while ($int){
      array_unshift($array,!!($int & 1));
      $int >>= 1;
    }
    while(count($array) < 7){
      array_unshift($array,false);
    }
    return $array;
  }

  private function arrayToBitField(Array $array)
  {
    $bits = '';
    foreach($array as $value){
        $bits .= $value?'1':'0';
    }
    $bitfield = base_convert($bits,2,10);
    return $bitfield;
  }

  public function setSchedule(DateTime $on, DateTime $off)
  {
    $this->IsScheduled = true;
    $this->DateTimeOn = $on->format(DateTime::W3C);
    $this->DateTimeOff = $off->format(DateTime::W3C);
    return $this;
  }
  public function setDateTimeOn(DateTime $on)
  {
    $this->DateTimeOn = $on->format(DateTime::W3C);
    return $this;
  }

  public function setDateTimeOff(DateTime $off)
  {
    $this->DateTimeOff = $off->format(DateTime::W3C);
    return $this;
  }

  public function setCycleTimes(DateTime$on, DateTime$off)
  {
    $this->CycleTimeOn = $on->format(DateTime::W3C);
    $this->CycleTimeOff = $off->format(DateTime::W3C);
    return $this;
  }

  public function setCycleTimeOn(DateTime $on)
  {
    $this->CycleTimeOn = $on->format(DateTime::W3C);
    return $this;
  }
  public function setCycleTimeOff(DateTime $off)
  {
    $this->CycleTimeOff = $off->format(DateTime::W3C);
    return $this;
  }


}