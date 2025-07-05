<?php

namespace HesamRad\Otp;

class Totp extends Otp
{
    /**
     * Create a new TOTP instance.
     *
     * @param string $secret
     * @param int $startingPoint
     * @param int $interval
     * @param int $numberOfDigits
     * @param string $algorithm
     * @return void
     */
    public function __construct(
        protected string $secret,
        protected int $startingPoint,
        protected int $interval = 30,
        protected int $numberOfDigits = 6,
        protected string $algorithm = 'sha1',
    ) {
        $counter = floor((time() - $this->startingPoint) / $this->interval);

        parent::__construct($secret, $counter, $numberOfDigits, $algorithm);
    }
}
