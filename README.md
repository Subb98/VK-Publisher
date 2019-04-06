# VK Publisher
PHP library for auto-sending (crossposting) messages to VKontakte wall

[![Build Status](https://travis-ci.org/Subb98/VK-Publisher.svg?branch=master)](https://travis-ci.org/Subb98/VK-Publisher)
[![StyleCI](https://styleci.io/repos/141911023/shield)](https://styleci.io/repos/141911023)
[![Latest Stable Version](https://poser.pugx.org/subb98/vk-publisher/v/stable)](https://packagist.org/packages/subb98/vk-publisher)
[![Total Downloads](https://poser.pugx.org/subb98/vk-publisher/downloads)](https://packagist.org/packages/subb98/vk-publisher)
[![Latest Unstable Version](https://poser.pugx.org/subb98/vk-publisher/v/unstable)](https://packagist.org/packages/subb98/vk-publisher)
[![License](https://poser.pugx.org/subb98/vk-publisher/license)](https://packagist.org/packages/subb98/vk-publisher)

![](https://i.imgur.com/HE1Lq53.png)

## Features
- Send a message or attachment (or all together) to the wall
- Upload photo to album

## Requirements

- PHP 7.1 or above
- [cURL extension](http://php.net/manual/en/curl.installation.php)
- [JSON extension](http://php.net/manual/en/json.installation.php)

## Installation

```
composer require subb98/vk-publisher
```

## Usage
### Getting access_token

1. Getting the code to get access_token
    - Request example: `https://oauth.vk.com/authorize?client_id=1234567&display=page&redirect_uri=&scope=photos,wall,groups,offline&response_type=code&v=5.92`
    - Response example: `https://oauth.vk.com/blank.html#code=3b2a554d20bd48c360`

2. Getting access_token
    - Request example: `https://oauth.vk.com/access_token?client_id=1234567&client_secret=9Wnk7UcEpeFAHhJYyyJg&redirect_uri=&code=3b2a554d20bd48c360`
    - Response example: `{"access_token":"fe8c3650bdf7ad7185598c5a32c43a4e8d38bf1135e7d7920fdafd5dc5615949ba3fc7b461d6fd120b97f","expires_in":0,"user_id":89012345}`

Note: don't use `scope=offline` if you fear access_token is may be compromised.  
See more: [Getting access token](https://vk.com/dev/authcode_flow_user)

### Sending a message to the wall

```
use Subb98\VkPublisher\Settings;
use Subb98\VkPublisher\PostSender;

$settings = new Settings;
$settings->setGroupId(169116756);
$settings->setAccessToken('fe8c3650bdf7ad7185598c5a32c43a4e8d38bf1135e7d7920fdafd5dc5615949ba3fc7b461d6fd120b97f');
$settings->setApiVersion('5.92');

$postSender = new PostSender($settings);
$postSender->sendPostToWall('Message sends by "VK Publisher" PHP library');
```

### Whith photo

```
use Subb98\VkPublisher\PhotoValidator;
use Subb98\VkPublisher\PhotoUploader;

$settings->setAlbumId(256572563);

$photoUploader = new PhotoUploader($settings, new PhotoValidator);

$photoUri = $photoUploader->uploadPhotoToAlbum(__DIR__ . '/img/peter-as-superman.jpg');
$postSender->sendPostToWall('Message sends by "VK Publisher" PHP library', [$photoUri]);
```

## License
[MIT](https://opensource.org/licenses/MIT)
