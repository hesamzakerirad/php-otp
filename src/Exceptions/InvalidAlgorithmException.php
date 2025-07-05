<?php

namespace HesamRad\Otp\Exceptions;

class UnsupportedAlgorithmException extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            message: 'Unsupported algorithm! Please change to either `sha1`, `sha256` or `sha512`',
        );
    }
}
