<?php

function url_friendly($str) {
    $replace = [
        ["-", " "],
        ["—", " "],
        [" & ", " and "],
        ["&", " "],
    ];
    $remove = [
        "<", ">", ":", "\"", "/", "\\", "|", "?", "*", "'", "¦"
    ];
    $str = latinize($str);
    $str = strtolower($str);
    foreach ($replace as $char) {
        $str = str_replace($char[0], $char[1], $str);
    }
    foreach ($remove as $char) {
        $str = str_replace($char, "", $str);
    }
    $str = preg_split("/\s+/", $str);
    return implode("-", $str);
}