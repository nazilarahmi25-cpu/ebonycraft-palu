-- Database Schema for EbonyCraft Palu
-- Generated according to ARCHITECTURE.md Section 5

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS forecast_values;
DROP TABLE IF EXISTS forecast_runs;
DROP TABLE IF EXISTS monthly_costs;
DROP TABLE IF EXISTS inventory_snapshots;
DROP TABLE IF EXISTS production_batches;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS regions;
DROP TABLE IF EXISTS channels;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Master: Categories
CREATE TABLE categories (
  id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Master: Products
CREATE TABLE products (
  id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  sku VARCHAR(20) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  category_id TINYINT UNSIGNED NOT NULL,
  price INT UNSIGNED NOT NULL,              -- harga jual (Rp)
  hpp INT UNSIGNED NOT NULL,                -- harga pokok per unit (Rp)
  lead_time_base TINYINT UNSIGNED NOT NULL, -- hari, dasar simulasi produksi
  is_active BOOLEAN NOT NULL DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Master: Channels
CREATE TABLE channels (
  id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(40) NOT NULL UNIQUE,
  is_online BOOLEAN NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Master: Regions
CREATE TABLE regions (
  id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(60) NOT NULL UNIQUE,
  region_group ENUM('Sulawesi Tengah','Domestik Luar Sulteng','Luar Negeri') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Master: Customers
CREATE TABLE customers (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  segment ENUM('Wisatawan','Warga Lokal','Instansi','Reseller','Kolektor') NOT NULL,
  region_id SMALLINT UNSIGNED NOT NULL,
  first_order_date DATE NOT NULL,
  FOREIGN KEY (region_id) REFERENCES regions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Transactions: Orders
CREATE TABLE orders (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  order_no VARCHAR(20) NOT NULL UNIQUE,
  order_date DATE NOT NULL,
  customer_id INT UNSIGNED NOT NULL,
  channel_id TINYINT UNSIGNED NOT NULL,
  region_id SMALLINT UNSIGNED NOT NULL,
  payment_method ENUM('Tunai','Transfer','QRIS','COD','Marketplace') NOT NULL,
  discount INT UNSIGNED NOT NULL DEFAULT 0,
  shipping_cost INT UNSIGNED NOT NULL DEFAULT 0,
  is_repeat BOOLEAN NOT NULL,
  net_total INT UNSIGNED NOT NULL,          -- SUM(subtotal) - discount (tanpa ongkir)
  FOREIGN KEY (customer_id) REFERENCES customers(id),
  FOREIGN KEY (channel_id) REFERENCES channels(id),
  FOREIGN KEY (region_id) REFERENCES regions(id),
  INDEX idx_orders_date (order_date),
  INDEX idx_orders_channel_date (channel_id, order_date),
  INDEX idx_orders_region_date (region_id, order_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Transactions: Order Items
CREATE TABLE order_items (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  order_id INT UNSIGNED NOT NULL,
  product_id SMALLINT UNSIGNED NOT NULL,
  qty SMALLINT UNSIGNED NOT NULL,
  unit_price INT UNSIGNED NOT NULL,
  unit_hpp INT UNSIGNED NOT NULL,
  subtotal INT UNSIGNED NOT NULL,           -- qty * unit_price
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id),
  INDEX idx_items_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Operations: Production Batches
CREATE TABLE production_batches (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  product_id SMALLINT UNSIGNED NOT NULL,
  batch_date DATE NOT NULL,
  qty SMALLINT UNSIGNED NOT NULL,
  lead_time_days TINYINT UNSIGNED NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id),
  INDEX idx_batch_date (batch_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Operations: Inventory Snapshots
CREATE TABLE inventory_snapshots (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  product_id SMALLINT UNSIGNED NOT NULL,
  month DATE NOT NULL,                      -- tanggal 1 tiap bulan
  closing_stock SMALLINT UNSIGNED NOT NULL,
  UNIQUE KEY uq_inv (product_id, month),
  FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Operations: Monthly Costs
CREATE TABLE monthly_costs (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  month DATE NOT NULL,
  cost_type ENUM('bahan_baku','tenaga_kerja','finishing','kemasan',
                 'promosi','ongkir','biaya_platform','lainnya') NOT NULL,
  amount BIGINT UNSIGNED NOT NULL,
  UNIQUE KEY uq_cost (month, cost_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Forecasting: Runs
CREATE TABLE forecast_runs (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  scope ENUM('total','category') NOT NULL,
  model ENUM('holt_winters','seasonal_regression','seasonal_ma') NOT NULL,
  params JSON NOT NULL,                     -- alpha, beta, gamma, tipe musiman, dst.
  train_start DATE NOT NULL,
  train_end DATE NOT NULL,
  horizon TINYINT UNSIGNED NOT NULL,
  mape DECIMAL(6,2),
  rmse DECIMAL(14,2),
  mae DECIMAL(14,2),
  nrmse DECIMAL(6,2),
  is_selected BOOLEAN NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Forecasting: Values
CREATE TABLE forecast_values (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  run_id INT UNSIGNED NOT NULL,
  series_key VARCHAR(30) NOT NULL,          -- 'total' atau 'cat:<id>'
  period DATE NOT NULL,                     -- tanggal 1 tiap bulan
  kind ENUM('backtest','future') NOT NULL,
  point DECIMAL(14,2) NOT NULL,
  lower DECIMAL(14,2),
  upper DECIMAL(14,2),
  FOREIGN KEY (run_id) REFERENCES forecast_runs(id) ON DELETE CASCADE,
  INDEX idx_fv (run_id, series_key, period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Auth: Users
CREATE TABLE users (
  id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(40) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
