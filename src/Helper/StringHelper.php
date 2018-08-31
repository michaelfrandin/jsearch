<?php

namespace Json\DB\Helper;

class StringHelper
{
    public static function stripAccents($str) {
        setlocale(LC_ALL, "en_US.utf8");
        $output = iconv("utf-8", "ascii//TRANSLIT", $str);

        return $output;
    }
}