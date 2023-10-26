<?php
if (!isset($td)) $td = true;
if ($td) {
	echo '<td class="a-center" id="' . $prefix . '_' . $id . '">';
}
echo $this->Html->link($this->Html->image('admin/ico/' . $icon . '-' . ($status ? 'on' : 'off') . '.png', array('alt' => $status ? $title_enabled : $title_disabled)), 'javascript:void(0);', array('title' => $status ? $title_enabled : $title_disabled, 'class' => 'no-loader', 'onclick' => 'ajax_load(\'' . $url . ($status ? $url_disabled : $url_enabled) . '/' . $id . '\', \'' . $prefix . '_' . $id . '\');', 'escape' => false));
if ($td) {
	echo '</td>';
}