<?php

function array_dev(array $values) {
    $avg = array_avg($values);
    $squaredDistances = array_map(function ($value) use ($avg) {
        return pow($value - $avg, 2);
    }, $values);
    $avgSquaredDistances = array_avg($squaredDistances);
    $stddev = sqrt($avgSquaredDistances);
    return $stddev;
}

