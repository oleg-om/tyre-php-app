<?php
class RendererHelper extends AppHelper {
	public $helpers = array('Html', 'Form', 'Backend', 'Frontend', 'Time', 'Number');
	public function page_slug($item, $model) {
		return '<td>' . Router::url(array('controller' => 'pages', 'action' => 'view', 'slug' => $item['slug'], 'admin' => false)) . '</td>';
	}
	public function brand_photo($item, $model) {
		if (!empty($item['filename'])) {
			$src = $this->Backend->thumbnail(array('id' => $item['id'], 'filename' => $item['filename'], 'path' => 'brands', 'width' => 160, 'height' => 60, 'crop' => false, 'folder' => false));
		}
		else {
			$src = 'no-160x20.gif';
		}
		return '<td>' . $this->Html->link($this->Html->image($src), array('controller' => 'brands', 'action' => 'admin_edit', $item['id']), array('escape' => false)) . '</td>';
	}
	public function home_photo($item, $model) {
		$src = $this->Backend->thumbnail(array('id' => $item['id'], 'filename' => $item['filename'], 'path' => 'slider', 'width' => 300, 'height' => 145, 'crop' => true, 'folder' => false));
		return '<td>' . $this->Html->link($this->Html->image($src), array('controller' => 'home_photos', 'action' => 'admin_edit', $item['id']), array('escape' => false)) . '</td>';
	}
	public function model_photo($item, $model) {
		if (!empty($item['filename'])) {
			$src = $this->Backend->thumbnail(array('id' => $item['id'], 'filename' => $item['filename'], 'path' => 'models', 'width' => 121, 'height' => 121, 'crop' => false, 'folder' => false));
		}
		else {
			$src = 'no-160x20.gif';
		}
		return '<td>' . $this->Html->link($this->Html->image($src), array('controller' => 'models', 'action' => 'admin_edit', $item['id']), array('escape' => false)) . '</td>';
	}
	public function tube_photo($item, $model) {
		if (!empty($item['filename'])) {
			$src = $this->Backend->thumbnail(array('id' => $item['id'], 'filename' => $item['filename'], 'path' => 'tubes', 'width' => 121, 'height' => 121, 'crop' => false, 'folder' => false));
		}
		else {
			$src = 'no-160x20.gif';
		}
		return '<td>' . $this->Html->link($this->Html->image($src), array('controller' => 'tubes', 'action' => 'admin_edit', $item['id']), array('escape' => false)) . '</td>';
	}
	public function tyre_size($item, $model) {
		return '<td>' . $item['size1'] . '/' . $item['size2'] . '&nbsp;R' . $item['size3'] . '</td>';
	}
	public function tyre_f($item, $model) {
		return '<td>' . $item['f1'] . $item['f2'] . '</td>';
	}
	

	public function price_prices($item, $model) {
		$price_car = $item['price_car'];
		$price_suv = $item['price_suv'];
		return '<td>' . $price_car . '/' . $price_suv . '</td>';
	}

	public function product_price($item, $model) {
		return '<td><div class="field-100">' . $this->Form->text($model . '.' . $item['id'] . '.price', array('value' => $item['price'], 'class' => 'input-text')) . '</div></td>';
	}
	public function product_stock_count($item, $model) {
		return '<td><div class="field-100">' . $this->Form->text($model . '.' . $item['id'] . '.stock_count', array('value' => $item['stock_count'], 'class' => 'input-text')) . '</div></td>';
	}
	public function disk_size($item, $model) {
		return '<td>' . $item['size1'] . '&nbsp;' . $item['size2'] . '</td>';
	}
	public function akb_size($item, $model) {
		return '<td>' . $item['width'] . 'x' . $item['length'] . 'x' . $item['height'] . '</td>';
	}
	public function car_brand_photo($item, $model) {
		if (!empty($item['filename'])) {
			$src = 'car_brands/' . $item['filename'];
		}
		else {
			$src = 'no-160x20.gif';
		}
		return '<td class="a-center">' . $this->Html->link($this->Html->image($src), array('controller' => 'car_brands', 'action' => 'admin_edit', $item['id']), array('escape' => false)) . '</td>';
	}
	public function used_tyre_photo($item, $model) {
		if (!empty($item['photo_filename'])) {
			$src = $this->Backend->thumbnail(array('id' => $item['photo_id'], 'filename' => $item['photo_filename'], 'path' => 'tyres', 'width' => 160, 'height' => 160, 'crop' => false, 'folder' => true));
		}
		else {
			$src = 'no-160x20.gif';
		}
		return '<td class="a-center">' . $this->Html->link($this->Html->image($src), array('controller' => 'used_tyres', 'action' => 'admin_edit', $item['id']), array('escape' => false)) . '</td>';
	}
	public function used_tyre_price($item, $model) {
		return '<td><div class="field-100">' . $this->Form->text($model . '.' . $item['id'] . '.price', array('value' => $item['price'], 'class' => 'input-text')) . '</div></td>';
	}
	public function used_tyre_count($item, $model) {
		return '<td><div class="field-100">' . $this->Form->text($model . '.' . $item['id'] . '.count', array('value' => $item['count'], 'class' => 'input-text')) . '</div></td>';
	}
	public function used_tyre_brand($item, $model) {
		$brands = $this->_View->getVar('brands');
		if (!empty($item['brand_id'])) {
			$brand = $brands[$item['brand_id']];
		}
		else {
			$brand = $item['brand'];
		}
		return '<td>' . $brand . '</td>';
	}
	public function used_tyre_model($item, $model) {
		$models = $this->_View->getVar('all_models');
		if (!empty($item['model_id'])) {
			$model = $models[$item['model_id']];
		}
		else {
			$model = $item['model'];
		}
		return '<td>' . $model . '</td>';
	}
	public function order_info($item, $model) {
		$info = array();
		$info[] = trim($item['name']);
		if (!empty($item['phone'])) {
			$info[] = h($item['phone']);
		}
		if (!empty($item['email'])) {
			$info[] = h($item['email']);
		}
		return '<td>' . implode('<br />', $info) . '</td>';
	}
	public function order_id($item, $model) {
		return '<td>' . $this->Html->link($item['id'], array('controller' => 'orders', 'action' => 'admin_view', $item['id'])) . '</td>';
	}
	public function sort_order($item, $model) {
		return '<td><div class="field-100">' . $this->Form->text($model . '.' . $item['id'] . '.sort_order', array('value' => $item['sort_order'], 'class' => 'input-text')) . '</div></td>';
	}
	public function order_total($item, $model) {
		$replaces = array(
			array(
				'{after}', '{before}', '{between}', '{value}'
			),
			array(
				'', '', '&nbsp;'
			)
		);
		$replaces[1][] = $item['total'];
		$total = str_replace($replaces[0], $replaces[1], $item['currency_template']);
		return '<td class="a-right">' . $total . '</td>';
	}
}