<?php

require_once 'autoload.php';

use app\App;

$app = new App();

$app->registerRoutes()->run();
