<?php

namespace app\interfaces;

use app\App;

interface RoutesInterface {
    public function register(App $app): void;
}