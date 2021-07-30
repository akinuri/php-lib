<?php

function avg() {
    $args = func_get_args();
    $avg = array_sum($args) / count($args);
    return $avg;
}