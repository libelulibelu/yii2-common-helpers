<?php

namespace Libelula\CommonHelpers;

class StringHelpers
{

    /**
     * Repeat a value; if multiple is less than 0, repeat nothing
     */
    public static function repeat(string $value, int $multiple)
    {
        return str_repeat($value, $multiple > 0 ? $multiple : 0);
    }

    /**
     * String contains a value
     */
    public static function contains(string $value, string $needed)
    {
        return strpos($value, $needed) !== false;
    }
}
