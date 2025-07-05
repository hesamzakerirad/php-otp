<?php

namespace HesamRad\Otp;

use HesamRad\Otp\Exceptions\UnsupportedAlgorithmException;

class Otp
{
    /**
     * Create a new OTP instance.
     *
     * @param string $secret
     * @param string $counter
     * @param int $numberOfDigits
     * @param string $algorithm
     */
    public function __construct(
        protected string $secret,
        protected string $counter,
        protected int $numberOfDigits,
        protected string $algorithm,
    ) {
        if (! $this->isAlgorithmSupported($algorithm)) {
            throw new UnsupportedAlgorithmException();
        }
    }

    /**
     * Generate a new OTP code.
     *
     * This OTP code can either be TOTP or HOTP.
     *
     * @return string
     */
    public function generate()
    {
        $counterBinary = pack('N*', 0) . pack('N*', $this->counter);

        $hash = hash_hmac($this->algorithm, $counterBinary, $this->getSecret(), true);
        $offset = ord($hash[19]) & 0x0F;

        $truncatedHash = unpack('N', substr($hash, $offset, 4))[1] & 0x7fffffff;
        $otp = $truncatedHash % pow(10, $this->numberOfDigits);

        return str_pad((string) $otp, $this->numberOfDigits, '0', STR_PAD_LEFT);
    }

    /**
     * Encode the given string into base32 format.
     *
     * @param string $b32
     * @return string
     */
    private function base32Encode(string $b32)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $binaryString = '';
        $bytes = '';

        foreach (str_split($b32) as $char) {
            $index = strpos($alphabet, $char);

            if ($index === false) {
                continue;
            }

            $binaryString .= str_pad(decbin($index), 5, '0', STR_PAD_LEFT);
        }

        foreach (str_split($binaryString, 8) as $byte) {
            if (strlen($byte) < 8) {
                continue;
            }

            $bytes .= chr(bindec($byte));
        }

        return $bytes;
    }

    /**
     * Check if given algorithm is supported to generate OTP.
     *
     * @param string $algorithm
     * @return bool
     */
    private function isAlgorithmSupported($algorithm): bool
    {
        return in_array(strtolower($algorithm), hash_hmac_algos());
    }

    /**
     * Return base32 encoded secret.
     *
     * @return string
     */
    private function getSecret(): string
    {
        return $this->base32Encode($this->secret);
    }
}
