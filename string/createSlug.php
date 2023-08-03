<?php

function createSlug($string, $userOptions = []) {
    
    $defaultOptions = [
        "lowercase" => true,
        "latinize"  => true,
        "normalize" => true,
        "nopunc"    => true,
        "case"      => "kebab",
        "strip"     => [],
    ];
    
    $options = array_merge($defaultOptions, $userOptions);
    
    if ($options["latinize"]) {
        $string = latinize($string);
    }
    
    if ($options["lowercase"]) {
        $string = strtolower($string);
    }
    
    if ($options["normalize"]) {
        $string = createSlug_normalize($string);
    }
    
    if ($options["nopunc"]) {
        $string = createSlug_purgePunctuation($string);
    }
    
    if (in_array($options["case"], ["kebab", "snake"])) {
        $words = preg_split('/\s+/', $string);
        if ($options['case'] === 'kebab') {
            $string = implode('-', $words);
        } elseif ($options['case'] === 'snake') {
            $string = implode('_', $words);
        }
    }
    
    if (in_array($options['case'], ['kebab', 'snake'])) {
        $string = preg_split('/\s+/', $string);
        if ($options['case'] === 'kebab') {
            $string = implode('-', $string);
        } elseif ($options['case'] === 'snake') {
            $string = implode('_', $string);
        }
    }
    
    if (!empty($options["strip"])) {
        $string = str_replace($options["strip"], "", $string);
    }
    
    return $string;
}

function createSlug_normalize($str) {
    $normalizationMap = [
        [".", " "],
        ["-", " "],
        ["—", " "],
        ["&", " and "],
    ];
    foreach ($normalizationMap as $map) {
        $str = str_replace($map[0], $map[1], $str);
    }
    return $str;
}

function createSlug_purgePunctuation($str) {
    $punctuationChars = [
        "<", ">", ":", "\"", "/", "\\", "|", "?", "*",
        "'", "¦", ".", ",", "!",
    ];
    $str = str_replace($punctuationChars, "", $str);
    return $str;
}