<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class SalesRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getInstance();
    }

    private function buildWhere(array $filters, string $orderAlias = 'o', string $itemAlias = 'oi'): array
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['date_from'])) {
            $conditions[] = "{$orderAlias}.order_date >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = "{$orderAlias}.order_date <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }
        if (!empty($filters['category_id'])) {
            $conditions[] = "p.category_id = :category_id";
            $params['category_id'] = (int)$filters['category_id'];
        }
        if (!empty($filters['channel_id'])) {
            $conditions[] = "{$orderAlias}.channel_id = :channel_id";
            $params['channel_id'] = (int)$filters['channel_id'];
        }
        if (!empty($filters['region_id'])) {
            $conditions[] = "{$orderAlias}.region_id = :region_id";
            $params['region_id'] = (int)$filters['region_id'];
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        return [$whereClause, $params];
    }

    public function getKpiSummary(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                COUNT(DISTINCT o.id) AS total_orders,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS total_revenue,
                COALESCE(SUM(oi.qty * oi.unit_hpp), 0) AS total_hpp
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch() ?: ['total_orders' => 0, 'total_revenue' => 0, 'total_hpp' => 0];

        $orders = (int)$row['total_orders'];
        $rev = (float)$row['total_revenue'];
        $hpp = (float)$row['total_hpp'];
        $grossProfit = $rev - $hpp;
        $margin = $rev > 0 ? ($grossProfit / $rev) * 100 : 0.0;
        $aov = $orders > 0 ? ($rev / $orders) : 0.0;

        return [
            'total_revenue' => $rev,
            'total_orders'  => $orders,
            'gross_profit'  => $grossProfit,
            'margin_pct'    => round($margin, 1),
            'aov'           => round($aov, 0),
        ];
    }

    // C01: Monthly Revenue Trend
    public function getMonthlyRevenue(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                DATE_FORMAT(o.order_date, '%Y-%m') AS period,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY DATE_FORMAT(o.order_date, '%Y-%m')
            ORDER BY period ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C02: YoY Monthly Comparison
    public function getYearOverYear(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                YEAR(o.order_date) AS order_year,
                MONTH(o.order_date) AS order_month,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY YEAR(o.order_date), MONTH(o.order_date)
            ORDER BY order_year ASC, order_month ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C03: Revenue vs Gross Profit & Margin %
    public function getRevenueAndProfit(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                DATE_FORMAT(o.order_date, '%Y-%m') AS period,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue,
                COALESCE(SUM(oi.qty * oi.unit_hpp), 0) AS hpp
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY DATE_FORMAT(o.order_date, '%Y-%m')
            ORDER BY period ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C04: Seasonal Heatmap (Month x Year)
    public function getSeasonalHeatmap(array $filters = []): array
    {
        return $this->getYearOverYear($filters);
    }

    // C05: Sales by Day of Week
    public function getSalesByDayOfWeek(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        // In MySQL DAYOFWEEK: 1=Sun, 2=Mon, 3=Tue, 4=Wed, 5=Thu, 6=Fri, 7=Sat
        $sql = "
            SELECT 
                DAYOFWEEK(o.order_date) AS day_num,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue,
                COUNT(DISTINCT o.id) AS order_count
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY DAYOFWEEK(o.order_date)
            ORDER BY day_num ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C11: Revenue per Channel
    public function getRevenueByChannel(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                c.name AS channel_name,
                c.is_online,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN channels c ON o.channel_id = c.id
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY c.id, c.name, c.is_online
            ORDER BY revenue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C12: Channel Share Shift per Year
    public function getChannelShiftPerYear(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                YEAR(o.order_date) AS order_year,
                c.name AS channel_name,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN channels c ON o.channel_id = c.id
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY YEAR(o.order_date), c.id, c.name
            ORDER BY order_year ASC, c.id ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C13: Revenue per Region (Treemap)
    public function getRevenueByRegion(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                r.name AS region_name,
                r.region_group,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN regions r ON o.region_id = r.id
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY r.id, r.name, r.region_group
            ORDER BY revenue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C14: Buyer Segments
    public function getRevenueBySegment(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                cust.segment,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue,
                COUNT(DISTINCT cust.id) AS customer_count
            FROM orders o
            JOIN customers cust ON o.customer_id = cust.id
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY cust.segment
            ORDER BY revenue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C15: New vs Repeat Customers
    public function getNewVsRepeatCustomers(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                DATE_FORMAT(o.order_date, '%Y-%m') AS period,
                SUM(CASE WHEN o.is_repeat = 0 THEN 1 ELSE 0 END) AS new_orders,
                SUM(CASE WHEN o.is_repeat = 1 THEN 1 ELSE 0 END) AS repeat_orders,
                COUNT(DISTINCT o.id) AS total_orders
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY DATE_FORMAT(o.order_date, '%Y-%m')
            ORDER BY period ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C16: Transaction Value Distribution (Histogram)
    public function getOrderValues(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT DISTINCT o.id, o.net_total
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    }

    // C17: Payment Methods
    public function getPaymentMethods(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                o.payment_method,
                COUNT(DISTINCT o.id) AS order_count,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY o.payment_method
            ORDER BY order_count DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // C18: AOV Monthly Trend
    public function getMonthlyAov(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "
            SELECT 
                DATE_FORMAT(o.order_date, '%Y-%m') AS period,
                COUNT(DISTINCT o.id) AS order_count,
                COALESCE(SUM(oi.subtotal), 0) - COALESCE(SUM(DISTINCT o.discount), 0) AS revenue
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            {$where}
            GROUP BY DATE_FORMAT(o.order_date, '%Y-%m')
            ORDER BY period ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getFilterOptions(): array
    {
        $categories = $this->db->query("SELECT id, name FROM categories ORDER BY id ASC")->fetchAll();
        $channels   = $this->db->query("SELECT id, name FROM channels ORDER BY id ASC")->fetchAll();
        $regions    = $this->db->query("SELECT id, name, region_group FROM regions ORDER BY region_group, name ASC")->fetchAll();

        $dateRange = $this->db->query("SELECT MIN(order_date) AS min_date, MAX(order_date) AS max_date FROM orders")->fetch();

        return [
            'categories' => $categories,
            'channels'   => $channels,
            'regions'    => $regions,
            'date_range' => [
                'min' => $dateRange['min_date'] ?? '2023-01-01',
                'max' => $dateRange['max_date'] ?? '2026-10-31',
            ]
        ];
    }
}
