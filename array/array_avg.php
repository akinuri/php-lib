<?php

function array_avg(array $values): float {
    return array_sum($values) / (count($values) ?: 1);
}

