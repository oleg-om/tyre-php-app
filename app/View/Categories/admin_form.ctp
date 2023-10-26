<?php
$this->Backend->setOptions(array(
	'model' => 'Category',
	'controller' => 'categories'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_categories', 'label_is_active'),
	'acronym' => __d('admin_categories', 'acronym_is_active')
));
$this->Backend->addText('title', array(
	'label' => __d('admin_categories', 'label_title'),
	'acronym' => __d('admin_categories', 'acronym_title'),
	'required' => true,
	'sluggable' => true
));
$this->Backend->addText('slug', array(
	'label' => __d('admin_categories', 'label_slug'),
	'acronym' => __d('admin_categories', 'acronym_slug'),
	'required' => true
));
if (!empty($this->data['Category']['id'])) {
	$this->Backend->addHtml('<div class="item_div">' . $this->Html->image('/img/animals/' . $this->data['Category']['filename'], array('width' => 79, 'height' => 76)) . '</div>');
}
$this->Backend->addFile('file', array(
	'label' => __d('admin_categories', 'label_file')
));
$this->Backend->addText('meta_title', array(
	'label' => __d('admin_categories', 'label_meta_title')
));
$this->Backend->addText('meta_keywords', array(
	'label' => __d('admin_categories', 'label_meta_keywords')
));
$this->Backend->addTextarea('meta_description', array(
	'label' => __d('admin_categories', 'label_meta_description')
));
for ($j = 1; $j < 4; $j ++) {
	$this->Backend->addTab('group' . $j, __d('admin_categories', 'tab_group' . $j));
	$this->Backend->addText('field_group' . $j, array(
		'label' => __d('admin_categories', 'label_field_group' . $j)
	), 'group' . $j);
	$this->Backend->addHtml('<br /><div class="group-fields-' . $j . '">', 'group' . $j);
	$group_fields = array(
		array(
			'title' => '',
			'sort_order' => 1,
			'group_id' => $j
		)
	);
	if (isset($fields[$j]) && !empty($fields[$j])) {
		$group_fields = $fields[$j];
	}
	for ($i = 0; $i < count($group_fields); $i++) {
		$this->Backend->addHtml('<div class="row clearfix">', 'group' . $j);
		if (isset($group_fields[$i]['id'])) {
			$this->Backend->addHtml($this->Form->input(
				'title',
				array(
					'name' => 'data[ExistField][title][' . $j . '][' . $group_fields[$i]['id'] . ']',
					'type' => 'text',
					'value' => $group_fields[$i]['title'],
					'label' => array(
						'text' => '<acronym title="' . __d('admin_fields', 'label_title') . '">' . __d('admin_fields', 'label_title') . '</acronym>',
						'class' => 'caption'
					),
					'div' => 'item_div col300'
				)
			), 'group' . $j);
			$this->Backend->addHtml($this->Form->input(
				'sort_order',
				array(
					'name' => 'data[ExistField][sort_order][' . $j . '][' . $group_fields[$i]['id'] . ']',
					'type' => 'hidden',
					'value' => $group_fields[$i]['sort_order'],
					'class' => 'sort_order'
				)
			), 'group' . $j);
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
			), 'group' . $j);
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
			), 'group' . $j);
		}
		else {
			$this->Backend->addHtml($this->Form->input(
				'title',
				array(
					'name' => 'data[Field][title][' . $j . '][]',
					'type' => 'text',
					'value' => $group_fields[$i]['title'],
					'label' => array(
						'text' => '<acronym title="' . __d('admin_fields', 'label_title') . '">' . __d('admin_fields', 'label_title') . '</acronym>',
						'class' => 'caption'
					),
					'div' => 'item_div col300'
				)
			), 'group' . $j);
			$this->Backend->addHtml($this->Form->input(
				'sort_order',
				array(
					'name' => 'data[Field][sort_order][' . $j . '][]',
					'type' => 'hidden',
					'value' => $group_fields[$i]['sort_order'],
					'class' => 'sort_order'
				)
			), 'group' . $j);
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
			), 'group' . $j);
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
			), 'group' . $j);
		}
		$this->Backend->addHtml('</div>', 'group' . $j);
	}
	$this->Backend->addHtml($this->Html->div(
		'item_div add-row-box',
		$this->Html->link(
			__d('admin_fields', 'link_add_item'),
			'javascript:add_row(\'.group-fields-' . $j . '\');',
			array(
				'class' => 'no-loader add-row-link'
			)
		)
	), 'group' . $j);
	$this->Backend->addHtml('<div class="row add-row clearfix">', 'group' . $j);
	$this->Backend->addHtml($this->Form->input(
		'title',
		array(
			'name' => 'data[Field][title][' . $j . '][]',
			'type' => 'text',
			'value' => '',
			'label' => array(
				'text' => '<acronym title="' . __d('admin_fields', 'label_title') . '">' . __d('admin_fields', 'label_title') . '</acronym>',
				'class' => 'caption'
			),
			'div' => 'item_div col300'
		)
	), 'group' . $j);
	$this->Backend->addHtml($this->Form->input(
		'sort_order',
		array(
			'name' => 'data[Field][sort_order][' . $j . '][]',
			'type' => 'hidden',
			'value' => 1,
			'class' => 'sort_order'
		)
	), 'group' . $j);
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
	), 'group' . $j);
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
	), 'group' . $j);
	$this->Backend->addHtml('</div>', 'group' . $j);
	$this->Backend->addHtml('</div>', 'group' . $j);
}
$this->Backend->addHidden('id');
$this->Backend->addHidden('filename');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();