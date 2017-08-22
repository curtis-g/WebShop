<?php

class View {
    
    protected $template_dir = 
        '/ceri/homes1/c/cug1/public_html/cs25010/template/';
    
    
    protected $vars = array();
 
    public function __construct() {
    }
 
    public function render($template_file) {
        include $this->template_dir.$template_file;
    }
    
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
    public function __get($name) {
        return $this->vars[$name];
    }
}
?>