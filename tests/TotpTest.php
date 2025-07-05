<?php

namespace HesamRad\Otp\Tests;

use Symfony\Bridge\PhpUnit\ClockMock;

class TotpTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ClockMock::register(\HesamRad\Otp\Totp::class);
    }

    public function test_totp_generates_valid_results()
    {
        ClockMock::withClockMock(1751315400);

        $totp = (new \HesamRad\Otp\Totp(
            secret: 'JBSWY3DPEHPK3PXA',
            startingPoint: '1751315400',
            interval: 30,
            numberOfDigits: 6
        ))->generate();

        $this->assertEquals('757479', $totp);
    }

    public function test_different_hashing_algorithms_generate_different_results()
    {
        ClockMock::withClockMock(1751315400);

        $secret = random_bytes(20);
        $startingPoint = '1751315400';
        $numberOfDigits = 6;

        $firstTotp = new \HesamRad\Otp\Totp(
            secret: $secret,
            startingPoint: $startingPoint,
            numberOfDigits: $numberOfDigits,
            algorithm: 'sha1',
        );

        $secondTotp = new \HesamRad\Otp\Totp(
            secret: $secret,
            startingPoint: $startingPoint,
            numberOfDigits: $numberOfDigits,
            algorithm: 'sha256',
        );

        $this->assertNotEquals($firstTotp, $secondTotp);
    }

    public function test_different_times_generate_different_results()
    {
        $secret = random_bytes(20);

        $firstTotp = (new \HesamRad\Otp\Totp(
            secret: $secret,
            startingPoint: 1751315300,
            interval: 30,
            numberOfDigits: 6
        ))->generate();

        $secondTotp = (new \HesamRad\Otp\Totp(
            secret: $secret,
            startingPoint: 1751315200,
            interval: 30,
            numberOfDigits: 6
        ))->generate();

        $this->assertNotEquals($firstTotp, $secondTotp);
    }

    public function test_totp_length_is_correct()
    {
        $firstTotp = (new \HesamRad\Otp\Totp(
            secret: random_bytes(20),
            startingPoint: random_int(0, 20),
            interval: 30,
            numberOfDigits: 6
        ))->generate();

        $secondTotp = (new \HesamRad\Otp\Totp(
            secret: random_bytes(20),
            startingPoint: random_int(0, 20),
            interval: 30,
            numberOfDigits: 8
        ))->generate();

        $this->assertEquals(strlen($firstTotp), 6);
        $this->assertEquals(strlen($secondTotp), 8);
    }
}
