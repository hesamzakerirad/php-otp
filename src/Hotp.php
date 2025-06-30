<?php

namespace HesamRad\Otp;

class Hotp extends Otp
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
        $counterBinary = pack('N*', 0) . pack('N*', $this->counter);
        $key = $this->base32_decode($this->secret);
        $hash = hash_hmac('sha1', $counterBinary, $key, true);

        $offset = ord($hash[19]) & 0x0F;
        $truncatedHash = unpack("N", substr($hash, $offset, 4))[1] & 0x7fffffff;

        $otp = $truncatedHash % pow(10, $this->numberOfDigits);
        return str_pad((string)$otp, $this->numberOfDigits, '0', STR_PAD_LEFT);
    }
}
