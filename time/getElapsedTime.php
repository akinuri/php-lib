<?php

function getElapsedTime($start, $decimals = 6, bool $isFloat = true): float|string {
    $time = number_format((microtime(true) - $start), $decimals, ".", "");
    if ($isFloat) {
        $time = (float) $time;
    }
    return $time;
}

