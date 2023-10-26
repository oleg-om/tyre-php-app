<div id="header">
	<div class="left_box">
		<div class="logo"><?php echo $this->Html->link($this->Html->image('admin/logo.png', array('alt' => __d('admin_common', 'project_name'))), array('controller' => 'dashboard', 'action' => 'admin_index', 'admin' => true), array('escape' => false)); ?></div>
		<div class="box3 b3-top">
			<div class="b3-box">
				<?php echo $this->Html->link($this->Html->image('admin/ico/user.png', array('alt' => __d('admin_common', 'button_profile'), 'class' => 'left_img')), array('controller' => 'administrators', 'action' => 'profile', 'admin' => true), array('title' => __d('admin_common', 'button_profile'), 'escape' => false)); ?> <strong><?php echo __d('admin_administrators', 'administrator_name'); ?></strong> <?php echo AuthComponent::user('name'); ?> <?php echo $this->Html->link($this->Html->image('admin/ico/logout.png', array('alt' => '&rarr;', 'class' => 'right_img ri-left', 'alt' => __d('admin_administrators', 'button_logout'))), array('controller' => 'administrators', 'action' => 'admin_logout', 'admin' => true), array('escape' => false, 'title' => __d('admin_administrators', 'button_logout'))); ?>
			</div>
		</div>
	</div>
	<div class="right_box">
		<div class="box3 b3-rtop">
			<img class="left_img" src="/img/admin/ico/sites.png" alt="" /> <?php echo __d('admin_common', 'project_name'); ?> <?php echo $this->Html->link($this->Html->image('admin/ico/eye.png', array('alt' => __d('admin_common', 'button_preview'), 'class' => 'right_img')), array('controller' => 'pages', 'action' => 'home', 'admin' => false), array('title' => __d('admin_common', 'button_preview'), 'target' => '_blank', 'class' => 'no-loader', 'escape' => false)); ?>
		</div>
	</div>
</div>