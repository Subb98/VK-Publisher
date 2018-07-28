<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

use VkPublisher\PhotoValidator;
use VkPublisher\PhotoUploader;
use VkPublisher\PostSender;

$photo_uploader = new PhotoUploader(new PhotoValidator);
$post_sender = new PostSender;

$photo_uri = $photo_uploader->uploadPhotoToAlbum(__DIR__ . '/img/peter-as-superman.jpg');
$post_sender->sendPostToWall('Message sends by "VK Publisher" PHP library', [$photo_uri]);
