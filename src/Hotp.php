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
     * @param string $algorithm
     * @return void
     */
    public function __construct(
        protected string $secret,
        protected string $counter,
        protected int $numberOfDigits = 6,
        protected string $algorithm = 'sha1'
    ) {
        parent::__construct($secret, $counter, $numberOfDigits, $algorithm);
    }
}
