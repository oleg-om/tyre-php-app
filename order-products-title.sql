-- Название и категория товара в заказе: товар могут удалить при загрузке прайса,
-- а в админке заказа должно остаться, что заказали и за какие деньги (цена уже хранится в price).
-- Запуск: mysql -u USER -p DB < order-products-title.sql

ALTER TABLE `order_products`
  ADD COLUMN `title` varchar(255) NOT NULL DEFAULT '' AFTER `product_id`,
  ADD COLUMN `category_id` tinyint(3) unsigned NOT NULL DEFAULT 0 AFTER `title`;

-- Заполняем старые заказы, пока товары ещё есть — как в OrdersController::_orderProductInfo
-- (крепёж: тип из Product::$bolt_types + виртуальное поле bolt).
UPDATE `order_products` op
  JOIN `products` p ON p.id = op.product_id
  LEFT JOIN `brands` b ON b.id = p.brand_id
  LEFT JOIN `brand_models` m ON m.id = p.model_id
SET op.category_id = p.category_id,
    op.title = CASE p.category_id
      WHEN 1 THEN CONCAT_WS(' ', b.title, m.title, CONCAT(p.size1, '/', p.size2, ' R', p.size3))
      WHEN 2 THEN CONCAT_WS(' ', b.title, m.title, CONCAT('R', p.size1, ' ', p.size3, 'J ', p.size2))
      WHEN 3 THEN CONCAT_WS(' ', b.title, m.title, CONCAT(p.ah, 'ач ', p.f1))
      ELSE CONCAT(
        CASE p.bolt_type WHEN 'bolt' THEN 'болт' WHEN 'nut' THEN 'гайка' WHEN 'ring' THEN 'кольцо' WHEN 'valve' THEN 'вентиль' ELSE '' END,
        ' ',
        IF(p.bolt_type = 'ring', CONCAT(p.size1, 'x', p.size2), CONCAT(p.size1, 'x', p.size2, 'x', p.size3, 'x', p.f1, ' ', p.color, ' ', p.material))
      )
    END
WHERE op.title = '';
