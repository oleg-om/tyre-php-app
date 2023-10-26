<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'products'
));
echo $this->Backend->getFormHeader();
$this->Backend->addTab('main', __d('admin_products', 'tab_main'));
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_products', 'label_is_active'),
	'acronym' => __d('admin_products', 'acronym_is_active'),
	'disabled' => !$is_deletable
), 'main');
$this->Backend->addText('title', array(
	'label' => __d('admin_products', 'label_title'),
	'acronym' => __d('admin_products', 'acronym_title'),
	'required' => true,
	'sluggable' => true
), 'main');
$this->Backend->addText('slug', array(
	'label' => __d('admin_products', 'label_slug'),
	'acronym' => __d('admin_products', 'acronym_slug'),
	'required' => true,
	'disabled' => !$is_deletable
), 'main');
$this->Backend->addSelect('category_id', array(
	'label' => __d('admin_products', 'label_category_id'),
	'options' => $categories
), 'main');
$this->Backend->addTextarea('content', array(
	'label' => __d('admin_products', 'label_content'),
	'editor' => true
), 'main');
$this->Backend->addText('meta_title', array(
	'label' => __d('admin_products', 'label_meta_title')
), 'main');
$this->Backend->addText('meta_keywords', array(
	'label' => __d('admin_products', 'label_meta_keywords')
), 'main');
$this->Backend->addTextarea('meta_description', array(
	'label' => __d('admin_products', 'label_meta_description')
), 'main');
$this->Backend->addTab('params', __d('admin_products', 'tab_params'));
$this->Backend->addHtml('<div id="params-box">', 'params');
if (!empty($data['Product']['id'])) {
	$this->Backend->addHtml($this->element('admin_fields', array('product_fields' => $data['ProductField'])), 'params');
}
$this->Backend->addHtml('</div>', 'params');
$this->Backend->addTab('photos', __d('admin_products', 'tab_photos'));
$this->Backend->addHtml('<div class="product-photos">', 'photos');
$product_photos[0] = array(
	'filename' => '',
	'sort_order' => 1
);
if (isset($data['ProductPhoto']) && count($data['ProductPhoto']) > 0) {
	$product_photos = $data['ProductPhoto'];
	unset($data['ProductPhoto']);
}
for ($i = 0; $i < count($product_photos); $i++) {
	$this->Backend->addHtml('<div class="row clearfix">', 'photos');
	if (isset($product_photos[$i]['id'])) {
		$this->Backend->addHtml($this->Html->div(
			'item_div',
			$this->Html->image(
				$this->Backend->thumbnail(
					array(
						'filename' => $product_photos[$i]['filename'],
						'id' => $product_photos[$i]['id'],
						'path' => 'food',
						'width' => 119,
						'height' => 152,
						'crop' => true,
						'folder' => true,
						'quality' => 85
					)
				)
			)
		), 'photos');
		$this->Backend->addHtml($this->Form->input(
			'file',
			array(
				'name' => 'data[ExistProductPhoto][file][' . $product_photos[$i]['id'] . ']',
				'type' => 'file',
				'label' => array(
					'text' => '<acronym title="' . __d('admin_products', 'label_file') . '">' . __d('admin_products', 'label_file') . '</acronym>',
					'class' => 'caption'
				),
				'div' => 'item_div col210'
			)
		), 'photos');
		$this->Backend->addHtml($this->Form->input(
			'sort_order',
			array(
				'name' => 'data[ExistProductPhoto][sort_order][' . $product_photos[$i]['id'] . ']',
				'type' => 'hidden',
				'value' => $product_photos[$i]['sort_order'],
				'class' => 'sort_order'
			)
		), 'photos');
		$this->Backend->addHtml($this->Html->div(
			'item_div rm-link',
			$this->Html->link(
				__d('admin_common', 'link_remove_row'),
				'javascript:void(0);',
				array(
					'class' => 'no-loader',
					'onclick' => 'delete_row(this);'
				)
			)
		), 'photos');
		$this->Backend->addHtml($this->Html->div(
			'item_div move-links',
			$this->Html->link(
				$this->Html->image('admin/ico/up-on.png', array('alt' => __d('admin_common', 'button_row_up'))),
				'javascript:void(0);',
				array(
					'class' => 'no-loader',
					'onclick' => 'move_row_up(this);',
					'title' => __d('admin_common', 'button_row_up'),
					'escape' => false
				)
			) . 
			$this->Html->link(
				$this->Html->image('admin/ico/down-on.png', array('alt' => __d('admin_common', 'button_row_down'))),
				'javascript:void(0);',
				array(
					'class' => 'no-loader',
					'onclick' => 'move_row_down(this);',
					'title' => __d('admin_common', 'button_row_down'),
					'escape' => false
				)
			)		
		), 'photos');
	}
	else {
		$this->Backend->addHtml($this->Form->input(
			'file',
			array(
				'name' => 'data[ProductPhoto][file][]',
				'type' => 'file',
				'label' => array('text' => '<acronym title="' . __d('admin_products', 'label_file') . '">' . __d('admin_products', 'label_file') . '</acronym>',
				'class' => 'caption'
			),
			'div' => 'item_div col210')
		), 'photos');
		$this->Backend->addHtml($this->Form->input(
			'sort_order',
			array(
				'name' => 'data[ProductPhoto][sort_order][]',
				'type' => 'hidden',
				'value' => $product_photos[$i]['sort_order'],
				'class' => 'sort_order'
			)
		), 'photos');
		$this->Backend->addHtml($this->Html->div(
			'item_div rm-link',
			$this->Html->link(
				__d('admin_common', 'link_remove_row'),
				'javascript:void(0);',
				array(
					'class' => 'no-loader',
					'onclick' => 'delete_row(this);'
				)
			)
		), 'photos');
		$this->Backend->addHtml($this->Html->div(
			'item_div move-links',
			$this->Html->link(
				$this->Html->image('admin/ico/up-on.png', array('alt' => __d('admin_common', 'button_row_up'))),
				'javascript:void(0);',
				array(
					'class' => 'no-loader',
					'onclick' => 'move_row_up(this);',
					'title' => __d('admin_common', 'button_row_up'),
					'escape' => false
				)
			) . 
			$this->Html->link(
				$this->Html->image('admin/ico/down-on.png', array('alt' => __d('admin_common', 'button_row_down'))),
				'javascript:void(0);',
				array(
					'class' => 'no-loader',
					'onclick' => 'move_row_down(this);',
					'title' => __d('admin_common', 'button_row_down'),
					'escape' => false
				)
			)		
		), 'photos');
	}
	$this->Backend->addHtml('</div>', 'photos');
}
$this->Backend->addHtml($this->Html->div(
	'item_div add-row-box',
	$this->Html->link(
		__d('admin_products', 'link_add_photo'),
		'javascript:add_row(\'.product-photos\');',
		array(
			'class' => 'no-loader add-row-link'
		)
	)
), 'photos');
$this->Backend->addHtml('<div class="row add-row clearfix">', 'photos');
$this->Backend->addHtml($this->Form->input(
	'file',
	array(
		'name' => 'data[ProductPhoto][file][]',
		'type' => 'file',
		'label' => array(
			'text' => '<acronym title="' . __d('admin_products', 'label_file') . '">' . __d('admin_products', 'label_file') . '</acronym>',
			'class' => 'caption'
		),
		'div' => 'item_div col210'
	)
), 'photos');
$this->Backend->addHtml($this->Form->input(
	'sort_order',
	array(
		'name' => 'data[ProductPhoto][sort_order][]',
		'type' => 'hidden',
		'value' => 1,
		'class' => 'sort_order'
	)
), 'photos');
$this->Backend->addHtml($this->Html->div(
	'item_div rm-link',
	$this->Html->link(
		__d('admin_common', 'link_remove_row'),
		'javascript:void(0);',
		array(
			'class' => 'no-loader',
			'onclick' => 'delete_row(this);'
		)
	)
), 'photos');
$this->Backend->addHtml($this->Html->div(
	'item_div move-links',
	$this->Html->link(
		$this->Html->image('admin/ico/up-on.png', array('alt' => __d('admin_common', 'button_row_up'))),
		'javascript:void(0);',
		array(
			'class' => 'no-loader',
			'onclick' => 'move_row_up(this);',
			'title' => __d('admin_common', 'button_row_up'),
			'escape' => false
		)
	) . 
	$this->Html->link(
		$this->Html->image('admin/ico/down-on.png', array('alt' => __d('admin_common', 'button_row_down'))),
		'javascript:void(0);',
		array(
			'class' => 'no-loader',
			'onclick' => 'move_row_down(this);',
			'title' => __d('admin_common', 'button_row_down'),
			'escape' => false
		)
	)		
), 'photos');
$this->Backend->addHtml('</div>', 'photos');
$this->Backend->addHtml('</div>', 'photos');
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_category_id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();
?>
<script type="text/javascript">
<!--
$(function(){
	$('#ProductCategoryId').change(function(){
		var category_id = parseInt($('#ProductCategoryId').val());
		if (isNaN(category_id)) category_id = 0;
		$('#params-box').html('');
		if (category_id > 0) {
			$.ajax({
				url: '/admin/categories/fields/' + category_id,
				success: function (data) {
					$('#params-box').html(data);
				}
			});
		}
	});
});
//-->
</script>