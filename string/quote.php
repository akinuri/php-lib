<?php

/**
 * Wraps the string with quotes.
 */
function quote(string $str, string $quoteChar = "\"") {
    return wrap($str, $quoteChar);
}