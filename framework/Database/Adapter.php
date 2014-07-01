<?php

namespace Framework\Database;

class Adapter {

    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function fetchAll($sql, $args = array()) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $args = array()) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getStatement($sql) {
        return $this->pdo->prepare($sql);
    }

}