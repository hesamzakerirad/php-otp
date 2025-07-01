<?php

namespace HesamRad\Otp\Tests;

class OtpTest extends TestCase
{
    public function test_totp_is_generated()
    {
        $totp = new \HesamRad\Otp\Totp(
            '01010101',
            0,
        );

        $otp = $totp->generate();

        return $this->assertNotEmpty($otp);
    }

    public function test_hotp_is_generated()
    {
        $hotp = new \HesamRad\Otp\Hotp(
            '01010101',
            0,
        );

        $otp = $hotp->generate();

        return $this->assertNotEmpty($otp);
    }
}