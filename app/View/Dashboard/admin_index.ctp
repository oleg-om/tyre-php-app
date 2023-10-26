<?php
echo $this->Session->flash('error');
echo $this->Session->flash('info');
?>
<br />
<table cellpadding="0" cellspacing="5" width="100%" border="0">
	<col width="50%" />
	<col width="50%" />
	<tr>
		<td class="index_table_td">
			<div class="main_div">
				<span class="div_title"><?php echo __d('admin_administrators', 'title_notes'); ?></span>
				<div class="div_content">
					<?php echo $this->Form->create('Administrator', array('url' => array('controller' => 'dashboard', 'action' => 'index'))); ?>
					<table border="0" cellpadding="3" cellspacing="0" width="100%">
						<tr>
							<td><?php echo $this->Form->textarea('notes', array('class' => 'w100', 'rows' => 5)); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->submit(__d('admin_administrators', 'button_save'), array('class' => 'save_notes')); ?></td>
						</tr>
					</table>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</td>
		<td></td>
	</tr>
</table>