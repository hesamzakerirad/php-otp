<?php

namespace HesamRad\Otp\Tests;

class HotpTest extends TestCase
{
    public function test_hotp_generates_valid_results()
    {
        $expected = '757479';

        $hotp = new \HesamRad\Otp\Hotp(
            secret: 'JBSWY3DPEHPK3PXA',
            counter: 0,
            numberOfDigits: 6,
            algorithm: 'sha1'
        );

        $result = $hotp->generate();

        $this->assertEquals($expected, $result);
    }

    public function test_different_hashing_algorithms_generate_different_results()
    {
        $secret = random_bytes(20);
        $counter = 0;
        $numberOfDigits = 6;

        $firstHotp = (new \HesamRad\Otp\Hotp(
            secret: $secret,
            counter: $counter,
            numberOfDigits: $numberOfDigits,
            algorithm: 'sha1',
        ))->generate();

        $secondHotp = (new \HesamRad\Otp\Hotp(
            secret: $secret,
            counter: $counter,
            numberOfDigits: $numberOfDigits,
            algorithm: 'sha256',
        ))->generate();

        $this->assertNotEquals($firstHotp, $secondHotp);
    }

    public function test_different_counters_generate_different_results()
    {
        $secret = random_bytes(20);

        $firstHotp = new \HesamRad\Otp\Hotp(
            secret: $secret,
            counter: 1,
        );

        $secondHotp = new \HesamRad\Otp\Hotp(
            secret: $secret,
            counter: 2,
        );

        $this->assertNotEquals($firstHotp, $secondHotp);
    }

    public function test_hotp_length_is_correct()
    {
        $firstHotp = (new \HesamRad\Otp\Hotp(
            secret: random_bytes(20),
            counter: random_int(0, 20),
            numberOfDigits: 6
        ))->generate();

        $secondHotp = (new \HesamRad\Otp\Hotp(
            secret: random_bytes(20),
            counter: random_int(0, 20),
            numberOfDigits: 8
        ))->generate();

        $this->assertEquals(strlen($firstHotp), 6);
        $this->assertEquals(strlen($secondHotp), 8);
    }
}
