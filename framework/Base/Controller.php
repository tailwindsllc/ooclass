<?php

namespace Framework\Base;

use Aura\Sql\Connection;

class Controller {

    protected $adapter;

    public function __construct(Connection\AbstractConnection $connection) {
        $this->adapter = $connection;
    }


}