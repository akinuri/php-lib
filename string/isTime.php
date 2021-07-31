<?php

function isTime($str) {
    $regex = "/^(?:2[0-3]|1[0-9]|0?[0-9])(?::[0-5]?[0-9]){2}$/";
    return preg_match($regex, $str);
}