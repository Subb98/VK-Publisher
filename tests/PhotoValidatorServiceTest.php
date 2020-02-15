<?php

declare(strict_types=1);

namespace Subb98\VkPublisher\Tests;

use PHPUnit\Framework\TestCase;
use Subb98\VkPublisher\Services\PhotoValidatorService;

/**
 * Class PhotoValidatorServiceTest
 *
 * @package Subb98\VkPublisher\Tests
 */
class PhotoValidatorServiceTest extends TestCase
{
    /**
     * Path to image fixtures.
     */
    const FIXTURES_PATH = __DIR__ . '/fixtures/img';

    /**
     * @var PhotoValidatorService
     */
    protected $photoValidator = 'Subb98\VkPublisher\Services\PhotoValidatorService';

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass()
    {
        $file = fopen(static::FIXTURES_PATH . '/invalid-file-size.jpg', 'w');
        fseek($file, PhotoValidatorService::MAX_FILE_SIZE * PhotoValidatorService::BYTES_IM_MEGABYTE, SEEK_CUR);
        fwrite($file, '0');
        fclose($file);
    }

    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass()
    {
        unlink(static::FIXTURES_PATH . '/invalid-file-size.jpg');
    }

    public function testPathToPhotoIsMissing()
    {
        $this->expectExceptionMessage('Param $pathToPhoto is missing');
        $this->photoValidator::validate('');
    }

    public function testFileNotFound()
    {
        $this->expectExceptionMessage('File not found');
        $this->photoValidator::validate('invisible.png');
    }

    public function testFileSizeIsMoreThan()
    {
        $this->expectExceptionMessage('File size is more than');
        $this->photoValidator::validate(static::FIXTURES_PATH . '/invalid-file-size.jpg');
    }

    public function testFileExtensionIsInvalid()
    {
        $this->expectExceptionMessage('Invalid file extension');
        $this->photoValidator::validate(static::FIXTURES_PATH . '/invalid-extension.bmp');
    }

    public function testCantGetPhotoSize()
    {
        $this->expectExceptionMessage("Can't get photo size: invalid file");
        $this->photoValidator::validate(static::FIXTURES_PATH . '/invalid-file.gif');
    }

    public function testWidthHeightSumIsMoreThan()
    {
        $this->expectExceptionMessage('Photo width + height is more than');
        $this->photoValidator::validate(static::FIXTURES_PATH . '/invalid-width-height-sum.jpg');
    }

    public function testWidthHeightRatioIsInvalid()
    {
        $this->expectExceptionMessage('Invalid width to height ratio');
        $this->photoValidator::validate(static::FIXTURES_PATH . '/invalid-width-height-ratio.jpg');
    }

    public function testImageIsValid()
    {
        $this->assertEmpty($this->photoValidator::validate(static::FIXTURES_PATH . '/valid-image.jpg'));
    }
}
