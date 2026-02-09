<?php

namespace App\Controllers;

use App\Services\MovRankingService;
use App\Helpers\JsonResponse;

class MovRankingController
{
    private MovRankingService $movRankingService;

    public function __construct(MovRankingService $movRankingService)
    {
        $this->movRankingService = $movRankingService;
    }

    public function show()
    {
        $movementParam = $_GET['movement'];

        if (empty($movementParam)) {
            http_response_code(400);
            echo json_encode(['error' => 'Movement parameter is required']);
            return;
        }

        $ranking = $this->movRankingService->getRankingByMovement(
            $movementParam, 
            is_numeric($movementParam)
        );

        if (!empty($ranking)) {
            JsonResponse::success($ranking);
        } else {
            JsonResponse::error('Invalid movement parameter', 400);
        }
    }
}