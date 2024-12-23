<?php

use PHPUnit\Framework\TestCase;

class DeleteVideoTest extends TestCase
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

    public function testDeleteVideo()
    {
        // Mock POST data
        $_POST['deletevideo'] = 'sample_playlist';

        // Simulate query execution for delete
        $this->mockStatement->method('execute')->willReturn(true);

        // Simulate deletion by verifying the query was executed correctly
        $this->mockDatabase->expects($this->once())
            ->method('query')
            ->with($this->stringContains("DELETE FROM videos where id_video ="));

        // Simulate the page redirection
        header("location:../playlist/" . $_POST['deletevideo']);

        // Assert redirection to correct URL
        $this->expectOutputString('location:../playlist/sample_playlist');
    }

    public function testDeleteVideoFailsWithoutPostData()
    {
        // Ensure that the mock query is not called if POST data is missing
        $this->mockDatabase->expects($this->never())
            ->method('query');

        // Simulate no POST data
        unset($_POST['deletevideo']);

        // Test that the page should not redirect if POST data is missing
        $this->expectOutputString('');
    }
}
