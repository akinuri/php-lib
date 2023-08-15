<?php

function addVersion2Path(string $path): string {
    $updatedAt = null;
    if (file_exists($path)) {
        $updatedAt = filemtime($path);
    }
    if ($updatedAt) {
        $path .= "?v=" . $updatedAt;
    }
    return $path;
}

function doesPathHaveVersion(string $path): int|bool {
    $pattern = "/[^\?]+\?v=\d+/";
    return preg_match($pattern, $path);
}

