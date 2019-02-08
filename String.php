<?php


/*
    includes != contains
        box contains
        contents include
        string isn't a box/container; it's the content (right?)
        so array contains, string includes
    
    str_includes($str, $substr [, $all = false])
    is_regex($str)
    str_strip($substr, $str)
    clean_io($str)
    filename($str)
    latinize($str)
    url_friendly($str)
    str_starts_with($haystack, $needle)
*/


function str_includes($str, $substr, $all = false) {
    if (is_string($substr)) {
        return strpos($str, $substr) !== false;
    }
    else if (is_array($substr)) {
        if ($all) {
            foreach ($substr as $sub) {
                if (!str_includes($str, $sub)) {
                    return false;
                }
            }
            return true;
        } else {
            foreach ($substr as $sub) {
                if (str_includes($str, $sub)) {
                    return true;
                }
            }
            return false;
        }
    }
    return false;
}


function is_regex($str) {
    $regex = "/^\/[\s\S]+\/$/";
    return preg_match($regex, $str);
}


function str_strip($substr, $str) {
    return str_replace($substr, "", $str);
}


function clean_io($str) {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
}


function filename($str) {
    $result = [
        "parent"    => null,
        "seperator" => null,
        "name"      => null,
        "extension" => null,
        "name_ext"  => null,
    ];
    if (strpos($str, "/") != false) {
        $result["seperator"] = "/";
        $parts = explode($result["seperator"], $str);
        $result["name_ext"] = array_pop($parts);
        $result["parent"]   = implode($result["seperator"], $parts);
    }
    else if (strpos($str, "\\") != false) {
        $result["seperator"] = "\\";
        $parts = explode($result["seperator"], $str);
        $result["name_ext"] = array_pop($parts);
        $result["parent"]   = implode($result["seperator"], $parts);
    } else {
        $result["name_ext"] = $str;
    }
    if (in_array($result["name_ext"], [".", ".."]))
        return $result;
    if (strpos($result["name_ext"], ".") !== false) {
        $parts = explode(".", $result["name_ext"]);
        $result["extension"] = array_pop($parts);
        $result["name"] = implode(".", $parts);
    }
    return $result;
}


function latinize($str) {
    $chars = [
        ["ç", "c"], ["ğ", "g"], ["ı", "i"], ["ö", "o"], ["ş", "s"], ["ü", "u"], ["ü", "u"],
        ["Ç", "C"], ["Ğ", "G"], ["İ", "I"], ["Ö", "O"], ["Ş", "S"], ["Ü", "U"],
        ["i̇", "i"],
    ];
    foreach ($chars as $char) {
        $str = str_replace($char[0], $char[1], $str);
    }
    return $str;
}


function url_friendly($str) {
    $weirds = [
        ["¦",   ""],
        [" - ", " "],
        ["&",   "n"],
    ];
    $str = latinize($str);
    $str = strtolower($str);
    foreach ($weirds as $char) {
        $str = str_replace($char[0], $char[1], $str);
    }
    $str = preg_split("/\s+/", $str);
    return implode("-", $str);
}


function str_starts_with($haystack, $needle) {
    return $haystack[0] === $needle[0]
        ? strncmp($haystack, $needle, strlen($needle)) === 0
        : false;
}

