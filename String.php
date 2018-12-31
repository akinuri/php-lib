<?php
    
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
    
    function str_contains($str, $substr) {
        return strpos($str, $substr) !== false;
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
    
    function filename($full_name) {
        $result = [
            "filename"  => $full_name,
            "extension" => null,
            "full_name" => $full_name,
        ];
        if (strpos($full_name, ".") !== false) {
            $parts = explode(".", $full_name);
            $result["extension"] = strtolower(array_pop($parts));
            $result["filename"]  = implode(".", $parts);
        }
        return $result;
    }
    
    function latinize($str) {
        $chars = [
            ["ç", "c"], ["ğ", "g"], ["ı", "i"], ["ö", "o"], ["ş", "s"], ["ü", "u"],
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
    
?>