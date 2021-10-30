<?php

/**
 *  Returns a filtered version of the input.
 *  https://www.php.net/manual/en/function.array-filter
 * 
 * @uses isEmpty()
 * @uses Object2::fromArray()
 */
function filterByKeys(
    array|object $container,
    array $intersectKeys = null,
    array $exceptKeys = null
): array|object {
    $inputType = \gettype($container);
    $entries = $inputType == "array" ? $container : \get_object_vars($container);
    if (
        self::isEmpty($entries) ||
        ( empty($intersectKeys) && empty($exceptKeys) )
    ) {
        return $inputType == "array" ? $entries : Object2::fromArray($entries);
    }
    if ($intersectKeys) {
        $entries = \array_intersect_key($entries, \array_flip($intersectKeys));
    }
    if ($exceptKeys) {
        $entries = \array_diff_key($entries, \array_flip($exceptKeys));
    }
    return $inputType == "array" ? $entries : Object2::fromArray($entries);
}