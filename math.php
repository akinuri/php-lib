<?php

/*
    all math functions accept an array of numbers, or just of numbers
    
    math_sum()
    math_avg()
    math_stdev()
*/

function math_sum() {
    $args = func_get_args();
    $arg_count = count($args);
    $sum = null;
    if ($arg_count) {
        $values = [];
        if ($arg_count == 1) {
            if (is_array($args[0])) {
                $values = $args[0];
            }
        } else {
            $values = $args;
        }
        $sum = array_sum($values);
    }
    return $sum;
}

function math_avg() {
    $args = func_get_args();
    $arg_count = count($args);
    $avg = null;
    if ($arg_count) {
        $values = [];
        if ($arg_count == 1) {
            if (is_array($args[0])) {
                $values = $args[0];
            }
        } else {
            $values = $args;
        }
        $avg = math_sum($values) / count($values);
    }
    return $avg;
}

function math_stdev() {
    $args = func_get_args();
    $arg_count = count($args);
    $stdev = null;
    if ($arg_count) {
        $values = [];
        if ($arg_count == 1) {
            if (is_array($args[0])) {
                $values = $args[0];
            }
        } else {
            $values = $args;
        }
        $avg = math_avg($values);
        $vrn = math_sum( array_map(function ($value) { $diff = $avg - $value; return $diff * $diff; }, $values) ) / count($values);
        $stdev = sqrt($vrn);
    }
    return $stdev;
}



