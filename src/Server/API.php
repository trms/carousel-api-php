<?php namespace TRMS\Carousel\Server;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

use TRMS\Carousel\Models\User;
use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Group;
use TRMS\Carousel\Models\CarouselModel;
use TRMS\Carousel\Exceptions\CarouselAPIException;

class API
{
  private $handler;

  public function __construct()
  {
    $this->connect();
  }

  public function connect($uri=null, $user=null, $password=null)
  {
    if(function_exists('config')){
      $uri = $uri ?? config('carousel.server');
      $user = $user ?? config('carousel.user');
      $password = $password ?? config('carousel.password');
    }

    $this->client = new Client([
      'base_uri' => $uri."/carouselapi/v1/",
      'auth'=>[$user, $password],
    ]);
    return $this;
  }

  public function addMockHandler(HandlerStack $handler)
  {
    $this->handler = $handler;
    return $this;
  }

  public function whoAmI()
  {
    $request = new APIRequest($this->client, $this->handler);
    $response = $request->get('whoami');

    if(is_array($response[0]) === false){
      return;
    }
    return new User($response[0]);
  }

  public function getBulletins(Array $query = [])
  {
    $request = new APIRequest($this->client, $this->handler);
    $response = $request->get('bulletins',$query);
    return collect($response)->filter()->map(function($properties){
      return new Bulletin($properties,$this);
    });
  }

  public function getBulletin(string $id)
  {
    $request = new APIRequest($this->client, $this->handler);
    $response = $request->get("bulletins/$id");
    return new Bulletin($response,$this);
  }

  public function getGroup(string $id)
  {
    $request = new APIRequest($this->client, $this->handler);
    $response = $request->get("groups/$id");
    return new Group($response);
  }

  public function save(CarouselModel $model)
  {
    $endpoint = $model->getSaveEndpoint();
    $method = $model->getSaveMethod();
    $modeltype = get_class($model);

    $request = new APIRequest($this->client, $this->handler);
    $response = $request->$method($endpoint, json_encode($model->toArray()));

    return new $modeltype($response);
  }
}