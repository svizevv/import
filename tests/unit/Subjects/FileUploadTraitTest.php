<?php

/**
 * TechDivision\Import\Subjects\AbstractEavSubjectTest
 *
* PHP version 7
*
* @author    Tim Wagner <t.wagner@techdivision.com>
* @copyright 2016 TechDivision GmbH <info@techdivision.com>
* @license   https://opensource.org/licenses/MIT
* @link      https://github.com/techdivision/import
* @link      http://www.techdivision.com
*/

namespace TechDivision\Import\Subjects;

use PHPUnit\Framework\TestCase;

/**
 * Test class for the file upload trait implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class FileUploadTraitTest extends TestCase
{

    /**
     * The file upload trait that has to be tested.
     *
     * @var \TechDivision\Import\Subjects\FileUploadTraitImpl
     */
    protected $fileUploadTrait;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void
    {
        $this->fileUploadTrait = new FileUploadTraitImpl();
    }

    /**
     * Test the set/hasCopyImages() methods.
     *
     * @return void
     */
    public function testSetGetCopyImages()
    {
        $this->fileUploadTrait->setCopyImages($copyImages = true);
        $this->assertSame($copyImages, $this->fileUploadTrait->hasCopyImages());
    }

    /**
     * Test the set/getMediaDir() methods.
     *
     * @return void
     */
    public function testSetGetMediaDir()
    {
        $this->fileUploadTrait->setMediaDir($mediaDir = 'var/importexport/media');
        $this->assertSame($mediaDir, $this->fileUploadTrait->getMediaDir());
    }

    /**
     * Test the set/getImagesFileDir() methods.
     *
     * @return void
     */
    public function testSetGetImagesFileDir()
    {
        $this->fileUploadTrait->setImagesFileDir($imagesFileDir = 'pub/images');
        $this->assertSame($imagesFileDir, $this->fileUploadTrait->getImagesFileDir());
    }

    /**
     * Test the getNewFileName() method when the file not already exists.
     *
     * @return void
     */
    public function testGetNewFileNameWithNotExistingFile()
    {

        // initialize old and new filename
        $targetFilename = 'pub/media/images/test.jpg';
        $expectedFilename = basename($targetFilename);

        // mock the filesystem
        $mockFilesystem = $this->getMockBuilder('TechDivision\Import\Adapter\FilesystemAdapterInterface')
                               ->setMethods(get_class_methods('TechDivision\Import\Adapter\FilesystemAdapterInterface'))
                               ->getMock();
        $mockFilesystem->expects($this->once())
                       ->method('isFile')
                       ->with($targetFilename)
                       ->willReturn(false);

        // set the mock filesystem
        $this->fileUploadTrait->setFilesystemAdapter($mockFilesystem);

        // query whether or not the new file name is the same as the passed one
        $this->assertSame($expectedFilename, $this->fileUploadTrait->getNewFileName($targetFilename));
    }

    /**
     * Test the getNewFileName() method when the file already exists.
     *
     * @return void
     */
    public function testGetNewFileNameWithExistingFile()
    {

        // initialize old and new filename
        $targetFilename = 'pub/media/images/test.jpg';
        $expectedFilename = 'test_1.jpg';

        // mock the filesystem
        $mockFilesystem = $this->getMockBuilder('TechDivision\Import\Adapter\FilesystemAdapterInterface')
                               ->setMethods(get_class_methods('TechDivision\Import\Adapter\FilesystemAdapterInterface'))
                               ->getMock();
        $mockFilesystem->expects($this->exactly(3))
                       ->method('isFile')
                       ->withConsecutive(
                           array($targetFilename),
                           array($targetFilename),
                           array('pub/media/images/test_1.jpg')
                       )
                       ->willReturnOnConsecutiveCalls(true, true, false);

        // set the mock filesystem
        $this->fileUploadTrait->setFilesystemAdapter($mockFilesystem);

        // query whether or not the new file name is the same as the passed one
        $this->assertSame($expectedFilename, $this->fileUploadTrait->getNewFileName($targetFilename));
    }

    /**
     * Test the uploadFile() method.
     *
     * @return void
     */
    public function testUploadFile()
    {

        // set media + images file directory
        $this->fileUploadTrait->setMediaDir($mediaDir = 'var/importexport/media');
        $this->fileUploadTrait->setImagesFileDir($imagesFileDir = 'pub/images');

        // prepare basename, filename and the name of the uploaded file
        $basename = '/a/b/test.jpg';
        $filename = sprintf('%s%s', $imagesFileDir, $basename);
        $uploadedFilename = sprintf('%s%s', $mediaDir, $basename);

        // mock the filesystem and its methods
        $mockFilesystem = $this->getMockBuilder('TechDivision\Import\Adapter\FilesystemAdapterInterface')
                               ->setMethods(get_class_methods('TechDivision\Import\Adapter\FilesystemAdapterInterface'))
                               ->getMock();
        $mockFilesystem->expects($this->exactly(2))
                        ->method('isFile')
                        ->withConsecutive(
                            array($filename),
                            array($uploadedFilename)
                        )
                        ->willReturnOnConsecutiveCalls(true, false);
        $mockFilesystem->expects($this->once())
                       ->method('copy')
                       ->with($filename, $uploadedFilename)
                       ->willReturn(null);

        // set the mock filesystem
        $this->fileUploadTrait->setFilesystemAdapter($mockFilesystem);

        // query whether or not the uploaded file has the expected name
        $this->assertSame($basename, $this->fileUploadTrait->uploadFile($basename));
    }

    /**
     * Test the uploadFile() method with a not existing file.
     *
     * @return void
     */
    public function testUploadFileWithNotExistingFile()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Media file "pub/images/a/b/test.jpg" is not available');

        // set media + images file directory
        $this->fileUploadTrait->setMediaDir('var/importexport/media');
        $this->fileUploadTrait->setImagesFileDir($imagesFileDir = 'pub/images');

        // prepare basename, filename and the name of the uploaded file
        $basename = '/a/b/test.jpg';
        $filename = sprintf('%s%s', $imagesFileDir, $basename);

        // mock the filesystem and its methods
        $mockFilesystem = $this->getMockBuilder('TechDivision\Import\Adapter\FilesystemAdapterInterface')
                               ->setMethods(get_class_methods('TechDivision\Import\Adapter\FilesystemAdapterInterface'))
                               ->getMock();
        $mockFilesystem->expects($this->once())
                       ->method('isFile')
                       ->with($filename)
                       ->willReturn(false);

        // set the mock filesystem
        $this->fileUploadTrait->setFilesystemAdapter($mockFilesystem);

        // query whether or not the uploaded file has the expected name
        $this->fileUploadTrait->uploadFile($basename);
    }
}
