<?php
    
    $SELF_CLOSING_TAGS = ["img", "input", "br", "link"];
    
    class HTMLElement {
        
        public $tagName     = "";
        public $attributes  = [];
        public $children    = [];
        
        function __construct($tagName = "", $attributes = null, $children = null) {
            $this->tagName = $tagName;
            if ($attributes) {
                $this->attributes = $attributes;
            }
            if ($children) {
                if (is_array($children)) {
                    $this->children = $children;
                }
                else if (is_string($children) || $children instanceof HTMLElement) {
                    $this->children[] = $children;
                }
            }
        }
        
        public function html() {
            
            global $SELF_CLOSING_TAGS;
            
            $element = "<{$this->tagName}";
            
            if (count($this->attributes) > 0) {
                foreach ($this->attributes as $key => $value) {
                    $element .= " {$key}=\"{$value}\"";
                }
            }
            
            if (in_array($this->tagName, $SELF_CLOSING_TAGS)) {
                $element .= " />";
                return $element;
            }
            
            $element .= ">";
            
            if (count($this->children) > 0) {
                
                foreach ($this->children as $child) {
                    
                    if (is_string($child)) {
                        $element .= $child;
                    }
                    else if ($child instanceof HTMLElement) {
                        $element .= $child->html();
                    }
                    
                }
                
            }
            
            $element .= "</{$this->tagName}>";
            
            return $element;
        }
    }
    
?>