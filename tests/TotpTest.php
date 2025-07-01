<?php

namespace HesamRad\Otp\Tests;

class TotpTest extends TestCase
{
    public function test_totp_generates_valid_results()
    {

    }

    public function test_different_times_generate_different_results()
    {
        $secret = random_bytes(20);

        $firstTotp = new \HesamRad\Otp\Totp(
            secret: $secret,
            startingPoint: 1,
        );

        $secondTotp = new \HesamRad\Otp\Totp(
            secret: $secret,
            startingPoint: 2,
        );

        $this->assertNotEquals($firstTotp, $secondTotp);
    }

    public function test_totp_length_is_correct()
    {
        $firstTotp = (new \HesamRad\Otp\Totp(
            secret: random_bytes(20),
            startingPoint: random_int(0, 20),
            numberOfDigits: 6
        ))->generate();

        $secondTotp = (new \HesamRad\Otp\Totp(
            secret: random_bytes(20),
            startingPoint: random_int(0, 20),
            numberOfDigits: 8
        ))->generate();

        $this->assertEquals(strlen($firstTotp), 6);
        $this->assertEquals(strlen($secondTotp), 8);
    }
}
