<?php

function isDate($str) {
    $regex = "/^\d{4}-(?:0?[1-9]|1[0-2]|)-(?:3[01]|[0-2]?[0-9])$/";
    return preg_match($regex, $str);
}