<?php
declare(strict_types=1);

namespace VkPublisher\Tests;

use PHPUnit\Framework\TestCase;
use VkPublisher\PhotoValidator;

class PhotoValidatorTest extends TestCase
{
    const IMG_PATH = __DIR__ . '/fixtures/img';

    private $photo_validator;

    public function setUp()
    {
        $this->photo_validator = new PhotoValidator;
    }
 
    public function tearDown()
    {
        $this->photo_validator = null;
    }

    public static function setUpBeforeClass()
    {
        $file = fopen(self::IMG_PATH . '/test.jpg', 'w');
        fseek($file, 50000000, SEEK_CUR);
        fwrite($file, '0');
        fclose($file);
    }

    public static function tearDownAfterClass()
    {
        unlink(self::IMG_PATH . '/test.jpg');
    }

    public function testFileNameIsMissing()
    {
        $this->expectExceptionMessage('File name is missing');
        $this->photo_validator->validatePhoto('');
    }

    public function testFileNotFound()
    {
        $this->expectExceptionMessage('File not found');
        $this->photo_validator->validatePhoto('invisible.png');
    }

    public function testFileSizeIsMoreThan()
    {
        $this->expectExceptionMessage('File size is more than');
        $this->photo_validator->validatePhoto(self::IMG_PATH . '/test.jpg');
    }

    public function testFileExtensionIsInvalid()
    {
        $this->expectExceptionMessage('Invalid file extension');
        $this->photo_validator->validatePhoto(self::IMG_PATH . '/invalid-extension.bmp');
    }

    public function testCantGetPhotoSize()
    {
        $this->expectExceptionMessage("Can't get photo size: invalid file");
        $this->photo_validator->validatePhoto(self::IMG_PATH . '/invalid-file.gif');
    }

    public function testWidthHeightSumIsMoreThan()
    {
        $this->expectExceptionMessage('Photo width + height is more than');
        $this->photo_validator->validatePhoto(self::IMG_PATH . '/invalid-width-height-sum.jpg');
    }

    public function testWidthHeightRatioIsInvalid()
    {
        $this->expectExceptionMessage('Invalid width to height ratio');
        $this->photo_validator->validatePhoto(self::IMG_PATH . '/invalid-width-height-ratio.jpg');
    }

    public function testImageIsValid()
    {
        $this->assertEmpty($this->photo_validator->validatePhoto(self::IMG_PATH . '/valid-image.jpg'));
    }
}
