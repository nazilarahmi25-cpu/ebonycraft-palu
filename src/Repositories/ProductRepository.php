<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class ProductRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getInstance();
    }

    private function buildWhere(array $filters): array
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['date_from'])) {
            $conditions[] = "o.order_date >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = "o.order_date <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }
        if (!empty($filters['category_id'])) {
            $conditions[] = "p.category_id = :category_id";
            $params['category_id'] = (int)$filters['category_id'];
        }
        if (!empty($filters['channel_id'])) {
            $conditions[] = "o.channel_id = :channel_id";
            $params['channel_id'] = (int)$filters['channel_id'];
        }
        if (!empty($filters['region_id'])) {
            $conditions[] = "o.region_id = :region_id";
            $params['region_id'] = (int)$filters['region_id'];
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        return [$whereClause, $params];
    }

    // C06: Top 10 Best Selling Products
    public function getTopProducts(int $limit = 10, array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                p.id,
                p.name AS product_name,
                c.name AS category_name,
                p.price,
                SUM(oi.qty) AS units_sold,
                SUM(oi.subtotal) AS revenue
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            {$where}
            GROUP BY p.id, p.name, c.name, p.price
            ORDER BY revenue DESC
            LIMIT {$limit}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C07: Revenue Composition by Category
    public function getRevenueByCategory(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                c.id AS category_id,
                c.name AS category_name,
                SUM(oi.subtotal) AS revenue,
                SUM(oi.qty) AS units_sold
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            {$where}
            GROUP BY c.id, c.name
            ORDER BY revenue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C08: Pareto 80/20 Analysis
    public function getParetoData(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                p.id,
                p.name AS product_name,
                SUM(oi.subtotal) AS revenue
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY p.id, p.name
            ORDER BY revenue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        $totalRev = array_sum(array_column($items, 'revenue'));
        $cumRev = 0.0;

        foreach ($items as &$item) {
            $cumRev += (float)$item['revenue'];
            $item['cum_pct'] = $totalRev > 0 ? round(($cumRev / $totalRev) * 100, 2) : 0.0;
        }

        return $items;
    }

    // C09: Price vs Volume vs Margin (Bubble)
    public function getPriceVolumeMargin(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                p.id,
                p.name AS product_name,
                c.name AS category_name,
                p.price,
                SUM(oi.qty) AS units_sold,
                SUM(oi.subtotal) AS revenue,
                SUM(oi.qty * oi.unit_hpp) AS total_hpp
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            {$where}
            GROUP BY p.id, p.name, c.name, p.price
            ORDER BY revenue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        foreach ($rows as &$r) {
            $rev = (float)$r['revenue'];
            $hpp = (float)$r['total_hpp'];
            $profit = $rev - $hpp;
            $r['margin_pct'] = $rev > 0 ? round(($profit / $rev) * 100, 1) : 0.0;
        }

        return $rows;
    }

    // C10: Category Revenue Trend over Time
    public function getCategoryTrend(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                DATE_FORMAT(o.order_date, '%Y-%m') AS period,
                c.id AS category_id,
                c.name AS category_name,
                SUM(oi.subtotal) AS revenue
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            {$where}
            GROUP BY DATE_FORMAT(o.order_date, '%Y-%m'), c.id, c.name
            ORDER BY period ASC, c.id ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
