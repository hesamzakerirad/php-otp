<?php

namespace HesamRad\Otp;

abstract class Otp
{
    public abstract function generate(): string;

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
