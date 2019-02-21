<?php
    
    $SELF_CLOSING_TAGS = [
        "meta",
        "input",
        "img",
        "link",
        "base",
    ];
    
    class HTMLElement {
        
        public $tag_name   = "";
        public $id         = "";
        public $class_list = [];
        public $attributes = [];
        public $children   = [];
        public $indent     = 0;
        
        function __construct($tag_name = "") {
            $this->tag_name = $tag_name;
        }
        
        public function attr($attr = "", $value = "") {
            if ($attr != "") {
                $this->attributes[$attr] = $value;
            }
        }
        
        public function append($element = null) {
            $type  = gettype($element);
            $types = ["string", "integer", "double", "boolean"];
            
            if ($type == "string") {
                $this->children[] = $element;
            }
            else if (in_array($type, ["integer", "double"])) {
                $this->children[] = (string) $element;
            }
            else if ($element instanceof HTMLElement) {
                $this->children[] = $element;
            }
        }
        
        public function html() {
            
            global $SELF_CLOSING_TAGS;
            
            $inner_html = "";
            
            foreach ($this->children as $child) {
                $type = gettype($child);
                if ($type == "string") {
                    $inner_html .= $child;
                } else if ($type == "object") {
                    $inner_html .= $child->html();
                }
            }
            
            $attributes = "";
            
            if ($this->id != "") {
                $attributes .= " id=\"{$this->id}\"";
            }
            
            if (count($this->class_list) > 0) {
                $classes     = implode(" ", $this->class_list);
                $attributes .= " class=\"{$classes}\"";
            }
            
            foreach ($this->attributes as $attr => $value) {
                $attributes .= " {$attr}=\"{$value}\"";
            }
            
            if (in_array($this->tag_name, $SELF_CLOSING_TAGS)) {
                return "<{$this->tag_name}{$attributes} />";
            }
            
            $tag_open  = "<{$this->tag_name}{$attributes}>";
            $tag_close = "</{$this->tag_name}>";
            
            return $tag_open . $inner_html . $tag_close;
        }
        
        public function output() {
            echo $this->html();
        }
    }
    
    function elem($tag_name = "", $attributes = null, $children = null) {
        $element = new HTMLElement($tag_name);
        
        if ($attributes != null) {
            foreach ($attributes as $key => $value) {
                $element->attr($key, $value);
            }
        }
        
        if ($children != null) {
            elem_append($element, $children);
        }
        
        return $element;
    }
    
    function elem_append($element, $children = null) {
        if ($children != null) {
            $type = gettype($children);
            
            switch ($type) {
                
                case "string":
                case "integer":
                case "double":
                case "boolean":
                    $element->append($children);
                    break;
                
                case "array":
                    foreach ($children as $child) {
                        elem_append($element, $child);
                    }
                    break;
                    
                case "object":
                    if ($children instanceof HTMLElement) {
                        $element->append($children);
                    }
                    else if (is_callable($children)) {
                        elem_append($element, $children());
                    }
                    break;
            }
        }
    }
    
?>