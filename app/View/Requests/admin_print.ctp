<?php
$this->Backend->setOptions(array(
	'model' => 'Request',
	'controller' => 'requests'
));
echo $this->Backend->getFormHeader();
echo $this->Session->flash('error');
echo $this->Session->flash('info');
echo $this->Form->create('Request', array('url' => array('controller' => 'requests', 'action' => 'admin_print'), 'id' => 'frm', 'target' => '_blank'));
echo '<label for="RequestDate">Дата</label><div class="clear"></div><div class="item_div third" style="width:115px">';
echo $this->Form->input('date', array('div' => 'date-100', 'label' => false, 'class' => 'input-text', 'type' => 'text', 'requred' => true));
echo '</div><div class="clear"></div>';
echo $this->Form->input('station_id', array('div' => 'item_div wide half', 'label' => 'СТО', 'class' => 'w100', 'type' => 'select', 'options' => $stations, 'empty' => false));
echo '<div class="clear"></div>';
echo $this->Html->div('control-elements', $this->Form->button('Распечатать заявки', array('type' => 'submit', 'class' => 'save-btn')));
echo $this->Form->end();
?>
<script type="text/javascript">
$(function(){
	$('#RequestDate').datepicker({buttonImage:'/img/admin/ico/calendar.png',buttonImageOnly:true,showOn:'both'});
});
</script>