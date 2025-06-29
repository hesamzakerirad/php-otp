<?php 

namespace HesamRad\Otp;

interface Otp
{
    public function generate(): string;
}