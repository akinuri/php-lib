<?php
    
    function GET($param, $empty_allowed = false, $die = false) {
        
        if (isset($_GET[$param])) {
            
            // empty values are not allowed
            if (!$empty_allowed && trim($_GET[$param]) == "") {
                
                // there is a parameter, but its value is empty; so die = value is required
                if ($die) {
                    die("ERROR: Missing parameter value: $param");
                }
                
                // there is a parameter, but its value is empty (for switch-like parameters)
                return true;
                
            } else {
                
                // there is a parameter with a value
                return $_GET[$param];
            }
            
        }
        
        if ($die) {
            die("ERROR: Missing parameter: $param");
        }
        
        // there is no parameter
        return null;
    }
    
?>