<?php

/**
 *  Checks if an array is sequential (as opposed to being associative).
 */
function isSequential(array $array, bool $strict = false): bool {
    if (empty($array)) {
        // beware! an empty array is treated as sequential
        return true;
    }
    $lastIndex = \count($array) - 1;
    if ($strict) {
        // if one is being paranoid, one needs to make sure
        // that all the keys are numbers AND that they are sequential
        // the easiest way to make sure of that (logic-wise)
        // is to check the sum of the keys
        $arrayKeySum    = \array_sum(\array_keys($array));
        $triangleNumber = ($lastIndex * ($lastIndex + 1)) / 2;
        return $arrayKeySum === $triangleNumber;
    }
    // if the keys "0" and "n" (last index) exists in the array
    // one can assume the array is sequential
    return \array_key_exists(0, $array) && \array_key_exists($lastIndex, $array);
}