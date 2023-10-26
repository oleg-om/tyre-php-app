<div id="header">
	<div class="left_box">
		<div class="logo"><?php echo $this->Html->link($this->Html->image('admin/logo.png', array('alt' => __d('admin_common', 'project_name'))), array('controller' => 'dashboard', 'action' => 'admin_index', 'admin' => true), array('escape' => false)); ?></div>
	</div>
</div>
<div id="body">
	<div class="left_box login" id="body_left_box">
		<div id="id_message"></div>
		<div id="id_content">
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->Session->flash('error'); ?>
			<h1><?php echo __d('admin_common', 'title'); ?></h1>
			<table cellpadding="0" cellspacing="0" border="0" class="t_authorization">
				<col width="350px" />
				<col />
				<tr>
					<td>
						<div class="box0"><?php
							echo $this->Form->create('Administrator', array('action' => 'login'));
							echo $this->Form->input('username', array('label' => __d('admin_administrators', 'label_login_username'), 'class' => 'large'));
							echo $this->Form->input('password', array('label' => __d('admin_administrators', 'label_login_password'), 'class' => 'large'));
							echo $this->Form->input('ip', array('type' => 'checkbox', 'div' => 'checkbox', 'between' => '&nbsp;', 'label' => __d('admin_administrators', 'label_ip'), 'order' => 'before'));
							echo $this->Form->submit(__d('admin_administrators', 'button_login'), array('class' => 'authorization'));
							echo $this->Form->end();
						?></div>
					</td>
					<td>
						<div class="authorization_message">
							<p><?php echo __d('admin_administrators', 'message_login1'); ?></p>
							<p><?php echo __d('admin_administrators', 'message_login2'); ?></p>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="right_box"></div>
</div>