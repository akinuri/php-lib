<?php

/**
 *  Renames the existing array keys using a key map array.
 */
function renameKeys(array $array, array $keyMap = []) : array {
    if (empty($array) || empty($keyMap)) {
        return $array;
    }
    foreach ($keyMap as $oldKey => $newKey) {
        if (array_key_exists($oldKey, $array)) {
            if (array_key_exists($newKey, $array)) {
                throw new Exception("The new key ({$newKey}) already exists in the array.");
            }
            $array[$newKey] = $array[$oldKey];
            unset($array[$oldKey]);
        }
    }
    return $array;
}