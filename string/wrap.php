<?php

function wrap(string $str, string $wrap = null) {
    if (!empty($wrap)) {
        $str = $wrap . $str . $wrap;
    }
    return $str;
}