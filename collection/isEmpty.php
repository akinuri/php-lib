<?php

/**
 * @uses getKeys()
 */
function isEmpty(array|object $container) {
    return \count(self::getKeys($container)) == 0;
}