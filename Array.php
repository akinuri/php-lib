<?php


/**
 *  Contents:
 *  
 *  array_filter_by_keys(array $array, array $intersect_keys = null, array $except_keys = null) : array
 *  array_rename_keys(array $array, array $key_map = []) : array
 *  array_sequential(array $array, bool $strict = false) : bool
 *  array_splice_item(array &$array, $item, $replacement = null) : array
 *  
 */


/**
 *  Returns an associative array that's filtered by insersection and exception keys arrays.
 *  https://www.php.net/manual/en/function.array-filter
 */
function array_filter_by_keys(array $array, array $intersect_keys = null, array $except_keys = null) : array {
    $result = [];
    if (empty($array) || (empty($intersect_keys) && empty($except_keys))) {
        return $result;
    }
    if ($intersect_keys) {
        $result = array_intersect_key($array, array_flip($intersect_keys));
    }
    if ($except_keys) {
        $result = array_diff_key($result, array_flip($except_keys));
    }
    return $result;
}


/**
 *  Renames the existing array keys using the key map array.
 */
function array_rename_keys(array $array, array $key_map = []) : array {
    $result = [];
    if (empty($array) || empty($key_map)) {
        return $result;
    }
    foreach ($key_map as $old_key => $new_key) {
        if (array_key_exists($old_key, $array)) {
            $result[$new_key] = $array[$old_key];
        }
    }
    return $result;
}


/**
 *  Checks if an array is sequential (contrary to associative).
 */
function array_sequential(array $array, bool $strict = false) : bool {
    if ($strict) {
        // if one is being paranoid, one needs to make sure that all the keys are numbers AND that they are sequential
        // the easiest way to make sure of that (logic-wise) is to check the sum of the keys
        $array_key_sum   = array_sum(array_keys($array));
        $last_index      = count($array) - 1;
        $triangle_number = ($last_index * ($last_index + 1)) / 2;
        return $array_key_sum === $triangle_number;
    }
    // if keys "0" and "n" (array length - 1) exists in the array, one can assume it is sequential
    return array_key_exists(0, $array) && array_key_exists(count($array) - 1, $array);
}


/**
 *  Removes an item from the array.
 *  Expects an item instead of index/offset in the second argument.
 *  https://www.php.net/manual/en/function.array-splice.php
 */
function array_splice_item(array &$array, $item, $replacement = null) : array {
    $index = array_search($item, $array);
    if ($index === false) return null;
    return array_splice($array, $index, 1, $replacement);
}