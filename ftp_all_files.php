<?php
    
    // https://stackoverflow.com/questions/49250700/ftp-rawlist-doesnt-list-htaccess
    function ftp_all_files($resource, $directory = ".") {
        $rawlist    = ftp_rawlist($resource, "-a " . $directory);
        $rawlist    = array_values(array_filter($rawlist, function ($item) { return !preg_match('/\.?\.$/', $item); }));
        $prettylist = array_map(function ($item) use ($directory) { return ftp_raw2pretty($directory, $item); }, $rawlist);
        foreach ($prettylist as &$item) {
            if ($item["type"] == "dir") {
                $item["children"] = ftp_all_files($resource, $item["path"]);
            }
        }
        return $prettylist;
    }
    
    // https://www.garron.me/en/go2linux/ls-file-permissions.html
    function ftp_raw2pretty($parent_dir, $rawlistItem) {
        $cols = preg_split("/\s+/", $rawlistItem);
        $parent_dir = $parent_dir == "/" ? "" : $parent_dir;
        $pretty = [
            "name"      => $cols[8],
            "path"      => str_replace("-a ", "", $parent_dir ."/". $cols[8]),
            "parent"    => str_replace("-a ", "", $parent_dir),
            "type"      => "file",
            "size"      => $cols[4], // in bytes
            "last-mod"  => implode(" ", [$cols[5], $cols[6], $cols[7]]),
            "perm"      => $cols[0],
            "user"      => $cols[2],
            "group"     => $cols[3],
            "links"     => $cols[1],
        ];
        if ($cols[0][0] == "d") {
            $pretty["type"] = "dir";
        } else if ($cols[0][0] == "l") {
            $pretty["type"] = "link";
        }
        return $pretty;
    }
    
    // expects pretty file / filelist
    function ftp_delete_files($conn, $files, &$fails = null) {
        if (!$fails) {
            $fails =  [];
        }
        // array of files
        if ( is_array( array_values($files)[0] ) ) {
            foreach ($files as $file) {
                ftp_delete_files($conn, $file, $fails);
            }
        } else {
            // just file
            $file = $files;
            // it's a folder
            if ($file["type"] == "dir") {
                // non-empty folder
                if ( isset($file["children"]) ) {
                    // first delete all child files (and folders)
                    foreach ($file["children"] as $child) {
                        ftp_delete_files($conn, $child, $fails);
                    }
                    // then delete the (parent) folder
                    if (!@ftp_rmdir($conn, $file["path"])) {
                        $fails[] = $file;
                    }
                } else {
                    // empty folder
                    if (!@ftp_rmdir($conn, $file["path"])) {
                        $fails[] = $file;
                    }
                }
            } else {
                // it's a file
                if (!@ftp_delete($conn, $file["path"])) {
                    $fails[] = $file;
                }
            }
        }
        // for whatever reasons, these could not be deleted
        if (count($fails) > 0) {
            return $fails;
        }
        return true;
    }
    
    
    /* example output
    
    Array
    (
        [0] => Array
            (
                [name] => cgi-bin
                [path] => public_html/cgi-bin
                [parent] => public_html
                [type] => dir
                [size] => 4096
                [last-mod] => Mar 13 11:50
                [perm] => drwxr-xr-x
                [user] => 769
                [group] => test
                [links] => 2
                [children] => Array
                    (
                        [0] => Array
                            (
                                [name] => .htaccess
                                [path] => public_html/cgi-bin/.htaccess
                                [parent] => public_html/cgi-bin
                                [type] => file
                                [size] => 11
                                [last-mod] => Mar 13 11:44
                                [perm] => -rw-r--r--
                                [user] => 769
                                [group] => test
                                [links] => 1
                            )

                    )

            )

        [1] => Array
            (
                [name] => index.html
                [path] => public_html/index.html
                [parent] => public_html
                [type] => file
                [size] => 608
                [last-mod] => Mar 13 10:49
                [perm] => -rw-r--r--
                [user] => 769
                [group] => test
                [links] => 1
            )
    )
    */
    
?>