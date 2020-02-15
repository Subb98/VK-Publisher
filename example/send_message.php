<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Subb98\VkPublisher\Models\Settings;
use Subb98\VkPublisher\Services\PhotoUploaderService;
use Subb98\VkPublisher\Services\PostSenderService;

$settings = (new Settings())
    ->setOwnerId(-169116756)
    ->setAlbumId(256572563)
    ->setAccessToken('fe8c3650bdf7ad7185598c5a32c43a4e8d38bf1135e7d7920fdafd5dc5615949ba3fc7b461d6fd120b97f')
    ->setApiVersion('5.92');

$photoUploader = new PhotoUploaderService($settings);
$postSender = new PostSenderService($settings);

$photoUri = $photoUploader->uploadPhotoToAlbum(__DIR__ . '/img/peter-as-superman.jpg');
$postSender->sendPostToWall('Message sends by "VK Publisher" PHP library', [$photoUri]);
