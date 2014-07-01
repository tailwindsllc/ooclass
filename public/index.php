<?php

session_start();

require_once('../vendor/autoload.php');
require_once('../config.php');

$framework = $di->newInstance('Framework\Application\Bootstrap');
echo $framework->execute();