<?php

namespace Framework\Routing;

class Regex {

    protected $routes;

    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    public function handleRoute()
    {
        if (isset($_SERVER['REDIRECT_BASE'])) {
            $rb = $_SERVER['REDIRECT_BASE'];
        } else {
            $rb = '';
        }

        $ruri = $_SERVER['REQUEST_URI'];
        $path = str_replace($rb, '', $ruri);
        $return = array();

        foreach($this->routes as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if(preg_match($pattern, $path, $matches))
            {
                $controller_details = $v;
                $return = $controller_details;
            }
        }

        return $return;
    }

}