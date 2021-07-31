<?php

function isRegex($str) {
    $regex = "/^\/[\s\S]+\/$/";
    return preg_match($regex, $str);
}