<?php
declare(strict_types=1);

namespace Subb98\VkPublisher\Tests;

use PHPUnit\Framework\TestCase;
use Subb98\VkPublisher\PhotoValidator;

class PhotoValidatorTest extends TestCase
{
    const IMG_PATH = __DIR__ . '/fixtures/img';

    private $photoValidator;

    public function setUp()
    {
        $this->photoValidator = new PhotoValidator;
    }

    public function tearDown()
    {
        $this->photoValidator = null;
    }

    public static function setUpBeforeClass()
    {
        $file = fopen(self::IMG_PATH . '/invalid-file-size.jpg', 'w');
        fseek($file, 50000000, SEEK_CUR);
        fwrite($file, '0');
        fclose($file);
    }

    public static function tearDownAfterClass()
    {
        unlink(self::IMG_PATH . '/invalid-file-size.jpg');
    }

    public function testPathToPhotoIsMissing()
    {
        $this->expectExceptionMessage('Param $pathToPhoto is missing');
        $this->photoValidator->validate('');
    }

    public function testFileNotFound()
    {
        $this->expectExceptionMessage('File not found');
        $this->photoValidator->validate('invisible.png');
    }

    public function testFileSizeIsMoreThan()
    {
        $this->expectExceptionMessage('File size is more than');
        $this->photoValidator->validate(self::IMG_PATH . '/invalid-file-size.jpg');
    }

    public function testFileExtensionIsInvalid()
    {
        $this->expectExceptionMessage('Invalid file extension');
        $this->photoValidator->validate(self::IMG_PATH . '/invalid-extension.bmp');
    }

    public function testCantGetPhotoSize()
    {
        $this->expectExceptionMessage("Can't get photo size: invalid file");
        $this->photoValidator->validate(self::IMG_PATH . '/invalid-file.gif');
    }

    public function testWidthHeightSumIsMoreThan()
    {
        $this->expectExceptionMessage('Photo width + height is more than');
        $this->photoValidator->validate(self::IMG_PATH . '/invalid-width-height-sum.jpg');
    }

    public function testWidthHeightRatioIsInvalid()
    {
        $this->expectExceptionMessage('Invalid width to height ratio');
        $this->photoValidator->validate(self::IMG_PATH . '/invalid-width-height-ratio.jpg');
    }

    public function testImageIsValid()
    {
        $this->assertEmpty($this->photoValidator->validate(self::IMG_PATH . '/valid-image.jpg'));
    }
}
