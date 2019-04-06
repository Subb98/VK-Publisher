<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Subb98\VkPublisher\Settings;
use Subb98\VkPublisher\PhotoValidator;
use Subb98\VkPublisher\PhotoUploader;
use Subb98\VkPublisher\PostSender;

$settings = new Settings;
$settings->setGroupId(169116756);
$settings->setAlbumId(256572563);
$settings->setAccessToken('fe8c3650bdf7ad7185598c5a32c43a4e8d38bf1135e7d7920fdafd5dc5615949ba3fc7b461d6fd120b97f');
$settings->setApiVersion('5.92');

$photo_uploader = new PhotoUploader($settings, new PhotoValidator);
$post_sender = new PostSender($settings);

$photo_uri = $photo_uploader->uploadPhotoToAlbum(__DIR__ . '/img/peter-as-superman.jpg');
$post_sender->sendPostToWall('Message sends by "VK Publisher" PHP library', [$photo_uri]);
