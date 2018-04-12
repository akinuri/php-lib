<?php
    
    function arr_prop($arr, $key, $default = null) {
        if ( isset($arr[$key]) ) {
            return trim($arr[$key]); // SERVER_SIGNATURE contains a line-break?
        }
        if ($default) {
            return $default;
        }
        return null;
    }
    
    function SERVER() {
        return [
            "UNIQUE_ID"         => arr_prop($_SERVER, "UNIQUE_ID"),
            "GATEWAY_INTERFACE" => arr_prop($_SERVER, "GATEWAY_INTERFACE"),
            
            "HTTP"  => [
                "HTTP_HOST"                      => arr_prop($_SERVER, "HTTP_HOST"),
                "HTTP_CONNECTION"                => arr_prop($_SERVER, "HTTP_CONNECTION"),
                "HTTP_UPGRADE_INSECURE_REQUESTS" => arr_prop($_SERVER, "HTTP_UPGRADE_INSECURE_REQUESTS"),
                "HTTP_ACCEPT"                    => arr_prop($_SERVER, "HTTP_ACCEPT"),
                "HTTP_ACCEPT_ENCODING"           => arr_prop($_SERVER, "HTTP_ACCEPT_ENCODING"),
                "HTTP_ACCEPT_LANGUAGE"           => arr_prop($_SERVER, "HTTP_ACCEPT_LANGUAGE"),
                "HTTP_USER_AGENT"                => arr_prop($_SERVER, "HTTP_USER_AGENT"),
                "HTTP_CACHE_CONTROL"             => arr_prop($_SERVER, "HTTP_CACHE_CONTROL"),
                "HTTP_COOKIE"                    => arr_prop($_SERVER, "HTTP_COOKIE"),
                "HTTP_X_FORWARDED_FOR"           => arr_prop($_SERVER, "HTTP_X_FORWARDED_FOR"),
                "HTTP_X_ACCEL_INTERNAL"          => arr_prop($_SERVER, "HTTP_X_ACCEL_INTERNAL"),
            ],
            "SERVER"  => [
                "SERVER_ADDR"           => arr_prop($_SERVER, "SERVER_ADDR"),
                "SERVER_NAME"           => arr_prop($_SERVER, "SERVER_NAME"),
                "SERVER_PORT"           => arr_prop($_SERVER, "SERVER_PORT"),
                "SERVER_ADMIN"          => arr_prop($_SERVER, "SERVER_ADMIN"),
                "SERVER_PROTOCOL"       => arr_prop($_SERVER, "SERVER_PROTOCOL"),
                "SERVER_SOFTWARE"       => arr_prop($_SERVER, "SERVER_SOFTWARE"),
                "SERVER_SIGNATURE"      => arr_prop($_SERVER, "SERVER_SIGNATURE"),
            ],
            "REQUEST"  => [
                "REQUEST_SCHEME"        => arr_prop($_SERVER, "REQUEST_SCHEME"),
                "REQUEST_METHOD"        => arr_prop($_SERVER, "REQUEST_METHOD"),
                "REQUEST_URI"           => arr_prop($_SERVER, "REQUEST_URI"),
                "QUERY_STRING"          => arr_prop($_SERVER, "QUERY_STRING"),
                "REQUEST_TIME"          => arr_prop($_SERVER, "REQUEST_TIME"),
                "REQUEST_TIME_FLOAT"    => arr_prop($_SERVER, "REQUEST_TIME_FLOAT"),
            ],
            "SCRIPT"  => [
                "DOCUMENT_ROOT"         => arr_prop($_SERVER, "DOCUMENT_ROOT"),
                "CONTEXT_PREFIX"        => arr_prop($_SERVER, "CONTEXT_PREFIX"),
                "CONTEXT_DOCUMENT_ROOT" => arr_prop($_SERVER, "CONTEXT_DOCUMENT_ROOT"),
                "PHP_SELF"              => arr_prop($_SERVER, "PHP_SELF"),
                "SCRIPT_NAME"           => arr_prop($_SERVER, "SCRIPT_NAME"),
                "SCRIPT_FILENAME"       => arr_prop($_SERVER, "SCRIPT_FILENAME"),
            ],
            "REMOTE"  => [
                "REMOTE_ADDR"           => arr_prop($_SERVER, "REMOTE_ADDR"),
                "REMOTE_PORT"           => arr_prop($_SERVER, "REMOTE_PORT"),
            ],
            "PATHS"  => [
                "COMSPEC"               => arr_prop($_SERVER, "COMSPEC"),
                "MIBDIRS"               => arr_prop($_SERVER, "MIBDIRS"),
                "MYSQL_HOME"            => arr_prop($_SERVER, "MYSQL_HOME"),
                "OPENSSL_CONF"          => arr_prop($_SERVER, "OPENSSL_CONF"),
                "PHPRC"                 => arr_prop($_SERVER, "PHPRC"),
                "PHP_PEAR_SYSCONF_DIR"  => arr_prop($_SERVER, "PHP_PEAR_SYSCONF_DIR"),
                "SystemRoot"            => arr_prop($_SERVER, "SystemRoot"),
                "TMP"                   => arr_prop($_SERVER, "TMP"),
                "WINDIR"                => arr_prop($_SERVER, "WINDIR"),
                "PATH"                  => arr_prop($_SERVER, "PATH"),
                "PATHEXT"               => arr_prop($_SERVER, "PATHEXT"),
            ],
        ];
    }
    
    // print_r( SERVER() );

?>