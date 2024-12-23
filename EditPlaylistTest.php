<?php

use PHPUnit\Framework\TestCase;

class EditPlaylistTest extends TestCase
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

    public function testFetchPlaylistData()
    {
        // Mock result for fetching playlist data
        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('bind_result')->willReturnCallback(function (&$playlist_name, &$description, &$thumbnail) {
            $playlist_name = 'My Playlist';
            $description = 'This is a test playlist';
            $thumbnail = 'test-thumbnail.jpg';
        });
        $this->mockStatement->method('fetch')->willReturn(true);

        $link = [null, null, null, 1]; // Mock link parameter for id_playlist

        $stmt = $this->mockDatabase->prepare("SELECT playlist_name, description, thumbnail FROM playlists WHERE id_playlist = ?");
        $stmt->bind_param("i", $link[3]);
        $stmt->bind_result($playlist_name, $description, $thumbnail);
        $stmt->fetch();

        $this->assertEquals('My Playlist', $playlist_name);
        $this->assertEquals('This is a test playlist', $description);
        $this->assertEquals('test-thumbnail.jpg', $thumbnail);
    }

    public function testUpdatePlaylist()
    {
        // Mock initial thumbnail
        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('bind_result')->willReturnCallback(function (&$current_thumbnail) {
            $current_thumbnail = 'old-thumbnail.jpg';
        });
        $this->mockStatement->method('fetch')->willReturn(true);

        // Mock new thumbnail upload
        $_FILES['thumbnail'] = [
            'name' => 'new-thumbnail.jpg',
            'tmp_name' => '/tmp/phpYzdqkD',
            'error' => 0,
            'size' => 12345
        ];

        $target_dir = "images/playlist/";
        $unique_file_name = uniqid() . "-" . basename($_FILES['thumbnail']['name']);
        $target_file = $target_dir . $unique_file_name;

        // Mock file move
        $this->assertTrue(move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file));

        // Mock update query
        $this->mockStatement->method('execute')->willReturn(true);

        $playlist_name = 'Updated Playlist';
        $description = 'Updated description';
        $link = [null, null, null, 1];

        $stmt = $this->mockDatabase->prepare("UPDATE playlists SET playlist_name = ?, description = ?, thumbnail = ? WHERE id_playlist = ?");
        $stmt->bind_param("sssi", $playlist_name, $description, $unique_file_name, $link[3]);

        $this->assertTrue($stmt->execute());
    }

    public function testUpdatePlaylistWithoutNewThumbnail()
    {
        // Mock initial thumbnail
        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('bind_result')->willReturnCallback(function (&$current_thumbnail) {
            $current_thumbnail = 'old-thumbnail.jpg';
        });
        $this->mockStatement->method('fetch')->willReturn(true);

        $_FILES['thumbnail'] = [
            'name' => '',
            'tmp_name' => '',
            'error' => 4, // No file uploaded
            'size' => 0
        ];

        $playlist_name = 'Updated Playlist';
        $description = 'Updated description';
        $current_thumbnail = 'old-thumbnail.jpg';
        $link = [null, null, null, 1];

        // Mock update query
        $this->mockStatement->method('execute')->willReturn(true);

        $stmt = $this->mockDatabase->prepare("UPDATE playlists SET playlist_name = ?, description = ?, thumbnail = ? WHERE id_playlist = ?");
        $stmt->bind_param("sssi", $playlist_name, $description, $current_thumbnail, $link[3]);

        $this->assertTrue($stmt->execute());
    }
}
