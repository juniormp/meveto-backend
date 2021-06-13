<?php


namespace Tests\Helper;


class CleanString
{
    public static function clean(string $string): string
    {
        return preg_replace("/\r|\n/", "", $string);
    }
}
