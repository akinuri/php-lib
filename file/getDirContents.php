<?php

function getDirContents(string $dirpath, bool $includePath = false): array {
    $contents = [];
    if (file_exists($dirpath)) {
        $contents = scandir($dirpath);
        $contents = array_diff($contents, [".", "..", ".keep", ".gitkeep"]);
        $contents = array_values($contents);
        if ($includePath) {
            $contents = array_map(fn ($item) => $dirpath . "/" . $item, $contents);
        }
    }
    return $contents;
}

