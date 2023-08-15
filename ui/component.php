<?php

define("COMPONENTS_PATH", __DIR__ . "../components");

function component(string $componentName, array $data = []): string {
    $componentPath = realpath(joinPaths(COMPONENTS_PATH, "$componentName.php"));
    if (!file_exists($componentPath)) {
        throw new Exception("Component ($componentName) not found.");
    }
    extract($data);
    ob_start();
    include $componentPath;
    $output = ob_get_clean();
    return $output;
}

