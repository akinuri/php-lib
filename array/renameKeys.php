<?php

/**
 *  Renames the existing array keys using a key map array.
 */
function renameKeys(array $array, array $keyMap = []) : array {
    $result = [];
    if (empty($array) || empty($keyMap)) {
        return $result;
    }
    foreach ($keyMap as $oldKey => $newKey) {
        if (array_key_exists($oldKey, $array)) {
            $result[$newKey] = $array[$oldKey];
        }
    }
    return $result;
}