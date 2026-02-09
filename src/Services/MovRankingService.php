<?php

namespace App\Services;

use App\Repository\RankingRepository;

class MovRankingService
{
    private RankingRepository $rankingRepository;
    
    public function __construct(RankingRepository $rankingRepository)
    {
        $this->rankingRepository = $rankingRepository;
    }
    
    public function getRankingByMovement($movementParam, $isNumeric)
    {
        // Se o parâmetro for numérico, trata como ID; caso contrário, trata como nome
        if ($isNumeric) {
            return $this->rankingRepository->getRankingByMovementId((int)$movementParam);
        }
        
        return $this->rankingRepository->getRankingByMovementName($movementParam);
    }
}