<?php

namespace lib;

class Util
{
    public static function encloseScript($_file, $_args = [])
    {
        extract($_args);
        return require $_file;
    }
}
