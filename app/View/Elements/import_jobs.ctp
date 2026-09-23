<?php
/**
 * Блок «Задачи» фоновой обработки прайсов. Пока есть активные задачи,
 * перезагружает себя с /admin/import/jobs/<kind>.
 *
 * @var array $jobs
 * @var string $jobs_kind
 */
if (empty($jobs)) {
	return;
}
$format_duration = function ($from, $to = null) {
	$seconds = max(0, ($to ? strtotime($to) : time()) - strtotime($from));
	return $seconds < 60 ? $seconds . ' сек' : floor($seconds / 60) . ' мин ' . ($seconds % 60) . ' сек';
};
$has_active = false;
?>
<div id="import-jobs" class="import-jobs" data-url="<?php echo $this->Html->url(array('controller' => 'import', 'action' => 'jobs', 'admin' => true, $jobs_kind)); ?>">
	<h3>Задачи</h3>
	<?php foreach ($jobs as $n => $job): ?>
		<?php
		$active = in_array($job['status'], array('queued', 'running'));
		$has_active = $has_active || $active;
		switch ($job['status']) {
			case 'queued':
				$status = 'В очереди';
				break;
			case 'running':
				$status = 'Выполняется ' . $format_duration($job['started']) . ', обработано строк: ' . $job['rows_done'];
				break;
			case 'done':
				$status = 'Готово за ' . $format_duration($job['started'], $job['finished']);
				break;
			default:
				$status = 'Ошибка';
		}
		$result = (array)$job['result'];
		?>
		<div class="import-job import-job-<?php echo h($job['status']); ?><?php echo $active ? ' import-job-active' : ''; ?>">
			<p>
				<strong>#<?php echo (int)$job['id']; ?></strong>
				<?php echo h($job['file_name']); ?>
				&mdash; <?php echo h(date('d.m.Y H:i', strtotime($job['created']))); ?>
				&mdash; <strong><?php echo h($status); ?></strong>
			</p>
			<?php if (!empty($job['error'])): ?>
				<p class="error-message"><?php echo h($job['error']); ?></p>
			<?php endif; ?>
			<?php if (!$active && !empty($result)): ?>
				<details<?php echo $n == 0 ? ' open' : ''; ?>>
					<summary>Результат</summary>
					<?php
					if (!empty($result['filename'])) {
						echo '<p class="messages"><a href="/xls/' . h($result['filename']) . '" target="_blank" class="no-loader">' . __d('admin_import', 'link_download') . '</a></p>';
					}
					if (!empty($result['message_lines'])) {
						echo '<p class="messages">' . implode('<br />', $result['message_lines']) . '</p>';
					}
					if (!empty($result['stat'])) {
						$stat = $result['stat'];
						$messages = array(
							__d('admin_import', 'stat_message_total_sheets_count', $stat['total_sheets_count']),
							__d('admin_import', 'stat_message_total_rows_count', $stat['total_rows_count']),
							__d('admin_import', 'stat_message_total_converted_rows', $stat['total_converted_rows']),
							__d('admin_import', 'stat_message_total_skipped_rows', $stat['total_skipped_rows']),
							__d('admin_import', 'stat_message_total_error_rows', $stat['total_error_rows'])
						);
						$processed = $stat['total_rows_count'] - $stat['total_skipped_rows'];
						if ($processed > 0) {
							$messages[] = __d('admin_import', 'stat_message_percent', number_format(($stat['total_converted_rows'] / $processed) * 100, 1, '.', ''));
						}
						echo '<ul><li>' . implode('</li><li>', $messages) . '</li></ul>';
					}
					if (!empty($result['errors'])) {
						echo '<details><summary>' . __d('admin_import', 'spoiler_errors') . ' (' . count($result['errors']) . ')</summary><ul><li>' . implode('</li><li>', $result['errors']) . '</li></ul></details>';
					}
					?>
				</details>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	<?php if ($has_active): ?>
		<script type="text/javascript">
		setTimeout(function () {
			var $block = $('#import-jobs');
			$.get($block.data('url'), function (html) {
				$block.replaceWith(html);
			});
		}, 4000);
		</script>
	<?php endif; ?>
</div>
