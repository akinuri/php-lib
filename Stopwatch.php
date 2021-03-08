<?php

class Stopwatch {
    
    /*
        lowercase = without leading/trailing zero
        uppercase = with leading zero
        
        millisecond = l (0.12) | L (0.120)
        second      = s (8)    | S (08)
        minute      = i (5)    | I (05)
        hour        = h (2)    | H (02)
        day         = d (1)    | D (01)
        month       = m (4)    | M (04)
        year        = y (312)  | Y (312) - NO ZEROS
    */
    
    private static const DUR_L = 1;
    private static const DUR_S = 1000;
    private static const DUR_I = 60000;         // 1000 * 60
    private static const DUR_H = 3600000;       // 1000 * 60 * 60
    private static const DUR_D = 86400000;      // 1000 * 60 * 60 * 24
    private static const DUR_M = 2592000000;    // 1000 * 60 * 60 * 24 * 30
    private static const DUR_Y = 31536000000;   // 1000 * 60 * 60 * 24 * 365
    
    
    
    
    
    
    private $_start   = 0;
    private $_stop    = 0;
    public $elapsed  = 0;
    public $duration = null;
    public $format   = "y-m-d h:i:s.l";
    
    public function start() {
        $this->_start = round(microtime(1) * 1000);
        if ($this->duration) {
            $this->duration = [];
        }
    }
    
    public function stop() {
        $this->_stop = round(microtime(1) * 1000);
        $this->elapsed = $this->_stop - $this->_start;
        $this->calc_duration();
    }
    
    public function resume() {
        $now  = round(microtime(1) * 1000);
        $idle = $now - $this->_stop;
        $this->_start += $idle;
        if ($this->duration) {
            $this->duration = [];
        }
    }
    
    public function reset() {
        $this->_start   = 0;
        $this->_stop    = 0;
        $this->elapsed = 0;
        $this->duration = [];
    }
    
    public function calc_duration() {
        
        $dt_format = strtolower($this->format);
        
        $remainder = $this->elapsed;
        
        if (strpos($dt_format, "y") !== false) {
            if ($remainder >= DUR_Y) {
                $this->duration["y"] = floor($remainder / DUR_Y);
                $remainder = fmod($remainder, DUR_Y);
            } else {
                $this->duration["y"] = 0;
            }
        }
        
        if (strpos($dt_format, "m") !== false) {
            if ($remainder >= DUR_M) {
                $this->duration["m"]  = floor($remainder / DUR_M);
                $remainder = fmod($remainder, DUR_M);
            } else {
                $this->duration["m"] = 0;
            }
        }
        
        if (strpos($dt_format, "d") !== false) {
            if ($remainder >= DUR_D) {
                $this->duration["d"]  = floor($remainder / DUR_D);
                $remainder = fmod($remainder, DUR_D);
            } else {
                $this->duration["d"] = 0;
            }
        }
        
        if (strpos($dt_format, "h") !== false) {
            if ($remainder >= DUR_H) {
                $this->duration["h"]  = floor($remainder / DUR_H);
                $remainder = fmod($remainder, DUR_H);
            } else {
                $this->duration["h"] = 0;
            }
        }
        
        if (strpos($dt_format, "i") !== false) {
            if ($remainder >= DUR_I) {
                $this->duration["i"]  = floor($remainder / DUR_I);
                $remainder = fmod($remainder, DUR_I);
            } else {
                $this->duration["i"] = 0;
            }
        }
        
        if (strpos($dt_format, "s") !== false) {
            if ($remainder >= DUR_S) {
                $this->duration["s"]  = floor($remainder / DUR_S);
                $remainder = fmod($remainder, DUR_S);
            } else {
                $this->duration["s"] = 0;
            }
        }
        
        if (strpos($dt_format, "l") !== false) {
            if ($remainder >= DUR_MS) {
                $this->duration["l"]  = floor($remainder / DUR_MS);
                $remainder = fmod($remainder, DUR_MS);
            } else {
                $this->duration["l"] = 0;
            }
        }
    }
    
    public function toString() {
        
        $result = $this->format;
        
        if (isset($this->duration["y"])) {
            $target_letter = "y";
            if (strpos($this->format, "Y") !== false) {
                $target_letter = "Y";
            }
            $result = str_replace($target_letter, $this->duration["y"], $result);
        }
        
        if (isset($this->duration["m"])) {
            $month = $this->duration["m"];
            $target_letter = "m";
            if (strpos($this->format, "M") !== false) {
                $target_letter = "M";
                $month = str_pad($month, 2, "0", STR_PAD_LEFT);
            }
            $result = str_replace($target_letter, $month, $result);
        }
        
        if (isset($this->duration["d"])) {
            $day = $this->duration["d"];
            $target_letter = "d";
            if (strpos($this->format, "D") !== false) {
                $target_letter = "D";
                $day = str_pad($day, 2, "0", STR_PAD_LEFT);
            }
            $result = str_replace($target_letter, $day, $result);
        }
        
        if (isset($this->duration["h"])) {
            $hour = $this->duration["h"];
            $target_letter = "h";
            if (strpos($this->format, "H") !== false) {
                $target_letter = "H";
                $hour = str_pad($hour, 2, "0", STR_PAD_LEFT);
            }
            $result = str_replace($target_letter, $hour, $result);
        }
        
        if (isset($this->duration["i"])) {
            $minute = $this->duration["i"];
            $target_letter = "i";
            if (strpos($this->format, "I") !== false) {
                $target_letter = "I";
                $minute = str_pad($minute, 2, "0", STR_PAD_LEFT);
            }
            $result = str_replace($target_letter, $minute, $result);
        }
        
        if (isset($this->duration["s"])) {
            $sec = $this->duration["s"];
            $target_letter = "s";
            if (strpos($this->format, "S") !== false) {
                $target_letter = "S";
                $sec = str_pad($sec, 2, "0", STR_PAD_LEFT);
            }
            $result = str_replace($target_letter, $sec, $result);
        }
        
        if (isset($this->duration["l"])) {
            $msec = $this->duration["l"];
            $target_letter = "l";
            if (strpos($this->format, "L") !== false) {
                $target_letter = "L";
                $msec = str_pad($msec, 3, "0", STR_PAD_RIGHT);
            }
            $result = str_replace($target_letter, $msec, $result);
        }
        
        return $result;
    }
    
}


// $sw = new Stopwatch();
// $sw->start();

// sleep(2);

// $sw->pause();

// sleep(1);

// $sw->resume();

// sleep(3);

// $sw->stop();

// var_dump($sw);

// print_r($sw->toString());


// $sw->elapsed = 2102402165041;
// $sw->format = "H:i:s.v";
// $sw->format = "y-M-D H:I:S.L";
// $sw->calc_duration();

// print_r($sw);

// print_r($sw->toString());

