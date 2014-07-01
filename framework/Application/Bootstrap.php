<?php

namespace Framework\Application;

use Aura\Di\Container;
use Framework\Routing\Regex;

class Bootstrap {

    protected $di;
    protected $config;
    protected $router;
    
    public function __construct($config, Container $di, Regex $router) {
        $this->router = $router;
        $this->di = $di;
        $this->_setupConfig($config);
    }
    
    public function execute() {
        $call = $this->router->handleRoute();
        $class = $call['class'];
        $method =$call['method'];


        $o = $this->di->newInstance($class);
        return $o->$method();
    }
    
    private function _setupConfig($config) {
        $this->config = $config;
    }
    
}