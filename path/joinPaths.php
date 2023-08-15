<?php

function joinPaths(array $paths, string $seperator = DIRECTORY_SEPARATOR) {
    $paths = array_filter($paths, function ($path) {
        return is_string($path) && strlen($path);
    });
    $paths = join($seperator, $paths);
    $pattern = "/(\\\\\/)+|\\\+|\/+/";
    $paths = preg_replace($pattern, $seperator, $paths);
    return $paths;
}

