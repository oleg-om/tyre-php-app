<?php
$this->Backend->setOptions(array(
	'model' => 'UsedTyre',
	'controller' => 'used_tyres'
));
echo $this->Backend->getFormHeader();
$this->Backend->addTab('main', __d('admin_used_tyres', 'tab_main'));
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_used_tyres', 'label_is_active'),
	'acronym' => __d('admin_used_tyres', 'acronym_is_active')
), 'main');
$this->Backend->addCheckbox('no_price', array(
	'label' => __d('admin_used_tyres', 'label_no_price')
), 'main');
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_used_tyres', 'label_brand_id'),
	'options' => $brands,
	'required' => false,
	'div' => 'item_div half'
), 'main');
$this->Backend->addSelect('model_id', array(
	'label' => __d('admin_used_tyres', 'label_model_id'),
	'options' => $models,
	'required' => false,
	'div' => 'item_div half'
), 'main');
$this->Backend->addHtml('<div class="clear"></div>', 'main');
$this->Backend->addText('brand', array(
	'label' => __d('admin_used_tyres', 'label_brand'),
	'div' => 'item_div half'
), 'main');
$this->Backend->addText('model', array(
	'label' => __d('admin_used_tyres', 'label_model'),
	'div' => 'item_div half'
), 'main');
$this->Backend->addHtml('<div class="clear"></div>', 'main');
$this->Backend->addText('price', array(
	'label' => __d('admin_used_tyres', 'label_price'),
	'required' => true,
	'div' => 'item_div half'
), 'main');
$this->Backend->addText('count', array(
	'label' => __d('admin_used_tyres', 'label_count'),
	'required' => true,
	'div' => 'item_div half'
), 'main');
$this->Backend->addHtml('<div class="clear"></div>', 'main');
$this->Backend->addText('protector_width', array(
	'label' => __d('admin_used_tyres', 'label_protector_width'),
	'div' => 'item_div half'
), 'main');
$this->Backend->addSelect('season', array(
	'label' => __d('admin_used_tyres', 'label_season'),
	'options' => $seasons,
	'empty' => false,
	'div' => 'item_div half'
), 'main');
$this->Backend->addHtml('<div class="clear"></div>', 'main');
$this->Backend->addText('size1', array(
	'label' => __d('admin_used_tyres', 'label_size1'),
	'required' => true,
	'div' => 'item_div third'
), 'main');
$this->Backend->addText('size2', array(
	'label' => __d('admin_used_tyres', 'label_size2'),
	'required' => true,
	'div' => 'item_div third'
), 'main');
$this->Backend->addText('size3', array(
	'label' => __d('admin_used_tyres', 'label_size3'),
	'required' => true,
	'div' => 'item_div third'
), 'main');
$this->Backend->addHtml('<div class="clear"></div>', 'main');
$this->Backend->addTextarea('content', array(
	'label' => __d('admin_used_tyres', 'label_content'),
	'editor' => true
), 'main');
$this->Backend->addTab('photos', __d('admin_used_tyres', 'tab_photos'));
$photos = array();
if (isset($data['UsedTyrePhoto']) && count($data['UsedTyrePhoto']) > 0) {
	$photos = $data['UsedTyrePhoto'];
	unset($data['UsedTyrePhoto']);
}
for ($i = 0; $i < count($photos); $i++) {
	$this->Backend->addHtml('<div class="row">', 'photos');
	$this->Backend->addHtml($this->Html->div(
		'item_div',
		$this->Html->image(
			$this->Backend->thumbnail(
				array(
					'filename' => $photos[$i]['filename'],
					'id' => $photos[$i]['id'],
					'path' => 'tyres',
					'width' => 60,
					'height' => 60,
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
			'id' => 'UsedTyrePhotoFile' . $photos[$i]['id'],
			'name' => 'data[UsedTyrePhoto][file][' . $photos[$i]['id'] . ']',
			'type' => 'file',
			'label' => array(
				'text' => '<acronym title="' . __d('admin_used_tyres', 'label_file') . '">' . __d('admin_used_tyres', 'label_file') . '</acronym>',
				'class' => 'caption'
			),
			'div' => 'item_div col210'
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
	$this->Backend->addHtml('</div>', 'photos');
}
$this->Backend->addHtml('<div id="divSWFUploadUI"><div class="fieldset flash" id="fsUploadProgress"><span class="legend">Очередь загрузки</span></div><p id="divStatus">Файлов загружено: 0</p><p><span id="spanButtonPlaceholder"></span><input id="btnUpload" type="button" value="Выбрать файл(ы)" /><input id="btnCancel" type="button" value="Отменить загрузку" disabled="disabled" style="margin-left: 2px;" /></p></div>', 'photos');

$this->Backend->addHidden('photo_ids');
$this->Backend->addHidden('id');
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
var swfu;
$(function(){
	$('#UsedTyreBrandId').change(handler_brand_id);
	handler_brand_id();
	var settings = {
		post_params: {'data[UsedTyre][id]': <?php echo !empty($this->request->data['UsedTyre']['id']) ? $this->request->data['UsedTyre']['id'] : 0; ?>},
		file_post_name: 'data[UsedTyrePhoto][file]',
		flash_url : '/js/swfupload/swfupload.swf',
		upload_url: '/upload',
		file_size_limit : '<?php echo floor($this->Backend->max_upload_size / 1048576); ?> MB',
		file_types : '*.jpg;*.jpeg;*.gif;*.png;*.bmp',
		file_types_description : 'Файлы изображений',
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : 'fsUploadProgress',
			cancelButtonId : 'btnCancel'
		},
		debug: false,
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 122,
		button_height: 30,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete
	};
	swfu = new SWFUpload(settings);
});
function handler_brand_id() {
	var brand_id = parseInt($('#UsedTyreBrandId').val()), model_id = $('#UsedTyreModelId').val();
	if (isNaN(brand_id)) brand_id = 0;
	$('#UsedTyreModelId').removeOption(/.*/);
	if (brand_id != 0) {
		loader();
		$('#UsedTyreModelId').ajaxAddOption(
			'/admin/brands/models',
			{brand_id: brand_id, any: 1},
			false,
			function() {
				$('#UsedTyreModelId').val(model_id);
				delete_loader();
			}
		);
	}
	else {
		$('#UsedTyreModelId').addOption('','<?php echo __d('admin_common', 'list_any_item'); ?>');
	}
}
</script>