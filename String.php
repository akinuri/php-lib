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
    
?>