<?php

namespace lib;

class Util
{
    public static function fromQuery(string $name)
    {
        return self::param($_GET, $name);
    }

    public static function allFromQuery(string ...$names)
    {
        return self::params($_GET, $names);
    }

    public static function fromPost(string $name)
    {
        return self::param($_POST, $name);
    }

    public static function allFromPost(string ...$names)
    {
        return self::params($_POST, $names);
    }

    private static function param(array &$array, string $name)
    {
        return isset($array[$name]) ? $array[$name] : null;
    }

    private static function params(array &$array, array $names)
    {
        return array_map(
            function ($name) use ($array) {
                return self::param($array, $name);
            },
            $names);
    }
}
