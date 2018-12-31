<?php
    
    function files_regroup() {
        global $_FILES;
        $files = [];
        foreach ($_FILES as $field_name => $file_options) {
            if ( is_array($file_options["name"]) ) {
                $files[$field_name] = [];
                for ($i = 0; $i < count($file_options["name"]); $i++) {
                    $options = [];
                    foreach ($file_options as $option => $value) {
                        $options[$option] = $file_options[$option][$i];
                    }
                    $files[$field_name][] = $options;
                }
            } else {
                $files[$field_name] = $file_options;
            }
        }
        return $files;
    }
    
    /* ============================== File Upload Errors ============================== */
    
    $GLOBALS["UPLOAD_ERR"] = [
        0 => "UPLOAD_ERR_OK",
        1 => "UPLOAD_ERR_INI_SIZE",
        2 => "UPLOAD_ERR_FORM_SIZE",
        3 => "UPLOAD_ERR_PARTIAL",
        4 => "UPLOAD_ERR_NO_FILE",
        6 => "UPLOAD_ERR_NO_TMP_DIR",
        7 => "UPLOAD_ERR_CANT_WRITE",
        8 => "UPLOAD_ERR_EXTENSION",
        
        "en" => [
            0 => "There is no error, the file uploaded with success.",
            1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
            2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
            3 => "The uploaded file was only partially uploaded.",
            4 => "No file was uploaded.",
            6 => "Missing a temporary folder.",
            7 => "Failed to write file to disk.",
            8 => "A PHP extension stopped the file upload.",
        ],
        
        "tr" => [
            0 => "Hata yok, dosya başarıyla yüklendi.",
            1 => "Yüklenen dosya php.ini içinde belirtilen upload_max_filesize limitini aşıyor.",
            2 => "Yüklenen dosya formda belirtilen MAX_FILE_SIZE limitini aşıyor.",
            3 => "Yüklenen dosya tamamen yüklenemedi.",
            4 => "Yüklenecek dosya yok.",
            6 => "Geçiçi klasör kayıp.",
            7 => "Diske yazma başarısız oldu.",
            8 => "Bir PHP eklentisi dosya yüklemeyi durdurdu.",
        ],
    ];
    
    /* ============================== Field Error Messages ============================== */
    
    $GLOBALS["FORM_ERRORS"] = [
        "en" => [
            "required"      => "This field is required.",
            "match"         => "Passwords do not match.",
            "missing"       => "Field is missing.",
            "empty"         => "Field is empty.",
            
            "whitelist"     => "Invalid value.",
            "blacklist"     => "Invalid value.",
            
            "min_length"    => "Input length should not be less than {0} characters.",
            "max_length"    => "Input length should not be greater than {0} characters.",
            "pattern"       => "Value does not match the expected pattern.",
            
            "min_date"      => "Input date should postdate {0}.",
            "max_date"      => "Input date should predate {0}.",
            
            "min_number"    => "Input value should not be less than {0}.",
            "max_number"    => "Input value should not be greater than {0}.",
            
            "accept"        => "Invalid file type or extension.",
            "multiple"      => "Input file count can't be greater than 1.",
            "max_filecount" => "Input file count can't exceed the limit ({0}).",
            "max_size"      => "Input file size should not be greater than {0} KB.",
            
            "max_width"     => "Image width should not be greater than {0} pixels.",
            "max_height"    => "Image height should not be greater than {0} pixels.",
        ],
        "tr" => [
            "required"      => "Bu alanın doldurulması zorunludur.",
            "match"         => "Şifreler birbirini tutmuyor.",
            "missing"       => "Alan bulunamadı.",
            "empty"         => "Alan boş.",
            
            "whitelist"     => "Bu izin verilen bir değer değil.",
            "blacklist"     => "Bu yasaklanmış bir değer.",
            
            "min_length"    => "Girdi uzunluğu en az {0} karakter olmalıdır.",
            "max_length"    => "Girdi uzunluğu en fazla {0} karakter olmalıdır.",
            "pattern"       => "Girdi değeri beklenen formata uymuyor.",
            
            "min_date"      => "Girilen tarih belirlenen tarihten ({0}) geride olamaz.",
            "max_date"      => "Girilen tarih belirlenen tarihten ({0}) ileride olamaz.",
            
            "min_number"    => "Girdi değeri en az {0} olabilir.",
            "max_number"    => "Girdi değeri en fazla {0} olabilir.",
            
            "accept"        => "Geçersiz dosya türü ya da uzantısı.",
            "multiple"      => "Dosya sayısı 1'den fazla olamaz.",
            "max_filecount" => "Dosya sayısı limiti ({0}) aşamaz.",
            "max_size"      => "Dosya boyutu en fazla {0} KB olabilir.",
            
            "max_width"     => "Resim genişliği en fazla {0} piksel olabilir.",
            "max_height"    => "Resim yüksekliği en fazla {0} piksel olabilir.",
        ],
    ];
    
    
    /* ============================== FormField ============================== */
    
    class FormField {
        // input
        public $type  = "text";
        public $name  = null;
        public $value = null;
        
        public $required = false;
        public $match    = null;
        
        // value
        public $whitelist = null;
        public $blacklist = null;
        
        // text
        public $min_length = null;
        public $max_length = null;
        public $pattern    = null;
        
        // text -> date
        public $min_date   = null;
        public $max_date   = null;
        
        // number
        public $min_number = null;
        public $max_number = null;
        
        // file
        public $accept        = null;
        public $multiple      = null;
        public $max_filecount = null;
        public $max_size      = null;
        
        // file -> image
        public $max_width  = null;
        public $max_height = null;
        
        // external check
        public $ajax = null;
        
        public function __construct($name = null, $value = null, $options = []) {
            $this->name  = $name;
            $this->value = $value;
            if (isset($options["type"]))     $this->type     = $options["type"];
            if (isset($options["required"])) $this->required = $options["required"];
            if (isset($options["match"]))    $this->match    = $options["match"];
            
            if (isset($options["whitelist"])) $this->whitelist = $options["whitelist"];
            if (isset($options["blacklist"])) $this->blacklist = $options["blacklist"];
            
            if (isset($options["min_length"])) $this->min_length = $options["min_length"];
            if (isset($options["max_length"])) $this->max_length = $options["max_length"];
            if (isset($options["pattern"]))    $this->pattern    = $options["pattern"];
            
            if (isset($options["min_date"]))   $this->min_date   = $options["min_date"];
            if (isset($options["max_date"]))   $this->max_date   = $options["max_date"];
            
            if (isset($options["min_number"])) $this->min_number = $options["min_number"];
            if (isset($options["max_number"])) $this->max_number = $options["max_number"];
            
            if (isset($options["accept"]))        $this->accept        = $options["accept"];
            if (isset($options["multiple"]))      $this->multiple      = $options["multiple"];
            if (isset($options["max_filecount"])) $this->max_filecount = $options["max_filecount"];
            if (isset($options["max_size"]))      $this->max_size      = $options["max_size"];
            
            if (isset($options["max_width"]))  $this->max_width  = $options["max_width"];
            if (isset($options["max_height"])) $this->max_height = $options["max_height"];
            
            if ($this->type == "number") {
                $this->min_number = (float) $this->min_number;
                $this->max_number = (float) $this->max_number;
                $this->value      = (float) $this->value;
            }
            if ($this->max_size !== null)   $this->max_size   = (int) $this->max_size;
            if ($this->max_width !== null)  $this->max_width  = (int) $this->max_width;
            if ($this->max_height !== null) $this->max_height = (int) $this->max_height;
            
            if (isset($options["ajax"])) $this->ajax = $options["ajax"];
        }
        
        public function whitelist_invalid() {
            return $this->whitelist !== null && !in_array($this->value, $this->whitelist);
        }
        public function blacklist_invalid() {
            return $this->blacklist !== null && in_array($this->value, $this->blacklist);
        }
        
        public function min_length_invalid() {
            if (in_array($this->value, [null, ""], true)) {
                return false;
            }
            return $this->min_length !== null && strlen($this->value) < $this->min_length;
        }
        public function max_length_invalid() {
            return $this->max_length !== null && strlen($this->value) > $this->max_length;
        }
        public function pattern_invalid() {
            return $this->pattern !== null && !preg_match($this->pattern, $this->value);
        }
        
        public function min_number_invalid() {
            return $this->min_number !== null && (float) $this->value < $this->min_number;
        }
        public function max_number_invalid() {
            return $this->max_number !== null && (float) $this->value > $this->max_number;
        }
        
        public function accept_invalid() {
            if ($this->accept !== null) {
                $type  = mime_content_type($this->value["tmp_name"]);
                $types = array_keys($this->accept);
                if (in_array($type, $types)) {
                    foreach ($this->accept as $key_type => $extensions) {
                        if ($key_type == $type) {
                            $fn = filename($this->value["name"]);
                            if (in_array($fn["extension"], $extensions)) {
                                return false;
                            }
                        }
                    }
                }
                return true;
            }
            return false;
        }
        
        public function multiple_invalid() {}
        public function max_filecount_invalid() {}
        
        public function max_size_invalid() {
            return $this->max_size !== null && ($this->value["size"] / 1024) > $this->max_size;
        }
        
        public function match_invalid($fields) {
            return $this->match !== null && $this->value != $fields[$this->match]->value;
        }
    }
    
    
    /* ============================== FormValidator ============================== */
    
    class FormValidator {
        
        public $locale = "en";
        public $method = "GET";
        public $fields = [];
        public $errors = [];
        
        public function __construct($method = "GET", $fields = [], $locale = "en") {
            $this->method = $method;
            $this->locale = $locale;
            if ($fields)
                $this->addFields($fields);
        }
        
        public function addFields($fields = []) {
            foreach ($fields as $field_name => $options) {
                $this->addField($field_name, $options);
            }
        }
        
        public function addField($field_name, $options) {
            
            global $FORM_ERRORS;
            
            $props = [$field_name];
            
            if (strpos($field_name, ",") !== false) {
                $props = preg_split('/, ?/', $field_name);
            }
            
            foreach ($props as $field_name) {
                        
                $field_value = null;
                
                if ($this->method == "GET") {
                    if (isset($_GET[$field_name])) {
                        $field_value = $_GET[$field_name];
                        $this->fields[$field_name] = new FormField($field_name, $field_value, $options);
                    }
                }
                else if ($this->method == "POST") {
                    if (isset($_POST[$field_name])) {
                        $field_value = $_POST[$field_name];
                    }
                    else if (isset($_FILES[$field_name])) {
                        $field_value = $_FILES[$field_name];
                    }
                    if ($field_value !== null) {
                        $this->fields[$field_name] = new FormField($field_name, $field_value, $options);
                    }
                }
                
                if ($field_value === null) {
                    $this->add_error($field_name, $FORM_ERRORS[$this->locale]["missing"]);
                }
            }
        }
        
        public function add_error($field_name, $error_message) {
            if (!isset($this->errors[$field_name])) {
                $this->errors[$field_name] = [];
            }
            $this->errors[$field_name][] = $error_message;
        }
        
        public function check($field) {
            global $FORM_ERRORS;
            
            if (in_array($field->type, ["text", "date"])) {
                if ($field->min_length_invalid()) $this->add_error($field->name, str_replace("{0}", $field->min_length, $FORM_ERRORS[$this->locale]["min_length"]));
                if ($field->max_length_invalid()) $this->add_error($field->name, str_replace("{0}", $field->max_length, $FORM_ERRORS[$this->locale]["max_length"]));
                if ($field->pattern_invalid())    $this->add_error($field->name, $FORM_ERRORS[$this->locale]["pattern"]);
                if ($field->type == "date") {
                    if ($field->min_date_invalid()) $this->add_error($field->name, str_replace("{0}", $field->min, $FORM_ERRORS[$this->locale]["min_date"]));
                    if ($field->max_date_invalid()) $this->add_error($field->name, str_replace("{0}", $field->max, $FORM_ERRORS[$this->locale]["max_date"]));
                }
            }
            else if ($field->type == "number") {
                if ($field->min_number_invalid()) $this->add_error($field->name, str_replace("{0}", $field->min, $FORM_ERRORS[$this->locale]["min_number"]));
                if ($field->max_number_invalid()) $this->add_error($field->name, str_replace("{0}", $field->max, $FORM_ERRORS[$this->locale]["max_number"]));
            }
            else if (in_array($field->type, ["file", "image"])) {
                if ($field->value["error"] == UPLOAD_ERR_OK) {
                    if ($field->accept_invalid())   $this->add_error($field->name, $FORM_ERRORS[$this->locale]["accept"]);
                    if ($field->max_size_invalid()) $this->add_error($field->name, str_replace("{0}", $field->max_size, $FORM_ERRORS[$this->locale]["max_size"]));
                    if ($field->type == "image") {
                        if ($field->max_width !== null || $field->max_height !== null) {
                            $dims = getimagesize($field->value["tmp_name"]);
                            if ($field->max_width !== null && $dims[0] > $field->max_width)   $this->add_error($field->name, str_replace("{0}", $field->max_width, $FORM_ERRORS[$this->locale]["max_width"]));
                            if ($field->max_height !== null && $dims[1] > $field->max_height) $this->add_error($field->name, str_replace("{0}", $field->max_height, $FORM_ERRORS[$this->locale]["max_height"]));
                        }
                    }
                }
            }
            
            if (!in_array($field->type, ["file", "image"])) {
                if ($field->whitelist_invalid()) $this->add_error($field->name, $FORM_ERRORS[$this->locale]["whitelist"]);
                if ($field->blacklist_invalid()) $this->add_error($field->name, $FORM_ERRORS[$this->locale]["blacklist"]);
                if ($field->match_invalid($this->fields)) $this->add_error($field->name, $FORM_ERRORS[$this->locale]["match"]);
            }
            
            if ($field->ajax !== null) {
                // ($field->ajax)($this, $field);
                $field->ajax->__invoke($this, $field);
            }
        }
        
        public function validate() {
            global $FORM_ERRORS, $UPLOAD_ERR;
            $this->errors = [];
            foreach ($this->fields as $field) {
                if ($field->required) {
                    if (is_string($field->value) && $field->value == "") {
                        $this->add_error($field->name, $FORM_ERRORS[$this->locale]["required"]);
                        continue;
                    }
                    else if (is_array($field->value) && $field->value["error"] != UPLOAD_ERR_OK) {
                        $this->add_error($field->name, $UPLOAD_ERR[$this->locale][$field->value["error"]]);
                        continue;
                    }
                }
                $this->check($field);
            }
        }
        
    }
    