<div class="right_box">
	<div id="main-menu"<?php echo $m_state ? ' style="width:0px;display:none;"' : ''; ?>>
	<?php
		foreach ($menu_sections as $i => $section) {
			echo '<div class="' . $section['class'] . '">' . $this->Html->image('admin/ico/' . $section['icon'] . '.png', array('class' => 'left_img')) . ' ' . $this->Html->link($section['title'], 'javascript:void(0);', array('onclick' => 'submenu(' . $i . ')', 'class' => 'no-loader')) . '</div>';
			$menu_items = $section['menu_items'];
			if (count($menu_items) > 0) {
				echo '<div id="submenu' . $i . '" class="sub_menu"' . ($s_state[$i] ? ' style="display:none;"' : '' ) . '><ul>';
				foreach ($menu_items as $key => $params) {
					echo '<li>' . $this->Html->link($params['title'], $params['link']) . '</li>';
				}
				echo '</ul></div>';
			}
		}
	?>
	</div>
	<div id="main-menu-show-hide"><?php echo $this->Html->link($this->Html->image('admin/menu_show' . ($m_state ? '_reverse' : '') . '.gif', array('alt' => '<>', 'class' => 'right_img', 'id' => 'main-menu-img')), 'javascript:void(0);', array('onclick' => 'menu();', 'class' => 'no-loader' ,'escape' => false)); ?></div>
</div>