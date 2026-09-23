<?php
/**
 * Блок «Последние импорты/конвертации» фоновой обработки прайсов.
 * Раскрыт сразу после отправки файла ($jobs_open), иначе свёрнут.
 * Пока есть активные задачи, перезагружает себя с /admin/import/jobs/<kind>.
 *
 * @var array $jobs
 * @var string $jobs_kind
 * @var bool $jobs_open
 */
if (empty($jobs)) {
	return;
}
$format_duration = function ($from, $to = null) {
	$seconds = max(0, ($to ? strtotime($to) : time()) - strtotime($from));
	return $seconds < 60 ? $seconds . ' сек' : floor($seconds / 60) . ' мин ' . ($seconds % 60) . ' сек';
};
// Плитка с числом из отчёта; $tone — good/bad/warn/neutral
$stat_tile = function ($value, $label, $tone) {
	return '<div class="ij-stat ij-stat-' . $tone . '"><b>' . h($value) . '</b><span>' . h($label) . '</span></div>';
};
$import_tones = array(
	'Обновлено товаров' => 'good',
	'Создано товаров' => 'good',
	'Создано моделей' => 'good',
	'Пропущено строк' => 'warn',
	'Не создано товаров из-за ошибок' => 'bad',
	'Не обновлено товаров из-за ошибок' => 'bad'
);
$statuses = array(
	'queued' => 'В очереди',
	'running' => 'Выполняется',
	'done' => 'Готово',
	'failed' => 'Ошибка'
);
$active_count = 0;
foreach ($jobs as $job) {
	if (in_array($job['status'], array('queued', 'running'))) {
		$active_count++;
	}
}
$title = $jobs_kind == 'import' ? 'Последние импорты' : 'Последние конвертации';
?>
<div id="import-jobs" class="ij" data-url="<?php echo $this->Html->url(array('controller' => 'import', 'action' => 'jobs', 'admin' => true, $jobs_kind)); ?>">
<style type="text/css">
	.ij { margin: 0 0 20px; font-size: 13px; }
	.ij-wrap { border: 1px solid #dde1e6; border-radius: 6px; background: #fff; }
	.ij-summary { cursor: pointer; padding: 10px 14px; font-weight: bold; font-size: 14px; color: #2b2f33; outline: none; }
	.ij-summary .ij-pill { margin-left: 8px; }
	.ij-list { padding: 0 14px 4px; }
	.ij-card { border: 1px solid #e6e9ed; border-left: 4px solid #aab2bb; border-radius: 4px; padding: 10px 12px; margin: 0 0 10px; background: #fafbfc; }
	.ij-card-queued { border-left-color: #aab2bb; }
	.ij-card-running { border-left-color: #2f7fd1; background: #f5f9fe; }
	.ij-card-done { border-left-color: #2e9d57; }
	.ij-card-failed { border-left-color: #d64545; background: #fdf6f6; }
	.ij-head { line-height: 22px; }
	.ij-pill { display: inline-block; padding: 0 8px; border-radius: 10px; font-size: 11px; font-weight: bold; line-height: 18px; color: #fff; background: #8a939c; vertical-align: middle; }
	.ij-pill-running { background: #2f7fd1; }
	.ij-pill-done { background: #2e9d57; }
	.ij-pill-failed { background: #d64545; }
	.ij-file { font-weight: bold; margin: 0 6px; color: #2b2f33; }
	.ij-meta { color: #7a828a; font-size: 12px; }
	.ij-note { color: #555c63; margin-top: 6px; }
	.ij-error { display: block; color: #b53030; margin-top: 4px; }
	summary.ij-head { cursor: pointer; outline: none; }
	summary.ij-head::-webkit-details-marker { color: #9aa3ab; }
	details.ij-card[open] > summary.ij-head { margin-bottom: 2px; }
	.ij-progress { height: 6px; border-radius: 3px; background: #dbe7f5; overflow: hidden; margin-top: 8px; position: relative; }
	.ij-progress span { position: absolute; top: 0; bottom: 0; width: 35%; border-radius: 3px; background: #2f7fd1; animation: ij-slide 1.4s ease-in-out infinite; }
	@keyframes ij-slide { 0% { left: -35%; } 100% { left: 100%; } }
	.ij-stats { margin-top: 8px; overflow: hidden; }
	.ij-stat { float: left; min-width: 96px; margin: 0 8px 8px 0; padding: 6px 10px; border-radius: 4px; background: #eef1f4; }
	.ij-stat b { display: block; font-size: 17px; line-height: 20px; color: #2b2f33; }
	.ij-stat span { display: block; font-size: 11px; line-height: 14px; color: #6b737b; }
	.ij-stat-good { background: #e6f4ea; } .ij-stat-good b { color: #23794a; }
	.ij-stat-warn { background: #fdf3e1; } .ij-stat-warn b { color: #a86a00; }
	.ij-stat-bad { background: #fbe6e6; } .ij-stat-bad b { color: #b53030; }
	.ij-download { display: inline-block; margin-top: 8px; padding: 5px 14px; border-radius: 4px; background: #2e9d57; color: #fff !important; font-weight: bold; text-decoration: none; }
	.ij-more { margin-top: 2px; }
	.ij-more summary { cursor: pointer; color: #2f7fd1; font-size: 12px; outline: none; }
	.ij-more-body { margin-top: 6px; padding: 8px 10px; background: #fff; border: 1px solid #e6e9ed; border-radius: 4px; max-height: 240px; overflow: auto; color: #444; }
</style>
<details class="ij-wrap"<?php echo !empty($jobs_open) ? ' open' : ''; ?>>
	<summary class="ij-summary">
		<?php echo h($title); ?>
		<?php if ($active_count): ?>
			<span class="ij-pill ij-pill-running">в работе: <?php echo $active_count; ?></span>
		<?php endif; ?>
	</summary>
	<div class="ij-list">
	<?php foreach ($jobs as $n => $job): ?>
		<?php
		$status = $job['status'];
		$result = (array)$job['result'];
		$meta = array('#' . (int)$job['id'], date('d.m.Y H:i', strtotime($job['created'])));
		if ($status == 'done' || $status == 'failed') {
			if (!empty($job['started']) && !empty($job['finished'])) {
				$meta[] = 'за ' . $format_duration($job['started'], $job['finished']);
			}
		}

		// Самая свежая задача сразу после отправки файла показывается раскрытой, вместе с «Подробнее»
		$fresh = !empty($jobs_open) && $n == 0;

		// Отчёт завершённой задачи собираем заранее: карточка с ним сворачивается до одной строки
		$body = '';
		if ($status == 'done' || $status == 'failed') {
			$tiles = array();
			$notes = array();

			// Отчёт импорта: строки вида «<strong>Название:</strong> число»
			if (!empty($result['message_lines'])) {
				foreach ($result['message_lines'] as $line) {
					if (preg_match('~^<strong>(.+?):</strong>\s*(\d+)$~u', trim($line), $m)) {
						$tone = isset($import_tones[$m[1]]) ? $import_tones[$m[1]] : 'neutral';
						// Нулевые счётчики только шумят, кроме общего числа строк
						if ($m[2] == 0 && $m[1] != 'Обработано строк файла') {
							continue;
						}
						$tiles[] = $stat_tile($m[2], $m[1], $m[2] > 0 ? $tone : 'neutral');
					} elseif (strpos($line, '<strong>Файл:</strong>') !== 0) {
						$notes[] = $line;
					}
				}
			}

			// Отчёт конвертации
			if (!empty($result['stat'])) {
				$stat = $result['stat'];
				$tiles[] = $stat_tile($stat['total_rows_count'], 'Обработано строк', 'neutral');
				$tiles[] = $stat_tile($stat['total_converted_rows'], 'Сконвертировано', $stat['total_converted_rows'] > 0 ? 'good' : 'neutral');
				if ($stat['total_skipped_rows'] > 0) {
					$tiles[] = $stat_tile($stat['total_skipped_rows'], 'Пропущено: мало данных', 'warn');
				}
				if ($stat['total_error_rows'] > 0) {
					$tiles[] = $stat_tile($stat['total_error_rows'], 'Не распознано', 'bad');
				}
				$processed = $stat['total_rows_count'] - $stat['total_skipped_rows'];
				if ($processed > 0) {
					$tiles[] = $stat_tile(number_format($stat['total_converted_rows'] / $processed * 100, 1, '.', '') . '%', 'Процент', 'neutral');
				}
			}

			if (!empty($result['filename'])) {
				$body .= '<a href="/xls/' . h($result['filename']) . '" target="_blank" class="ij-download no-loader">Скачать файл</a>';
			}
			if (!empty($tiles)) {
				$body .= '<div class="ij-stats">' . implode('', $tiles) . '</div>';
			}
			if (!empty($notes)) {
				$body .= '<details class="ij-more"' . ($fresh ? ' open' : '') . '><summary>Подробнее</summary><div class="ij-more-body">' . implode('<br />', $notes) . '</div></details>';
			}
			if (!empty($result['errors'])) {
				$body .= '<details class="ij-more"><summary>Ошибки в строках (' . count($result['errors']) . ')</summary><div class="ij-more-body">' . implode('<br />', $result['errors']) . '</div></details>';
			}
		}
		$collapsible = $body !== '';
		$card_open = $collapsible && $fresh;
		$card_tag = $collapsible ? 'details' : 'div';
		$head_tag = $collapsible ? 'summary' : 'div';
		?>
		<<?php echo $card_tag; ?> class="ij-card ij-card-<?php echo h($status); ?>"<?php echo $card_open ? ' open' : ''; ?>>
			<<?php echo $head_tag; ?> class="ij-head">
				<span class="ij-pill ij-pill-<?php echo h($status); ?>"><?php echo isset($statuses[$status]) ? $statuses[$status] : h($status); ?></span>
				<span class="ij-file"><?php echo h($job['file_name']); ?></span>
				<span class="ij-meta"><?php echo h(implode(' · ', $meta)); ?></span>
				<?php if (!empty($job['error'])): ?>
					<span class="ij-error"><?php echo h($job['error']); ?></span>
				<?php endif; ?>
			</<?php echo $head_tag; ?>>

			<?php if ($status == 'queued'): ?>
				<div class="ij-note">
					<?php echo !empty($job['ahead']) ? 'Ожидает очереди, задач перед ней: ' . (int)$job['ahead'] : 'Начнётся в ближайшие секунды'; ?>
				</div>
			<?php elseif ($status == 'running'): ?>
				<div class="ij-progress"><span></span></div>
				<div class="ij-note">
					Идёт <?php echo $format_duration($job['started']); ?>, обработано строк: <strong><?php echo (int)$job['rows_done']; ?></strong>
				</div>
			<?php endif; ?>

			<?php echo $body; ?>
		</<?php echo $card_tag; ?>>
	<?php endforeach; ?>
	</div>
</details>
<?php if ($active_count): ?>
	<script type="text/javascript">
	setTimeout(function () {
		var $block = $('#import-jobs');
		// Сохраняем раскрытость блока между обновлениями
		var wrap = $block.find('.ij-wrap')[0];
		var url = $block.data('url') + (wrap && wrap.open ? '?open=1' : '');
		$.get(url, function (html) {
			$block.replaceWith(html);
		});
	}, 4000);
	</script>
<?php else: ?>
	<script type="text/javascript">
	// Всё обработано — плашка «файл поставлен в очередь» больше не нужна.
	// Плашка выводится ниже блока, поэтому ждём готовности страницы
	$(function () {
		$('.import-queued-message').fadeOut(300);
	});
	</script>
<?php endif; ?>
</div>
