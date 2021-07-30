<?php

/**
 * requires avg()
 */
function stdev(): float {
    $args = \func_get_args();
    $stdev = 0;
    if (!empty($args)) {
        $avg = avg(...$args);
        $dev = array_map(fn ($arg) => ($arg - $avg) ** 2, $args);
        $var = avg(...$dev);
        $stdev = sqrt($var);
    }
    return $stdev;
}