<?php

// https://en.wikipedia.org/wiki/Transliteration
// https://en.wikipedia.org/wiki/Romanization
// https://stackoverflow.com/a/34867642/2202732

function latinize(string $text) {
    $letterMap = array_merge([], LATINIZATION_MAP);
    regexifyLatinizationMap($letterMap);
    foreach ($letterMap as $targetChar => $cases) {
        $text = preg_replace($cases, $targetChar, $text);
    }
    return $text;
}

function regexifyLatinizationMap(&$letterMap) {
    foreach ($letterMap as $targetChar => $cases) {
        $cases = str_replace(" ", "|", $cases);
        $letterMap[$targetChar] = '/(' . $cases . ')/u';
    }
}

define('LATINIZATION_MAP', [
    "a"  => "à á â ã ä å æ",
    "c"  => "ç",
    "d"  => "ð",
    "e"  => "è é ê ë",
    "g"  => "ğ",
    "i"  => "ì í î ï i̇ ı",
    "m"  => "μ",
    "n"  => "ñ",
    "o"  => "ò ó ô õ ö ø",
    "oe" => "œ",
    "s"  => "ş",
    "sh" => "š",
    "th" => "þ",
    "u"  => "ù ú û ü",
    "y"  => "ý ÿ",
    
    "A"  => "À Á Â Ä Å Æ Ã Ā",
    "C"  => "Ç",
    "D"  => "Ð",
    "E"  => "È É Ê Ë",
    "G"  => "Ğ",
    "I"  => "Ì Í Î Ï İ",
    "N"  => "Ñ",
    "O"  => "Ò Ó Ô Õ Ö Ø",
    "OE" => "Œ",
    "S"  => "ß Ş",
    "SH" => "Š",
    "TH" => "Þ",
    "U"  => "Ù Ú Û Ü",
    "Y"  => "Ý Ÿ",
]);