<?php

/*
    MODIFY
        safe_output($str, $special, $strip)
        str_strip($substr, $str)
        clean_io($str)
        latinize($str)
        url_friendly($str)
    
    CHECKS
        str_includes($str, $substr [, $all = false])
        str_starts_with($haystack, $needle)
        is_regex($str)
        is_ipv4($str)
        is_date($str)
        is_time($str)
        is_datetime($str)
        
        (includes != contains
            see https://ell.stackexchange.com/questions/47706/using-contain-vs-include-vs-consist-of-appropriately/58467#58467
            box contains
            contents include
            string isn't a box/container; it's the content (right?)
            so array contains, string includes)
    
    PARSE
        filename($str)
*/



function str_ellipsis(string $string, int $max_length, $ellipsis = null) {
    $ELLIPSIS_DEFAULT = "...";
    $ellipsis = $ellipsis ?: $ELLIPSIS_DEFAULT;
    if ($ellipsis) {
        $max_length -= strlen($ellipsis);
    }
    if (strlen($string) > $max_length) {
        return trim(mb_substr($string, 0, $max_length)) . $ellipsis;
    }
    return $string;
}




/* ========================= MODIFY ========================= */


function safe_output($str = null, $special = false, $strip = false) {
    if (!$str) return null;
    $str = trim($str);
    if ($special) $str = htmlspecialchars($str);
    if ($strip)   $str = strip_tags($str);
    return $str;
}


function str_quote($str, $quote = "\"") {
    return $quote . $str . $quote;
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


function latinize($str) {
    $chars = [
        ["ç", "c"],
        ["ğ", "g"],
        ["ı", "i"],
        ["i̇", "i"],
        ["ö", "o"],
        ["ş", "s"],
        ["ü", "u"],
        ["ü", "u"],
        ["Ç", "C"],
        ["Ğ", "G"],
        ["İ", "I"],
        ["Ö", "O"],
        ["Ş", "S"],
        ["Ü", "U"],
    ];
    foreach ($chars as $char) {
        $str = str_replace($char[0], $char[1], $str);
    }
    return $str;
}


function url_friendly($str) {
    $replace = [
        ["-", " "],
        ["—", " "],
        [" & ", " and "],
        ["&", " "],
    ];
    $remove = [
        "<", ">", ":", "\"", "/", "\\", "|", "?", "*", "'", "¦"
    ];
    $str = latinize($str);
    $str = strtolower($str);
    foreach ($replace as $char) {
        $str = str_replace($char[0], $char[1], $str);
    }
    foreach ($remove as $char) {
        $str = str_replace($char, "", $str);
    }
    $str = preg_split("/\s+/", $str);
    return implode("-", $str);
}



/* ========================= CHECKS ========================= */

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


function str_starts_with($haystack, $needle) {
    if ($haystack) {
        return $haystack[0] === $needle[0]
            ? strncmp($haystack, $needle, strlen($needle)) === 0
            : false;
    }
    return false;
}


function is_regex($str) {
    $regex = "/^\/[\s\S]+\/$/";
    return preg_match($regex, $str);
}


function is_ipv4($str) {
    return preg_match("/^(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/", $str);
}


function is_date($str) {
    $regex = "/^\d{4}-(?:0?[1-9]|1[0-2]|)-(?:3[01]|[0-2]?[0-9])$/";
    return preg_match($regex, $str);
}


function is_time($str) {
    $regex = "/^(?:2[0-3]|1[0-9]|0?[0-9])(?::[0-5]?[0-9]){2}$/";
    return preg_match($regex, $str);
}


function is_datetime($str) {
    $regex = "/^\d{4}-(?:0?[1-9]|1[0-2]|)-(?:3[01]|[0-2]?[0-9])(?:T| )(?:2[0-3]|1[0-9]|0?[0-9])(?::[0-5]?[0-9]){2}$/";
    return preg_match($regex, $str);
}



/* ========================= PARSE ========================= */

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
