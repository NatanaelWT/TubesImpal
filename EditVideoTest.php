<?php

use PHPUnit\Framework\TestCase;

class EditVideoTest extends TestCase
{
    private $mockDatabase;
    private $mockStatement;

    protected function setUp(): void
    {
        // Mock database connection
        $this->mockDatabase = $this->createMock(mysqli::class);

        // Mock prepared statement
        $this->mockStatement = $this->createMock(mysqli_stmt::class);
        $this->mockDatabase->method('prepare')->willReturn($this->mockStatement);
    }

    public function testUpdateVideoTitle()
    {
        // Mock successful execution of the statement
        $this->mockStatement->method('execute')->willReturn(true);

        $this->mockStatement->expects($this->once())
            ->method('bind_param')
            ->with('si', 'Updated Video Title', 1);

        // Execute test
        $sql = "UPDATE videos SET video_title = ? WHERE id_video = ?";
        $this->mockStatement->execute();

        $this->assertTrue($this->mockStatement->execute());
    }

    public function testUploadThumbnail()
    {
        // Simulate file upload data
        $_FILES['video_thumbnail'] = [
            'name' => 'test_thumbnail.jpg',
            'tmp_name' => '/tmp/phpYzdqkD',
            'size' => 4000000,
            'error' => 0,
        ];

        $thumbnailDir = "images/video/";
        $fileType = pathinfo($_FILES['video_thumbnail']['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('thumb_', true) . '.' . $fileType;

        $this->assertTrue(in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']));
        $this->assertLessThanOrEqual(5000000, $_FILES['video_thumbnail']['size']);
        $this->assertTrue(move_uploaded_file($_FILES['video_thumbnail']['tmp_name'], $thumbnailDir . $uniqueName));
    }

    public function testUploadVideo()
    {
        // Simulate file upload data
        $_FILES['video'] = [
            'name' => 'test_video.mp4',
            'tmp_name' => '/tmp/phpYzdqkD',
            'size' => 40000000,
            'error' => 0,
        ];

        $videoDir = "videos/watch/";
        $fileType = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('video_', true) . '.' . $fileType;

        $this->assertTrue(in_array($fileType, ['mp4', 'avi', 'mkv', 'mov', 'wmv']));
        $this->assertLessThanOrEqual(50000000, $_FILES['video']['size']);
        $this->assertTrue(move_uploaded_file($_FILES['video']['tmp_name'], $videoDir . $uniqueName));
    }

    public function testUpdateVideoWithAllFields()
    {
        // Mock successful execution of the statement
        $this->mockStatement->method('execute')->willReturn(true);

        // Bind parameters (video_title, thumbnail, video, id_video)
        $this->mockStatement->expects($this->once())
            ->method('bind_param')
            ->with('sssi', 'Updated Title', 'thumb_123.jpg', 'video_456.mp4', 1);

        $sql = "UPDATE videos SET video_title = ?, video_thumbnail = ?, video = ? WHERE id_video = ?";
        $this->mockStatement->execute();

        $this->assertTrue($this->mockStatement->execute());
    }
}
