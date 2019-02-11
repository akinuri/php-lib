<?php

function getcookie($name) {
    if (isset($_COOKIE[$name]) && $_COOKIE[$name]) {
        return urldecode($_COOKIE[$name]);
    }
    return null;
}

