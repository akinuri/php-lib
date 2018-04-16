<?php
    
    function GET($param, $empty_allowed = false, $die = false) {
        
        $value = null;
        
        // there is a parameter
        if (isset($_GET[$param])) {
            
            $value = $_GET[$param];
            
            // empty values are allowed (for switch-like parameters)
            if ($empty_allowed) {
                
                if (trim($value) == "") {
                    return true;
                }
                
                return $value;
            }
            
            // empty values are not allowed
            if (trim($value) == "") {
                
                // die if the value is required
                if ($die) {
                    die("ERROR: Missing parameter value: $param");
                }
                
                // if there is a parameter AND its value is empty AND it's not required, do what?
                // if the parameter is expected to be not empty, it should be required
                return null;
            }
            
            return $value;
        }
        
        if ($die) {
            die("ERROR: Missing parameter: $param");
        }
        
        // there is no parameter
        return null;
    }
    
    
    
    function POST($param, $empty_allowed = false, $die = false) {
        
        $value = null;
        
        if (isset($_POST[$param])) {
            $value = $_POST[$param];
        }
        else if (isset($_FILES[$param])) {
            $value = $_FILES[$param];
        }
        
        if ($value) {
            
            // it's a string
            if (is_string($value)) {
                
                // empty values are allowed (for switch-like parameters)
                if ($empty_allowed) {
                    
                    if (trim($value) == "") {
                        return true;
                    }
                    
                    return $value;
                }
                
                // empty values are not allowed
                if (trim($value) == "") {
                    
                    // die if the value is required
                    if ($die) {
                        die("ERROR: Missing parameter value: $param");
                    }
                    
                    // if there is a parameter AND its value is empty AND it's not required, do what?
                    // if the parameter is expected to be not empty, it should be required
                    return null;
                }
            
                return $value;
            }
            
            // it's a file
            if (is_array($value)) {
                return $value;
            }
            
        }
        
        if ($die) {
            die("ERROR: Missing parameter: $param");
        }
        
        // there is no parameter
        return null;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>