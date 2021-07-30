<?php

/**
 *  Returns an associative array that's filtered by insersection and exclusion keys arrays.
 *  https://www.php.net/manual/en/function.array-filter
 */
function filterByKeys(array $array, array $intersectKeys = null, array $excludeKeys = null): array {
    if ( empty($array) || ( empty($intersectKeys) && empty($excludeKeys) ) ) {
        return $array;
    }
    if ($intersectKeys) {
        $array = \array_intersect_key($array, \array_flip($intersectKeys));
    }
    if ($excludeKeys) {
        $array = \array_diff_key($array, \array_flip($excludeKeys));
    }
    return $array;
}