[![CircleCI build badge](https://circleci.com/gh/trms/carousel-api-php.svg?style=shield&circle-token=:circle-token)](https://circleci.com/gh/trms/carousel-api-php.svg?style=shield&circle-token=:circle-token)
[![License](https://poser.pugx.org/trms/carousel/license)](https://packagist.org/packages/trms/carousel)
[![Total Downloads](https://poser.pugx.org/trms/carousel/downloads)](https://packagist.org/packages/trms/carousel)
[![Latest Stable Version](https://poser.pugx.org/trms/carousel/version)](https://packagist.org/packages/trms/carousel)
[![Code Climate](https://img.shields.io/codeclimate/github/trms/carousel-api-php.svg)]()

# PHP Package for the Carousel API
This package is designed to be a fluent interface for Tightrope Media Systems' Carousel API.  For more information on TRMS and the Carousel software please visit [www.trms.com](https://www.trms.com).

## Carousel API
This package requires ownership of Carousel software version 7 or greater. General information about the Carousel API can be found on your carousel server at `your_carousel_server/carouselapi`.

## Package Installation
This package should be installed with composer and requires PHP 7+
```bash
composer install trms/carousel
```
## Instructions
[Basic Useage Examples](#basic-useage-examples)

## Servers and Requests
[The Server Instance](#api)

[Model Requests](#modelrequest)

[File Upload Requests](#fileuploadrequest)
## Models
[Templates](#template)

[Bulletins](#bulletin)

[Groups](#group)

[Zones](#zone)

## Basic Useage Examples

### Creating a server instance
Server methods that return more than one object will return a [collection](https://github.com/tightenco/collect), which can be treated like an array.
```php
use TRMS\Carousel\Server\API;

$server = new Server();
$server->connect('http://my_carousel_server.com', 'username', 'password');
```

### Requsting Carousel Resources
All of the requests for Carousel resources are created by instantiating a `ModelRequest` with the appropriate `Model` class name and passing that to the server's `get` method.  Passing an array of parameters to the `ModelRequest` is also important so that your query is limited to the items you want to get.

For example, to get a set of bulletins in a given zone:
```php
use TRMS\Carousel\Requests\ModelRequest;
use TRMS\Carousel\Models\Bulletin;

$request = new ModelRequest(Bulletin::class, ['ZoneID'=>'5','IsDeleted'=>false]);
$bulletins = $server->get($request);
```

### Saving a Resource
New or exisiting resources can be saved by passing them to the `save` method on a server instance.

```php
use TRMS\Carousel\Models\BulletinTag;

$new_tag = new BulletinTag(['TagName'=>'My New Tag']);
$server->save($new_tag);
```

### Creating a Bulletin From A Template
Usually you will be creating new bulletins from existing templates.  More information on [Templates](#template) can be found below. Please note that **all bulletins must belong to a group** and this group must be created and related to the bulletin first when saving a newly created bulletin. More information on this can be found in the section on [Bulletins](#bulletin) below.
```php
use TRMS\Carousel\Requests\ModelRequest;
use TRMS\Carousel\Models\Bulletin;
use TRMS\Carousel\Models\Group;
use TRMS\Carousel\Models\Template;


$templates = $server->get(new ModelRequest(Template::class, ['ZoneID'=>'5','IsDeleted'=>false]));
$template = $templates->first(); // the server returns a laravel collection.
$bulletin = Bulletin::fromTemplate($templates->first());
// here you would likely modify the bulletin's 'Blocks' to alter content
$group = new Group(['ZoneID'=>'5']);
$server->save($group);
$bulletin->setGroup($group);
$server->save($bulletin);
```

### Creating Content from File Uploads
You can create new Media and Bulletins by uploading a file to the Carousel Server.  This is done by instantiating a `FileUploadRequest` with the appropriate `Model` class name and an array of parameters passed to the request.  `ZoneID` is required.  You will then add the files you wish to upload by chaining `addFile` methods and then pass the request to the server's `upload` method.  This will return an array of models, one for each file that was added.
```php
use TRMS\Carousel\Request\FileUploadRequest;
use TRMS\Carousel\Model\Media;

$request = new FileUploadRequest(Media::class, ['ZoneID'=>'5']);
$request->addFile('/path/to/local/file.jpg')->addFile('http://path/to/remote/file');

$media = $server->upload($request);
```

# Entities

## Servers and Requests
### API
`TRMS\Carousel\Server\API`
### Methods
|Method|Parameters|Returns|Description|
|------|----------|-------|-----------|
|connect|server origin, username, password|self - chainable|Connect to the server with a url and authentication information.  be sure to include the scheme (ie:http://)|
|whoAmI|none|User Object|Gets the currently connected user.|
|get|ModelRequest|Model or Collection of Models|Get a specified resource or set of resources from the server|
|save|Model|null|Save a model|
|delete|Model|null|Delete a model.  Note that most resources in Carousel are soft deleted on the server and the result will be the property `IsDeleted` will be set to true.|
|upload|FileUploadRequest|Collection of Models|Upload a file or set of files to the server to create content with.|


### ModelRequest
`TRMS\Carousel\Requests\ModelRequest`
### Methods
|Method|Parameters|Returns|Description|
|------|----------|-------|-----------|
|constructor|Model ClassName, associative array|Request Object|Pass this the class name of the Model you would like to retrieve (ie: Bulletin::class) and an associative array of values to filter the request with. (ie: either [id=>'some_id_value'] or ['ZoneID'=>'5',IsDeleted=>false])|

### FileUploadRequest
`TRMS\Carousel\Requests\FileUploadRequest`
### Methods
|Method|Parameters|Returns|Description|
|------|----------|-------|-----------|
|constructor|Model ClassName, associative array|Request Object|Pass this the class name of the Model you would like to retrieve (ie: Bulletin::class) and an associative array that determines the values to create the resource with. (ie: ['ZoneID'=>'5']) (currently only ZoneID is supported and its also required)|
|addFile|string|self - chainable|The URL or filepath of the file to upload to the server|

## Models
### Zone
`TRMS\Carousel\Models\Zone`
### Methods
|Method|Parameters|Returns|Description|
|------|----------|-------|-----------|
|constructor|associative array|Zone Object|Constructor for the class, properties passed to it will be used to define the Zone.|
|addTag|Tag Object|self - chainable|Add a Tag relationship to the model|
|removeTag|Tag Object|self - chainable|Remove a Tag relationship from the model|

### Properties
|Property|type|Description|
|--------|----|-----------|
|id|string|This is set by the server and not editable.|
|ZoneName|string|The name of the Zone|
|GraphicsWidth|integer|The width of the Zone in pixels|
|GraphicsHeight|integer|The height of the Zone in pixels|
|DaylightSavings|boolean|Is daylight savings time respected|
|ZoneType|enumerable|The zone type: 'Bulletin','Crawl' or 'FullAlert'.  More information can be found in Carousel Help|
|Description|string|The description of the Zone.|
|TimezoneID|string|The id of the timezone used by this Zone future updates may make this a model|
|Tags|array |An Array of Tag Objects|
|Pacing|float|A number from 0 to 1 that represents the relative pacing of bulletins when the system decides dwell time.|
|ForceMonitorOn|boolean|Should the monitor be forced on during full screen alerts.|
|ExcludedWords|string|A comma separated list of words that shouldnt be allowed to be shown in the Zone.|
