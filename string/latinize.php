<?php

function latinize($str) {
    $chars = [
        ["ç", "c"],
        ["ğ", "g"],
        ["ı", "i"],
        ["i̇", "i"],
        ["ö", "o"],
        ["ş", "s"],
        ["ü", "u"],
        ["ü", "u"],
        ["Ç", "C"],
        ["Ğ", "G"],
        ["İ", "I"],
        ["Ö", "O"],
        ["Ş", "S"],
        ["Ü", "U"],
    ];
    foreach ($chars as $char) {
        $str = str_replace($char[0], $char[1], $str);
    }
    return $str;
}