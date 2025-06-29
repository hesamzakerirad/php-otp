<?php

namespace HesamRad\Otp;

class Totp implements Otp
{
    public function __construct(
        private string $secret,
        private int $startingPoint,
        private int $interval = 30,
        private int $numberOfDigits = 6,
    ) {
        //
    }

    public function generate(): string
    {
        $counter = floor((time() - $this->startingPoint) / $this->interval);
        $counterBinary = pack('N*', 0) . pack('N*', $counter); // 8-byte big-endian

        $key = $this->base32_decode($this->secret); // You'll need to implement base32 decode
        $hash = hash_hmac('sha1', $counterBinary, $key, true);

        $offset = ord($hash[19]) & 0x0F;
        $truncatedHash = unpack("N", substr($hash, $offset, 4))[1] & 0x7fffffff;

        $otp = $truncatedHash % pow(10, $this->numberOfDigits);
        return str_pad((string)$otp, $this->numberOfDigits, '0', STR_PAD_LEFT);
    }

    function base32_decode($b32)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $binaryString = '';
        foreach (str_split($b32) as $char) {
            $index = strpos($alphabet, $char);
            if ($index === false)
                continue;
            $binaryString .= str_pad(decbin($index), 5, '0', STR_PAD_LEFT);
        }

        $bytes = '';
        foreach (str_split($binaryString, 8) as $byte) {
            if (strlen($byte) < 8)
                continue;
            $bytes .= chr(bindec($byte));
        }

        return $bytes;
    }

}