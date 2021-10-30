<?php

function getValues(object $container): array {
    if (\is_array($container)) {
        $values = \array_values($container);
    } else {
        $values = \array_values(\get_object_vars($container));
    }
    return $values;
}