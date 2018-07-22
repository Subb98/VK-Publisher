<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

use VkPublisher\PhotoUploader;
use VkPublisher\PostSender;

$photo_uri = PhotoUploader::uploadPhotoToAlbum(__DIR__ . '/img/peter-as-superman.jpg');
PostSender::sendPostToWall('Message sends by "VK Publisher" PHP library', [$photo_uri]);
