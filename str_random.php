<?php
    
    // str_slice(string $str, int $start [, int $end])
    function str_slice() {
        $args = func_get_args();
        switch (count($args)) {
            case 1:
                return $args[0];
            case 2:
                $str        = $args[0];
                $str_length = strlen($str);
                $start      = $args[1];
                if ($start < 0) {
                    if ($start >= - $str_length) {
                        $start = $str_length - abs($start);
                    } else {
                        $start = 0;
                    }
                }
                else if ($start >= $str_length) {
                    $start = $str_length;
                }
                $length = $str_length - $start;
                return substr($str, $start, $length);
            case 3:
                $str        = $args[0];
                $str_length = strlen($str);
                $start      = $args[1];
                $end        = $args[2];
                if ($start >= $str_length) {
                    return "";
                }
                if ($start < 0) {
                    if ($start < - $str_length) {
                        $start = 0;
                    } else {
                        $start = $str_length - abs($start);
                    }
                }
                if ($end <= $start) {
                    return "";
                }
                if ($end > $str_length) {
                    $end = $str_length;
                }
                $length = $end - $start;
                return substr($str, $start, $length);
        }
        return null;
    }
    
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz")          ); // "abcdefghijklmnopqrstuvwxyz"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", 5)       ); // "fghijklmnopqrstuvwxyz"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", -5)      ); // "vwxyz"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", 40)      ); // ""
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", -40)     ); // "abcdefghijklmnopqrstuvwxyz"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", 5, 10)   ); // "fghij"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", 5, 20)   ); // "fghijklmnopqrst"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", 5, 30)   ); // "fghijklmnopqrstuvwxyz"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", -20, 2)  ); // ""
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", -20, 10) ); // "ghij"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", -20, 15) ); // "ghijklmno"
    // var_dump( str_slice("abcdefghijklmnopqrstuvwxyz", -20, 40) ); // "ghijklmnopqrstuvwxyz"
    
    // die();
    
    function str_random($length = 16, $ranges = "a-zA-Z0-9") {
        
        $sets = [
            "lower" => "abcdefghijklmnopqrstuvwxyz",
            "upper" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            "digit" => "0123456789",
        ];
        
        $chars = [];
        
        if (isset($ranges)) {
            $ranges = str_split($ranges, 3);
            
            foreach ($ranges as $range) {
                
                $is_lower = preg_match("/^([a-z])-([a-z])$/", $range, $match_lower);
                $is_upper = preg_match("/^([A-Z])-([A-Z])$/", $range, $match_upper);
                $is_digit = preg_match("/^(\d)-(\d)$/", $range, $match_digit);
                
                if ($is_lower) {
                    $lower_start = $match_lower[1];
                    $lower_end   = $match_lower[2];
                    $slice       = str_slice($sets["lower"], strpos($sets["lower"], $lower_start), strpos($sets["lower"], $lower_end) + 1);
                    $chars[]     = $slice;
                }
                else if ($is_upper) {
                    $upper_start = $match_upper[1];
                    $upper_end   = $match_upper[2];
                    $slice       = str_slice($sets["upper"], strpos($sets["upper"], $upper_start), strpos($sets["upper"], $upper_end) + 1);
                    $chars[]     = $slice;
                }
                else if ($is_digit) {
                    $digit_start = $match_digit[1];
                    $digit_end   = $match_digit[2];
                    $slice       = str_slice($sets["digit"], strpos($sets["digit"], $digit_start), strpos($sets["digit"], $digit_end) + 1);
                    $chars[]     = $slice;
                }
            }
            
        } else {
            $chars = array_merge($sets[0], $sets[1], $sets[2]);
        }
        
        $chars = str_shuffle( implode("", $chars) );
        
        $string = "";
        
        for ($i = 0; $i < $length; $i++) {
            $rand = random_int(0, strlen($chars) - 1);
            $string .= $chars[$rand];
        }
        
        return $string;
    }
    
    // $randoms = [
        // 'str_random()'                  => str_random(),
        // 'str_random(16, "a-z")'         => str_random(16, "a-z"),
        // 'str_random(16, "A-Z")'         => str_random(16, "A-Z"),
        // 'str_random(16, "0-9")'         => str_random(16, "0-9"),
        // 'str_random(16, "a-zA-Z")'      => str_random(16, "a-zA-Z"),
        // 'str_random(16, "a-z0-9")'      => str_random(16, "a-z0-9"),
        // 'str_random(16, "A-Z0-9")'      => str_random(16, "A-Z0-9"),
        // 'str_random(16, "f-q")'         => str_random(16, "f-q"),
        // 'str_random(16, "S-Y")'         => str_random(16, "S-Y"),
        // 'str_random(16, "3-7")'         => str_random(16, "3-7"),
        // 'str_random(16, "a-cD-F6-8")'   => str_random(16, "a-cD-F6-8"),
        // 'str_random(32, "a-f0-9")'      => str_random(32, "a-f0-9"),
        // 'str_random(32)'                => str_random(32),
    // ];
    
    
    // print_r($randoms);
    
    // Array
    // (
        // [str_random()] => 0vmMY8kDc6cQlstS
        // [str_random(16, "a-z")] => ugnhucibizmdwfaz
        // [str_random(16, "A-Z")] => MLBRIGMOJAUOUJCE
        // [str_random(16, "0-9")] => 0010711379031842
        // [str_random(16, "a-zA-Z")] => wxWBFXojnKkrrOUt
        // [str_random(16, "a-z0-9")] => 3jscqj0x06wo5sga
        // [str_random(16, "A-Z0-9")] => 7H5ASTNN5L2ON8A6
        // [str_random(16, "f-q")] => kpnoqnlmmgpqgigk
        // [str_random(16, "S-Y")] => SYYTYVTSXVUUWTSS
        // [str_random(16, "3-7")] => 7543447374456343
        // [str_random(16, "a-cD-F6-8")] => 8D776b76EccbDFbb
        // [str_random(32, "a-f0-9")] => 54ff119cc1c614f6ebe1b629b489d3ff
        // [str_random(32)] => 9Mt39R6sWBOfnLvpjXElmNVi9U9owVDR
    // )
    