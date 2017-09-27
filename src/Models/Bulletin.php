<?php namespace TRMS\Carousel\Models;

use \DateTime;
use Carbon\Carbon;

use TRMS\Carousel\Models\Traits\HasBlocks;
use TRMS\Carousel\Models\Traits\HasBackground;
use TRMS\Carousel\Models\Traits\HasUser;
use TRMS\Carousel\Models\Traits\HasTags;
use TRMS\Carousel\Models\Traits\ResolvesPartial;

use TRMS\Carousel\Server\API;
use TRMS\Carousel\Exceptions\CarouselModelException;
use TRMS\Carousel\Requests\ModelRequest;

class Bulletin extends CarouselModel
{
  use ResolvesPartial;
  use HasBlocks;
  use HasBackground;
  use HasUser;
  use HasTags {
    addTag as protected traitAddTag;
    removeTag as protected traitRemoveTag;
  }
  public function addTag(BulletinTag $tag)
  {
    return $this->traitAddTag($tag);
  }
  public function removeTag(BulletinTag $tag)
  {
    return $this->traitRemoveTag($tag);
  }

  public $id;
  public $IsAlert = false;
  public $Type = 'Standard';

  public $Description = "My Awesome Bulletin";

  public $DateTimeOn, $DateTimeOff, $CycleTimeOff, $CycleTimeOn;

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
  public $TransitionID;
  public $SoundID;

  protected $endpoint = 'bulletins';

  public function __construct(Array $props = [],API $api=null)
  {
    $this->resetSchedule()->resetCycleTimes();
    parent::__construct($props,$api);
  }

  public function setProps(Array $props)
  {
    $this->setBlocksFromProps($props);
    $this->setTagsFromProps($props,'TRMS\Carousel\Models\BulletinTag');
    parent::setProps($props);
  }

  static function fromTemplate(Template $template)
  {
    $props = $template->toArray();
    unset($props['UserID']);
    unset($props['id']);
    unset($props['Description']);
    return new static($props);
  }

  public function setGroup(Group $group)
  {
    $this->setBelongsTo('Group', $group);
    return $this;
  }

  public function getGroup()
  {
    if($group = $this->getBelongsTo('Group')){
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