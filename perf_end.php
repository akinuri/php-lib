<?php
    
    if (isset($GLOBALS["perf_start"])) {
        $GLOBALS["perf_end"] = microtime(true);
        
        $elapsed = ($GLOBALS["perf_end"] - $GLOBALS["perf_start"]);
        $elapsed = number_format($elapsed, 6);
        
        echo "\n<!--- Generated in: {$elapsed} seconds. --->";
    }
    