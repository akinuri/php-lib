<?php

/**
 * Checks whether the string starts with a specific substring.
 */
function startsWith(string $haystack = null, string $needle = null): bool {
    if (empty($haystack) || empty($needle)) {
        return false;
    }
    return $haystack[0] === $needle[0]
        ? \strncmp($haystack, $needle, strlen($needle)) === 0
        : false;
}