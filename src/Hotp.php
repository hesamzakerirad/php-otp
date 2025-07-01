<?php

namespace HesamRad\Otp;

class Hotp extends Otp
{
    /**
     * Create a new HOTP instance.
     * 
     * @param string $secret
     * @param string $counter
     * @param int $numberOfDigits
     * @return void
     */
    public function __construct(
        protected string $secret,
        protected string $counter,
        protected int $numberOfDigits = 6
    ) {
        parent::__construct($secret, $counter, $numberOfDigits);
    }
}
