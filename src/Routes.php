<?php

namespace App;

use App\Core\Router;
use App\Controllers\MovRankingController;

class Routes
{
    public static function register(Router $router): void
    {
        $router->get('/movranking', [MovRankingController::class, 'show']);
    }
}