-- Оптимизация индексов для таблицы products
-- Эти индексы оптимизируют часто выполняемые запросы с фильтрами
-- Внимание: Если индекс уже существует, команда выдаст ошибку - это нормально, просто пропустите его

-- Индекс для основных фильтров: category_id, is_active, price, stock_count
-- Используется в большинстве SELECT DISTINCT запросов
ALTER TABLE `products` ADD INDEX `idx_category_active_price_stock` (`category_id`, `is_active`, `price`, `stock_count`);

-- Индекс для фильтров с in_stock
ALTER TABLE `products` ADD INDEX `idx_category_active_stock` (`category_id`, `is_active`, `stock_count`, `in_stock`);

-- Индекс для фильтров по размерам (size1, size2, size3)
ALTER TABLE `products` ADD INDEX `idx_size_filter` (`category_id`, `is_active`, `price`, `stock_count`, `size1`, `size2`, `size3`);

-- Индекс для model_id (используется в JOIN)
ALTER TABLE `products` ADD INDEX `idx_model_id` (`model_id`);

-- Индекс для фильтра по auto
ALTER TABLE `products` ADD INDEX `idx_auto_filter` (`category_id`, `is_active`, `price`, `stock_count`, `auto`);

-- Индекс для brand_id (может использоваться в JOIN)
ALTER TABLE `products` ADD INDEX `idx_brand_id` (`brand_id`);

-- Индекс для комбинации полей, используемых в ORDER BY
ALTER TABLE `products` ADD INDEX `idx_category_active_price_order` (`category_id`, `is_active`, `price`, `stock_count`, `size1`, `size2`);
