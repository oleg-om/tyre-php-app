<?php
$this->Backend->setOptions(array(
	'model' => 'Request',
	'controller' => 'requests'
));
echo $this->Backend->getFormHeader();
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_id') . '</strong> &mdash; ' . $request['Request']['id'] . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_station') . '</strong> &mdash; ' . h($request['Station']['title']) . '</div>');
$time = strtotime($request['Request']['date']);
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_date') . '</strong> &mdash; ' . date('d.m.Y', $time) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_time') . '</strong> &mdash; ' . substr($request['Request']['time'], 0, 5) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_name') . '</strong> &mdash; ' . h($request['Request']['name']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_phone') . '</strong> &mdash; ' . h($request['Request']['phone']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_email') . '</strong> &mdash; ' . h($request['Request']['email']) . '</div>');
$auto = array();
if (!empty($request['CarBrand']['title'])) {
	$auto[] = $request['CarBrand']['title'];
}
if (!empty($request['CarModel']['title'])) {
	$auto[] = $request['CarModel']['title'];
}
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_auto') . '</strong> &mdash; ' . h(implode(' ', $auto)) . ' (' . $types[$request['Request']['type']] . ')' . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_number') . '</strong> &mdash; ' . h($request['Request']['number']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_radius') . '</strong> &mdash; R' . h($request['Request']['radius']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_requests', 'label_created') . '</strong> &mdash; ' . $request['Request']['created'] . '</div>');
$this->Backend->removeFormButton('save_and_exit');
$this->Backend->removeFormButton('save');
$this->Backend->setFormButton('back', array(
	'label' => __d('admin_requests', 'button_back'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => 'history.go(-1);'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();