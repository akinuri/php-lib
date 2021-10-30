<?php

function getKeys(array|object $container): array {
    if (\is_array($container)) {
        $keys = \array_keys($container);
    } else {
        $keys = \array_keys(\get_object_vars($container));
    }
    return $keys;
}