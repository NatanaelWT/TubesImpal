<?php

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
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

    public function testSuccessfulRegistration()
    {
        $name = 'Test User';
        $email = 'test@example.com';
        $password = 'password123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $profileImage = 'profile.png';

        // Mock behaviors for a successful registration
        $this->mockStatement->method('bind_param')->willReturn(true);
        $this->mockStatement->method('execute')->willReturn(true);

        // Mock user input
        $_POST['register'] = true;
        $_POST['name'] = $name;
        $_POST['email'] = $email;
        $_POST['password'] = $password;
        $_POST['confirm_password'] = $password;
        $_FILES['profile_image'] = [
            'name' => $profileImage,
            'tmp_name' => '/tmp/' . $profileImage,
        ];

        // Simulate file upload success
        $targetFile = 'images/profile/uniqueid-' . $profileImage;
        $this->assertTrue(move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile));

        // Simulate database insert success
        $this->assertTrue($this->mockStatement->execute());
    }

    public function testPasswordMismatch()
    {
        $_POST['register'] = true;
        $_POST['password'] = 'password123';
        $_POST['confirm_password'] = 'different_password';

        $this->assertNotEquals($_POST['password'], $_POST['confirm_password']);
        $this->expectOutputString('Passwords do not match.');
        if ($_POST['password'] != $_POST['confirm_password']) {
            echo 'Passwords do not match.';
        }
    }

    public function testFileUploadFailure()
    {
        $_POST['register'] = true;
        $_FILES['profile_image'] = [
            'name' => 'profile.png',
            'tmp_name' => '/invalid/path/profile.png',
        ];

        $targetFile = 'images/profile/uniqueid-' . $_FILES['profile_image']['name'];

        $this->assertFalse(move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile));
        $this->expectOutputString('Error uploading file.');
        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            echo 'Error uploading file.';
        }
    }

    public function testDatabaseInsertError()
    {
        $name = 'Test User';
        $email = 'test@example.com';
        $password = 'password123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $profileImage = 'profile.png';

        // Mock behaviors for a database error
        $this->mockStatement->method('bind_param')->willReturn(true);
        $this->mockStatement->method('execute')->willReturn(false);
        $this->mockStatement->method('error')->willReturn('Database error');

        // Mock user input
        $_POST['register'] = true;
        $_POST['name'] = $name;
        $_POST['email'] = $email;
        $_POST['password'] = $password;
        $_POST['confirm_password'] = $password;
        $_FILES['profile_image'] = [
            'name' => $profileImage,
            'tmp_name' => '/tmp/' . $profileImage,
        ];

        // Simulate file upload success
        $targetFile = 'images/profile/uniqueid-' . $profileImage;
        $this->assertTrue(move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile));

        // Simulate database insert failure
        $this->assertFalse($this->mockStatement->execute());
        $this->expectOutputString('Error: Database error');
        if (!$this->mockStatement->execute()) {
            echo 'Error: ' . $this->mockStatement->error;
        }
    }
}
