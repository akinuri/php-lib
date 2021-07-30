<?php

/**
 *  Removes a value from the array.
 *  Expects a value instead of index/offset in the second argument.
 * 
 *  @link https://www.php.net/manual/en/function.array-splice.php
 */
function removeValue(array &$array, $value, bool $removeAll = false): array {
    $removed = [];
    do {
        $valueIndex = \array_search($value, $array);
        if ($valueIndex !== false) {
            $extracted = \array_splice($array, $valueIndex, 1);
            $removed += $extracted;
        }
    } while ($removeAll && \array_search($value, $array) !== false);
    return $removed;
}