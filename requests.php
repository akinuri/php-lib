<?php

function GET($param, $switchlike = false, $required = false) {
    $value = null;
    if (isset($_GET[$param])) {
        $value = $_GET[$param];
        if ($switchlike && in_array(strtolower($value), ["1", "on", "true", ""])) {
            return true;
        }
        if ($required && trim($value) == "") {
            die(json_encode(["error" => "Missing parameter value: {$param}"]));
        }
        return $value;
    }
    if ($required) {
        die(json_encode(["error" => "Missing parameter: {$param}"]));
    }
    return null;
}

function POST($param, $switchlike = false, $required = false) {
    $value = null;
    if (isset($_POST[$param])) {
        $value = $_POST[$param];
    }
    else if (isset($_FILES[$param])) {
        $value = $_FILES[$param];
    }
    if ($value) {
        if (is_string($value)) {
            if ($switchlike && in_array(strtolower($value), ["1", "on", "true", ""])) {
                return true;
            }
            if ($required && trim($value) == "") {
                die(json_encode(["error" => "Missing parameter value: {$param}"]));
            }
            return $value;
        }
        if (is_array($value)) {
            return $value;
        }
    }
    if ($required) {
        die(json_encode(["error" => "Missing parameter: {$param}"]));
    }
    return null;
}
