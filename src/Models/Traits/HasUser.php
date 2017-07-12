<?php namespace TRMS\Carousel\Models\Traits;

use TRMS\Carousel\Models\User;
use TRMS\Carousel\Exceptions\CarouselModelException;

trait HasUser
{
  public $UserID;

  public function setUser(User $user)
  {
    $this->setBelongsTo('User', $user);
    return $this;
  }

  public function getUser()
  {
    if($user = $this->getBelongsTo('User')){
      return $user;
    }
    throw new CarouselModelException("use setUser method to set the user relationship");
  }
}