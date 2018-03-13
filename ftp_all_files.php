<?php
    
    // https://stackoverflow.com/questions/49250700/ftp-rawlist-doesnt-list-htaccess
    function ftp_all_files($resource, $directory = ".") {
        $rawlist    = ftp_rawlist($resource, "-a " . $directory);
        $rawlist    = array_filter($rawlist, function ($item) { return !preg_match('/\.?\.$/', $item); });
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
    
?>