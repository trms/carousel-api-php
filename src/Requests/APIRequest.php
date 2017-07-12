<?php namespace TRMS\Carousel\Requests;

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
      $this->throwException($e);
    }

    return $this->parseResponse($response);
  }

  public function post($path,$payload){
    try{
      $options = $this->options;
      $options['body'] = $payload;
      $response = $this->client->request('POST', $path, $options);
    } catch(TransferException $e){
      $this->throwException($e);
    }

    return $this->parseResponse($response);
  }

  public function put($path,$payload){
    try{
      $options = $this->options;
      $options['body'] = $payload;
      $response = $this->client->request('PUT', $path, $options);
    } catch(TransferException $e){
      $this->throwException($e);
    }

    return $this->parseResponse($response);
  }

  public function delete($path)
  {
    try{
      $options = $this->options;
      $response = $this->client->request('DELETE',$path, $options);
    } catch(TransferException $e){
      $this->throwException($e);
    }

    return $this->parseResponse($response);
  }

  public function upload(string $path, $stream, $params)
  {
    try{
      $options = $this->options;
      $options['multipart'] = [
        [
          'name'=>'file',
          'contents'=>$stream
        ],
        [
          'name'=>'uploadparams',
          'contents'=>json_encode($params)
        ]
      ];
      $response = $this->client->request('POST',$path, $options);
    } catch(TransferException $e) {
      $this->throwException($e);
    }
    return $this->parseResponse($response);
  }

  private function parseResponse($response){
    return json_decode($response->getBody()->getContents(),true);
  }

  private function throwException($e)
  {
    if($e->getResponse()){
      $message = Psr7\str($e->getResponse());
    } else {
      $message = $e->getMessage();
    }
    throw new CarouselAPIException('Request to ' . $e->getRequest()->getUri() . " resulted in a $message" );
  }
}