<?php

function filename($str) {
    $result = [
        "parent"    => null,
        "seperator" => null,
        "name"      => null,
        "extension" => null,
        "name_ext"  => null,
    ];
    if (strpos($str, "/") != false) {
        $parts = explode("/", $str);
        $result["seperator"] = "/";
        $result["name_ext"]  = array_pop($parts);
        $result["parent"]    = implode($result["seperator"], $parts);
    }
    else if (strpos($str, "\\") != false) {
        $parts = explode("\\", $str);
        $result["seperator"] = "\\";
        $result["name_ext"]  = array_pop($parts);
        $result["parent"]    = implode($result["seperator"], $parts);
    } else {
        $result["name_ext"] = $str;
    }
    if (in_array($result["name_ext"], [".", ".."])) return $result;
    if (strpos($result["name_ext"], ".") !== false) {
        $parts = explode(".", $result["name_ext"]);
        $result["extension"] = array_pop($parts);
        $result["name"]      = implode(".", $parts);
    }
    return $result;
}