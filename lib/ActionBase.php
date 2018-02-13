<?php

namespace lib;

class ActionBase implements Action
{
    public static function get()
    {
        self::methodNotAllowed();
    }

    public static function post()
    {
        self::methodNotAllowed();
    }

    public static function __callStatic($name, $arguments)
    {
        // Cover any weird methods that may get called (OPTIONS, HEAD, etc...)
        self::methodNotAllowed();
    }

    public static function methodNotAllowed()
    {
        header("HTTP/1.1 405 Method Not Allowed");
        exit("Method Not Allowed");
    }
}
