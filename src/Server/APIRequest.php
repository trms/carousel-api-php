<?php namespace TRMS\Carousel\Server;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

use TRMS\Carousel\Exceptions\CarouselAPIException;

class APIRequest
{
  public function __construct(Client $client, $handler, $options=[])
  {
    if($handler){
      $options['handler'] = $handler;
    }
    $this->options = $options;
    $this->client = $client;
  }

  public function get($path, Array $queryParams=[]){
    try{
      $options = $this->options;
      $options['query'] = $queryParams;
      $response = $this->client->request('GET', $path, $options);
    } catch(TransferException $e){
      throw new CarouselAPIException('Request to ' . $e->getRequest()->getUri() . ' resulted in a '. Psr7\str($e->getResponse()) );
    }

    return json_decode($response->getBody()->getContents(),true);
  }

  public function post($path,$payload){
    try{
      $options = $this->options;
      $options['body'] = $payload;
      $response = $this->client->request('POST', $path, $options);
    } catch(TransferException $e){
      throw new CarouselAPIException('Request to ' . $e->getRequest()->getUri() . ' resulted in a '. Psr7\str($e->getResponse()) );
    }

    return json_decode($response->getBody()->getContents(),true);
  }

  public function put($path,$payload){
    try{
      $options = $this->options;
      $options['body'] = $payload;
      $response = $this->client->request('PUT', $path, $options);
    } catch(TransferException $e){
      throw new CarouselAPIException('Request to ' . $e->getRequest()->getUri() . ' resulted in a '. Psr7\str($e->getResponse()) );
    }

    return json_decode($response->getBody()->getContents(),true);
  }
}