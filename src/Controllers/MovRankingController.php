<?php

namespace App\Controllers;

use App\Database\Connection;
use App\Repository\RankingRepository;
use App\Services\MovRankingService;

class MovRankingController
{
    public function show()
    {
        $movementParam = $_GET['movement'];

        if (empty($movementParam)) {
            http_response_code(400);
            echo json_encode(['error' => 'Movement parameter is required']);
            return;
        }

        $dbConnection = Connection::getInstance();
        $rankingRepository = new RankingRepository($dbConnection);
        $service = new MovRankingService($rankingRepository);
        $ranking = $service->getRankingByMovement($movementParam, is_numeric($movementParam));

        header('Content-Type: application/json');

        if (isset($ranking)) {
            echo json_encode($ranking);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid movement parameter']);
        }
    }
}