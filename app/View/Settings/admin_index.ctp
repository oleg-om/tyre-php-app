<?php
$this->Backend->setOptions(array(
	'model' => 'Setting',
	'controller' => 'settings',
	'show_breadcrumbs' => false,
	'show_submenu' => false
));
echo $this->Backend->getFormHeader();
foreach ($data as $i => $item) {
	$label = $item['Setting']['description'];
	if ($item['Setting']['type'] == 'text') {
		$this->Backend->addText(
			$i . '.value',
			array(
				'label' => $label,
				'value' => $item['Setting']['value']
			)
		);
		$this->Backend->addHidden($i . '.id', array('value' => $item['Setting']['id']));
	}
	if ($item['Setting']['type'] == 'textarea') {
		$this->Backend->addTextarea(
			$i . '.value',
			array(
				'label' => $label,
				'value' => $item['Setting']['value']
			)
		);
		$this->Backend->addHidden($i . '.id', array('value' => $item['Setting']['id']));
	}
	elseif ($item['Setting']['type'] == 'checkbox') {
		$this->Backend->addCheckbox(
			$i . '.value',
			array(
				'label' => $label,
				'checked' => $item['Setting']['value'] == '1' ? true : false
			)
		);
		$this->Backend->addHidden($i . '.id', array('value' => $item['Setting']['id']));
	}
	elseif ($item['Setting']['type'] == 'radio'){
		
		if($item['Setting']['value']==0):
			$AddSelect[$item['Setting']['variable']][$item['Setting']['id']]=$item['Setting']['description'];
		elseif($item['Setting']['value']==1):
			$AddSelectOn[$item['Setting']['variable']]=array('id'=>$item['Setting']['id'],'desc'=>$item['Setting']['description']);
		endif;
	}
	
	
}

if(!empty($AddSelect)):

	foreach($AddSelect as $key => $val):
	if(!empty($Label[$key])):
		$this->Backend->addSelect($key,array('label' => $Label[$key],
		'options' => $val,
		'empty'=>array($AddSelectOn[$key]['id']=>$AddSelectOn[$key]['desc'])
		));
		endif;
		//$this->Backend->addHidden($i . '.id', array('value' => $item['Setting']['id']));
		//$this->Backend->addHidden('90.id', array('value' => 90));
	endforeach;
	
endif;



$this->Backend->removeFormButton('save_and_exit');
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();