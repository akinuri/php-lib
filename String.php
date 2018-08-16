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
    
    function latinize($text) {
        $chars = [
            "ç", "ğ", "ı", "ö", "ş", "ü",
            "Ç", "Ğ", "İ", "Ö", "Ş", "Ü",
        ];
        $replacements = [
            "c", "g", "i", "o", "s", "u",
            "C", "G", "I", "O", "S", "U",
        ];
        for ($i = 0; $i < count($chars); $i++) {
            $char        = $chars[$i];
            $replacement = $chars[$i];
            $text = str_replace($char, $replacement, $text);
        }
        return $text;
    }
    
    function str_starts_with($haystack, $needle) {
        return $haystack[0] === $needle[0]
            ? strncmp($haystack, $needle, strlen($needle)) === 0
            : false;
    }
    
?>