<?php
    
    function is_recent($filepath, $age) {
        $then = filemtime($filepath);
        $now  = time();
        $diff = $now - $then;
        if ($diff < $age) {
            return true;
        }
        return false;
    }
    
    function cached_url($url, $filepath, $age) {
        $content = null;
        if (file_exists($filepath)) {
            if (is_recent($filepath, $age)) {
                $content = file_get_contents($filepath);
            } else {
                unlink($filepath);
                $content = file_get_contents($url);
                file_put_contents($filepath, $content);
            }
        } else {
            $content = file_get_contents($url);
            file_put_contents($filepath, $content);
        }
        return $content;
    }
    
    function cached_parsed_url($url, $raw_path, $cached_path, $age, $parse_callback) {
        $raw_content    = null;
        $cached_content = null;
        if (file_exists($cached_path)) {
            if (is_recent($cached_path, $age)) {
                $cached_content = file_get_contents($cached_path);
            } else {
                @unlink($raw_path);
                unlink($cached_path);
                $raw_content = file_get_contents($url);
                file_put_contents($raw_path, $raw_content);
                $cached_content = $parse_callback($raw_content);
                file_put_contents($cached_path, $cached_content);
            }
        } else {
            if (file_exists($raw_path)) {
                if (is_recent($raw_path, $age)) {
                    $raw_content = file_get_contents($raw_path);
                } else {
                    $raw_content = file_get_contents($url);
                    file_put_contents($raw_path, $raw_content);
                }
            } else {
                $raw_content = file_get_contents($url);
                file_put_contents($raw_path, $raw_content);
            }
            $cached_content = $parse_callback($raw_content);
            file_put_contents($cached_path, $cached_content);
        }
        return $cached_content;
    }
    
?>