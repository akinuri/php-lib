<?php
    
    /* ========================= HELPER FUNCTIONS ========================= */
    
    defined('TAB_SIZE') or define('TAB_SIZE', 4);
    defined('TAB_CHAR') or define('TAB_CHAR', '\t');
    defined('PRETTY_PRINT') or define('PRETTY_PRINT', false);
    
    function TAB($times = 0) {
        if (TAB_CHAR == "\t") {
            return str_repeat("\t", $times);
        }
        return str_repeat(TAB_CHAR, ($times * TAB_SIZE));
	}
    
    function EOL($times = 0) {
		return str_repeat(PHP_EOL, $times);
	}
    
    
    /* ========================= HTMLElement ========================= */
    
    $SELF_CLOSING_TAGS = ["img", "input", "br", "link"];
    
    class HTMLElement {
        
        public $tagName     = "";
        public $attributes  = [];
        public $children    = [];
        
        public $indent = 0;
        
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
            
            $html = "<{$this->tagName}";
            
            if (count($this->attributes) > 0) {
                foreach ($this->attributes as $key => $value) {
                    $html .= " {$key}=\"{$value}\"";
                }
            }
            
            if (in_array($this->tagName, $SELF_CLOSING_TAGS)) {
                $html .= " />";
                return $html;
            }
            
            $html .= ">";
            
            if (count($this->children) > 0) {
                foreach ($this->children as $child) {
                    if (is_string($child)) {
                        $html .= $child;
                    }
                    else if ($child instanceof HTMLElement) {
                        $html .= $child->html();
                    }
                }
            }
            
            $html .= "</{$this->tagName}>";
            
            return $html;
        }
    }
    
?>