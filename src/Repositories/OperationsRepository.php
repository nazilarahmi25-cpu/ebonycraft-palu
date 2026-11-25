<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class OperationsRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getInstance();
    }

    // C19: Stock vs Sold Units
    public function getStockVsSold(array $filters = []): array
    {
        $sql = "
            SELECT 
                DATE_FORMAT(inv.month, '%Y-%m') AS period,
                SUM(inv.closing_stock) AS total_stock,
                COALESCE(sold.sold_qty, 0) AS units_sold
            FROM inventory_snapshots inv
            LEFT JOIN (
                SELECT 
                    DATE_FORMAT(o.order_date, '%Y-%m') AS m_period,
                    SUM(oi.qty) AS sold_qty
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                GROUP BY DATE_FORMAT(o.order_date, '%Y-%m')
            ) sold ON DATE_FORMAT(inv.month, '%Y-%m') = sold.m_period
            GROUP BY DATE_FORMAT(inv.month, '%Y-%m'), sold.sold_qty
            ORDER BY period ASC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // C20: Cost Structure per Year
    public function getCostStructurePerYear(): array
    {
        $sql = "
            SELECT 
                YEAR(month) AS cost_year,
                cost_type,
                SUM(amount) AS total_amount
            FROM monthly_costs
            GROUP BY YEAR(month), cost_type
            ORDER BY cost_year ASC, cost_type ASC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // C21: Lead Time by Category (for Boxplot)
    public function getLeadTimesByCategory(): array
    {
        $sql = "
            SELECT 
                c.id AS category_id,
                c.name AS category_name,
                pb.lead_time_days
            FROM production_batches pb
            JOIN products p ON pb.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            ORDER BY c.id ASC, pb.lead_time_days ASC
        ";

        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll();

        $grouped = [];
        foreach ($rows as $row) {
            $cat = $row['category_name'];
            $grouped[$cat][] = (int)$row['lead_time_days'];
        }

        return $grouped;
    }
}
