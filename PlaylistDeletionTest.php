<?php

use PHPUnit\Framework\TestCase;

class PlaylistDeletionTest extends TestCase
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

    public function testSuccessfulPlaylistDeletion()
    {
        $playlistId = 3;

        // Mock behaviors for a successful deletion
        $this->mockStatement->method('bind_param')->willReturn(true);
        $this->mockStatement->method('execute')->willReturn(true);

        // Simulate database delete query
        $this->mockDatabase->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('DELETE FROM playlists where id_playlist = ?'))
            ->willReturn($this->mockStatement);

        // Simulate parameter binding and execution
        $this->mockStatement->expects($this->once())
            ->method('bind_param')
            ->with($this->equalTo('i'), $this->equalTo($playlistId))
            ->willReturn(true);

        $this->mockStatement->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        // Assert the deletion was successful
        $stmt = $this->mockDatabase->prepare("DELETE FROM playlists where id_playlist = ?");
        $result = $stmt->bind_param('i', $playlistId);
        $this->assertTrue($result);

        $execution = $stmt->execute();
        $this->assertTrue($execution);
    }

    public function testDeletionWithInvalidId()
    {
        $playlistId = -1; // Invalid ID

        // Mock behaviors for a failed deletion
        $this->mockStatement->method('bind_param')->willReturn(true);
        $this->mockStatement->method('execute')->willReturn(false);
        $this->mockStatement->method('error')->willReturn('Invalid playlist ID');

        // Simulate database delete query
        $this->mockDatabase->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('DELETE FROM playlists where id_playlist = ?'))
            ->willReturn($this->mockStatement);

        // Simulate parameter binding and execution
        $this->mockStatement->expects($this->once())
            ->method('bind_param')
            ->with($this->equalTo('i'), $this->equalTo($playlistId))
            ->willReturn(true);

        $this->mockStatement->expects($this->once())
            ->method('execute')
            ->willReturn(false);

        // Assert the deletion failed
        $stmt = $this->mockDatabase->prepare("DELETE FROM playlists where id_playlist = ?");
        $result = $stmt->bind_param('i', $playlistId);
        $this->assertTrue($result);

        $execution = $stmt->execute();
        $this->assertFalse($execution);
        $this->assertEquals('Invalid playlist ID', $this->mockStatement->error);
    }

    protected function tearDown(): void
    {
        unset($this->mockDatabase);
        unset($this->mockStatement);
    }
}
