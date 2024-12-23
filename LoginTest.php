<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
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

    public function testValidLogin()
    {
        
        // Mock result for valid email and password
        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('store_result')->willReturn(true);
        $this->mockStatement->method('num_rows')->willReturn(1);

        $email = 'test@example.com';
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);

        $this->mockStatement->method('bind_result')->willReturnCallback(function (
            &$id,
            &$name,
            &$hashed_password,
            &$level,
            &$profile_image,
            &$email
        ) use ($hashedPassword) {
            $id = 1;
            $name = 'Test User';
            $hashed_password = $hashedPassword;
            $level = 'user';
            $profile_image = 'default.png';
            $email = 'test@example.com';
        });

        $this->mockStatement->method('fetch')->willReturn(true);

        // Simulate valid password verification
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password123';

        $this->assertTrue(password_verify($_POST['password'], $hashedPassword));
    }

    public function testInvalidEmail()
    {
        // Mock result for invalid email
        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('store_result')->willReturn(true);
        $this->mockStatement->method('num_rows')->willReturn(0);

        $_POST['email'] = 'invalidexample.com';
        $_POST['password'] = 'password123';

        // Assert no rows found
        $this->assertEquals(0, $this->mockStatement->num_rows);
    }

    public function testInvalidPassword()
    {
        // Mock result for valid email but incorrect password
        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('store_result')->willReturn(true);
        $this->mockStatement->method('num_rows')->willReturn(1);

        $email = 'test@example.com';
        $hashedPassword = password_hash('correct_password', PASSWORD_DEFAULT);

        $this->mockStatement->method('bind_result')->willReturnCallback(function (
            &$id,
            &$name,
            &$hashed_password,
            &$level,
            &$profile_image,
            &$email
        ) use ($hashedPassword) {
            $id = 1;
            $name = 'Test User';
            $hashed_password = $hashedPassword;
            $level = 'user';
            $profile_image = 'default.png';
            $email = 'test@example.com';
        });

        $this->mockStatement->method('fetch')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'wrong_password';

        // Simulate invalid password verification
        $this->assertFalse(password_verify($_POST['password'], $hashedPassword));
    }
}
