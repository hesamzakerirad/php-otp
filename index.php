<?php

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

use HesamRad\Otp\Totp;

$totp = new Totp(
    'sdfsfdf',
    0,
);

var_dump($totp->generate());