<?php
    
    function is_sequential($array) {
        $last_index = count($array) - 1;
        if (array_key_exists(0, $array) && array_key_exists($last_index, $array)) {
            return true;
        }
        return false;
    }
    
?>