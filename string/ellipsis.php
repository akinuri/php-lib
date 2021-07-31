<?php

function ellipsis(string $string = null, int $maxLength, string $ellipsis = "...") {
    if (!$string) {
        return $string;
    };
    $maxLength -= \strlen($ellipsis);
    if (\strlen($string) > $maxLength) {
        $string = \trim(\mb_substr($string, 0, $maxLength)) . $ellipsis;
    }
    return $string;
}