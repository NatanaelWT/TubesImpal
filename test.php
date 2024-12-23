<?php

use PHPUnit\Framework\TestCase;

class PlaylistFormTest extends TestCase
{
    private $mockConn;

    protected function setUp(): void
    {
        // Create a mock of the database connection
        $this->mockConn = $this->createMock(mysqli::class);
    }

    public function testValidImageUpload()
    {
        $_FILES['thumbnail'] = [
            'name' => 'test_image.jpg',
            'tmp_name' => '/tmp/phpYzdqkD',
            'size' => 400000,
            'type' => 'image/jpeg',
            'error' => 0,
        ];

        // Mock image check and move_uploaded_file behavior
        $this->assertTrue(getimagesize($_FILES['thumbnail']['tmp_name']) !== false, "Image check failed");
        $this->assertTrue($_FILES['thumbnail']['size'] <= 5000000, "File size is too large");
        $this->assertEquals('jpg', strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION)), "File type not allowed");
    }

    public function testDatabaseInsertion()
    {
        // Mock $_POST data
        $_POST = [
            'playlist_name' => 'Test Playlist',
            'description' => 'This is a test playlist.',
        ];

        $mockStmt = $this->createMock(mysqli_stmt::class);

        // Set expectations for prepared statement
        $mockStmt->expects($this->once())
            ->method('bind_param')
            ->with(
                $this->equalTo('isss'),
                $this->equalTo(1), // Assuming user_id is 1
                $this->equalTo($_POST['playlist_name']),
                $this->equalTo($_POST['description']),
                $this->anything() // Thumbnail name will vary
            )
            ->willReturn(true);

        $mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->mockConn->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('INSERT INTO playlists'))
            ->willReturn($mockStmt);

        // Mock data insertion
        $stmt = $this->mockConn->prepare("INSERT INTO playlists (id_teacher, playlist_name, description, thumbnail) VALUES (?, ?, ?, ?)");
        $result = $stmt->bind_param('isss', 1, $_POST['playlist_name'], $_POST['description'], 'unique_image_name.jpg');
        $this->assertTrue($result);

        $execution = $stmt->execute();
        $this->assertTrue($execution);
    }

    public function testInvalidImageUpload()
    {
        $_FILES['thumbnail'] = [
            'name' => 'invalid_file.txt',
            'tmp_name' => '/tmp/phpYzdqkD',
            'size' => 400000,
            'type' => 'text/plain',
            'error' => 0,
        ];

        $this->assertFalse(getimagesize($_FILES['thumbnail']['tmp_name']), "Image check should fail");
    }

    protected function tearDown(): void
    {
        unset($this->mockConn);
    }
}
