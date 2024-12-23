<?php
use PHPUnit\Framework\TestCase;

class VideoUploadTest extends TestCase
{
    private $mockConn;
    private $mockStmt;

    protected function setUp(): void
    {
        // Mocking the database connection
        $this->mockConn = $this->createMock(mysqli::class);

        // Mocking the prepared statement
        $this->mockStmt = $this->createMock(mysqli_stmt::class);

        $this->mockConn->method('prepare')->willReturn($this->mockStmt);
        $this->mockStmt->method('bind_param')->willReturn(true);
        $this->mockStmt->method('execute')->willReturn(true);
    }

    public function testUploadValidVideo()
    {
        // Mock valid $_FILES and $_POST data
        $_FILES['video_thumbnail'] = [
            'name' => 'thumbnail.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/php12345',
            'error' => 0,
            'size' => 4000000,
        ];

        $_FILES['video'] = [
            'name' => 'video.mp4',
            'type' => 'video/mp4',
            'tmp_name' => '/tmp/php54321',
            'error' => 0,
            'size' => 30000000,
        ];

        $_POST['video_title'] = 'Test Video';
        $_POST['addvideo'] = 'addvideo';

        // Mock file handling
        $this->assertTrue(move_uploaded_file($_FILES['video_thumbnail']['tmp_name'], 'images/video/thumbnail.jpg'));
        $this->assertTrue(move_uploaded_file($_FILES['video']['tmp_name'], 'videos/watch/video.mp4'));

        // Mock database insertion
        $this->mockStmt->expects($this->once())->method('execute')->willReturn(true);

        // Call the function and assert
        $this->expectOutputRegex('/The video has been uploaded successfully\./');

        include 'path/to/your/upload/script.php';
    }

    public function testInvalidThumbnailSize()
    {
        $_FILES['video_thumbnail'] = [
            'name' => 'thumbnail.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/php12345',
            'error' => 0,
            'size' => 6000000, // Exceeds 5MB limit
        ];

        $_POST['addvideo'] = 'addvideo';

        // Call the function and assert
        $this->expectOutputRegex('/Sorry, your thumbnail file is too large\./');

        include 'path/to/your/upload/script.php';
    }

    public function testInvalidVideoFormat()
    {
        $_FILES['video'] = [
            'name' => 'video.txt',
            'type' => 'text/plain',
            'tmp_name' => '/tmp/php12345',
            'error' => 0,
            'size' => 1000,
        ];

        $_POST['addvideo'] = 'addvideo';

        // Call the function and assert
        $this->expectOutputRegex('/Sorry, only MP4, AVI, MKV, MOV & WMV files are allowed for video\./');

        include 'path/to/your/upload/script.php';
    }

    public function testDatabaseInsertionError()
    {
        $_FILES['video_thumbnail'] = [
            'name' => 'thumbnail.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/php12345',
            'error' => 0,
            'size' => 4000000,
        ];

        $_FILES['video'] = [
            'name' => 'video.mp4',
            'type' => 'video/mp4',
            'tmp_name' => '/tmp/php54321',
            'error' => 0,
            'size' => 30000000,
        ];

        $_POST['video_title'] = 'Test Video';
        $_POST['addvideo'] = 'addvideo';

        // Mock database error
        $this->mockStmt->method('execute')->willReturn(false);
        $this->mockStmt->method('error')->willReturn('Database error');

        // Call the function and assert
        $this->expectOutputRegex('/Error: Database error/');

        include 'path/to/your/upload/script.php';
    }

    protected function tearDown(): void
    {
        unset($_FILES);
        unset($_POST);
    }
}
?>
