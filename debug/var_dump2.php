<?php

function var_dump2($var, bool $die = false) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    if ($die) die;
}

function print_r2($value, bool $die = false) {
    echo "<pre>";
    print_r($value);
    echo "</pre>";
    if ($die) die;
}

