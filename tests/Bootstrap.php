<?php

use App\Config;
use App\Config\Autoload;
use App\Config\Constants;
use App\Index;

// Initialize components using their namespaces
$config = new Config();
$index = new Index();
$autoload = new Autoload();
$constants = new Constants();
