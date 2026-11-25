<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class ForecastRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getInstance();
    }

    public function getSelectedRun(string $scope = 'total'): ?array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM forecast_runs 
            WHERE scope = :scope AND is_selected = 1 
            ORDER BY id DESC LIMIT 1
        ");
        $stmt->execute(['scope' => $scope]);
        return $stmt->fetch() ?: null;
    }

    public function getAllRuns(string $scope = 'total'): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM forecast_runs 
            WHERE scope = :scope 
            ORDER BY id DESC
        ");
        $stmt->execute(['scope' => $scope]);
        return $stmt->fetchAll();
    }

    public function getForecastValues(int $runId, ?string $seriesKey = null, ?string $kind = null): array
    {
        $sql = "SELECT * FROM forecast_values WHERE run_id = :run_id";
        $params = ['run_id' => $runId];

        if ($seriesKey !== null) {
            $sql .= " AND series_key = :key";
            $params['key'] = $seriesKey;
        }
        if ($kind !== null) {
            $sql .= " AND kind = :kind";
            $params['kind'] = $kind;
        }

        $sql .= " ORDER BY period ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function saveRun(array $runData): int
    {
        $sql = "
            INSERT INTO forecast_runs 
            (scope, model, params, train_start, train_end, horizon, mape, rmse, mae, nrmse, is_selected, created_at)
            VALUES 
            (:scope, :model, :params, :train_start, :train_end, :horizon, :mape, :rmse, :mae, :nrmse, :is_selected, NOW())
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'scope'       => $runData['scope'],
            'model'       => $runData['model'],
            'params'      => json_encode($runData['params']),
            'train_start' => $runData['train_start'],
            'train_end'   => $runData['train_end'],
            'horizon'     => $runData['horizon'],
            'mape'        => $runData['mape'],
            'rmse'        => $runData['rmse'],
            'mae'         => $runData['mae'],
            'nrmse'       => $runData['nrmse'],
            'is_selected' => $runData['is_selected'] ? 1 : 0,
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function saveValues(int $runId, array $values): void
    {
        if (empty($values)) return;

        $sql = "
            INSERT INTO forecast_values (run_id, series_key, period, kind, point, lower, upper)
            VALUES (:run_id, :series_key, :period, :kind, :point, :lower, :upper)
        ";
        $stmt = $this->db->prepare($sql);

        foreach ($values as $v) {
            $stmt->execute([
                'run_id'     => $runId,
                'series_key' => $v['series_key'],
                'period'     => $v['period'] . '-01',
                'kind'       => $v['kind'],
                'point'      => $v['point'],
                'lower'      => $v['lower'] ?? null,
                'upper'      => $v['upper'] ?? null,
            ]);
        }
    }

    public function clearOldRuns(string $scope = 'total'): void
    {
        $stmt = $this->db->prepare("DELETE FROM forecast_runs WHERE scope = :scope");
        $stmt->execute(['scope' => $scope]);
    }
}
