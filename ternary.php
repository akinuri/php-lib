<?php

function ternary($condition, $true = null, $false = null) {
    if ($true === null) {
        $true = $condition;
    }
    return $condition ? $true : $false;
}

