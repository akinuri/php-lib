<?php

/**
 * Sometimes the NULL is a valid value,
 * and can't be used as an invalid value.
 */
define("undefined", "__undefined__");

/**
 * Checks if the variable is undefined: "\_\_undefined\_\_"
 */
function is_undefined($var): bool {
    return $var === undefined;
}

