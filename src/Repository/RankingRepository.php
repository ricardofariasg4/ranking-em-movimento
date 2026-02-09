<?php

namespace App\Repository;

use PDO;

class RankingRepository
{
    public function __construct(private PDO $db) {}

    public function getRankingByMovementId(int $movementId): array
    {
        $sql = "
            SELECT
                u.name AS user_name,
                pr.value AS record_value,
                pr.date AS record_date,
                DENSE_RANK() OVER (ORDER BY pr.value DESC) AS position
            FROM user u
            JOIN (
                SELECT
                    user_id,
                    movement_id,
                    MAX(value) AS max_value
                FROM personal_record
                WHERE movement_id = :movement_id
                GROUP BY user_id, movement_id
            ) max_pr ON max_pr.user_id = u.id
            JOIN personal_record pr
                ON pr.user_id = max_pr.user_id
               AND pr.movement_id = max_pr.movement_id
               AND pr.value = max_pr.max_value
            ORDER BY pr.value DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['movement_id' => $movementId]);

        return $stmt->fetchAll();
    }

    public function getRankingByMovementName(string $movementName): array
    {
        $sql = "
            SELECT
                u.name AS user_name,
                pr.value AS record_value,
                pr.date AS record_date,
                DENSE_RANK() OVER (ORDER BY pr.value DESC) AS position
            FROM user u
            JOIN (
                SELECT
                    user_id,
                    movement_id,
                    MAX(value) AS max_value
                FROM personal_record
                WHERE movement_id = (
                    SELECT id FROM movement WHERE name = :movement_name
                )
                GROUP BY user_id, movement_id
            ) max_pr ON max_pr.user_id = u.id
            JOIN personal_record pr
                ON pr.user_id = max_pr.user_id
               AND pr.movement_id = max_pr.movement_id
               AND pr.value = max_pr.max_value
            ORDER BY pr.value DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['movement_name' => $movementName]);

        return $stmt->fetchAll();
    }
}