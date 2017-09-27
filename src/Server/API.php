<?php namespace TRMS\Carousel\Server;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

use TRMS\Carousel\Models\User;
use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Group;
use TRMS\Carousel\Models\BulletinOrder;
use TRMS\Carousel\Models\CarouselModel;
use TRMS\Carousel\Exceptions\CarouselAPIException;

use TRMS\Carousel\Requests\ModelRequest;
use TRMS\Carousel\Requests\APIRequest;
use TRMS\Carousel\Requests\FileUploadRequest;

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
    $whoami = $request->get('whoami');
    $id = $whoami['id'];
    $user = $request->get("user/$id");

    return new User($user);
  }

  public function get(ModelRequest $request)
  {
    $responseClass = $request->getResponseClassName();
    $apiRequest = new APIRequest($this->client, $this->handler);

    if($request->id){
      $response = $apiRequest->get($request->url());
      return new $responseClass($response,$this);
    } else {
      $response = $apiRequest->get($request->url(),$request->queryParams);

      if($responseClass === BulletinOrder::class){
        return new BulletinOrder($request->queryParams['ZoneID'], $response);
      }

      return collect($response)->filter()->map(function($properties) use ($responseClass){
        return new $responseClass($properties,$this);
      });
    }
  }

  public function save(CarouselModel $model)
  {
    $endpoint = $model->getSaveEndpoint();
    $method = $model->getSaveMethod();
    if($model->getApi() && $model->PartialBulletin){
      $model->resolvePartial();
    }
    $options = [
      'headers'=>[
        'Content-Type'=>'application/json'
      ]
    ];
    $request = new APIRequest($this->client, $this->handler, $options);
    $response = $request->$method($endpoint, json_encode($model->toArray()));

    $model->setProps($response);
    return $model;
  }

  public function delete(CarouselModel $model)
  {
    $endpoint = $model->getSaveEndpoint();
    $options = [
      'headers'=>[
        'Content-Type'=>'application/json'
      ]
    ];
    $request = new APIRequest($this->client, $this->handler, $options);
    $response = $request->delete($endpoint);
    if($response->getStatusCode() === 204){
      $model->setProps(['IsDeleted'=>true]);
    }
    return $model;
  }

  public function upload(FileUploadRequest $request)
  {
    return $request->files
      ->map(function($file) use ($request){
        $apiRequest = new APIRequest($this->client, $this->handler);
        try{
          return $apiRequest->upload($request->url(),$file, $request->params());
        } catch (CarouselAPIException $e){
          return $e;
        }
      })
      ->map(function($response) use ($request){
        $responseClass = $request->getResponseClassName();

        if(is_array($response)){
          if($responseClass = 'TRMS\Carousel\Models\Bulletin'){
            $response = $response['Bulletins'][0];
          }
          return new $responseClass($response);
        }
        return $response;
      });
  }
}