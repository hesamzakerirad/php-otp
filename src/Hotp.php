<?php 

namespace HesamRad\Otp;

class Hotp implements Otp
{
    public function __construct(
        private string $secret,
        private string $counter,
        private int $numberOfDigits = 6
    ) {
        //
    }

    public function generate(): string
    {
        $code = 0;

        // implementation

        return $code;
    }
}