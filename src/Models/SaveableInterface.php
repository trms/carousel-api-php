<?php namespace TRMS\Carousel\Models;

interface SaveableInterface {
  public function getSaveEndpoint();
  public function getSaveMethod();
  public function save();
  public function delete();
}