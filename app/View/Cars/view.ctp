<!--<h1 class="titlePage">Подбор для автомобиля <span class="title-cars">--><?php //echo h($brand['CarBrand']['title']); ?><!-- --><?php //echo h($model['CarModel']['title']); ?><!-- --><?php //echo h($year); ?><!-- --><?php //echo h($modification['CarModification']['title']); ?><!--</span></h1>-->
<!--<div class="tyresBox">-->
<!--	<h2 class="tyres">ШИНы</h2>-->
<!--	--><?php //if (!empty($car['Car']['factory_tyres'])) { ?>
<!--	<ul>-->
<!--		<li>Заводская комплектация-->
<!--			<ul>-->
<!--				--><?php
//				$tyres = explode('|', $car['Car']['factory_tyres']);
//				foreach ($tyres as $tyre) {
//					$filter = $this->Frontend->getTyreParams($tyre); ?>
<!--				<li>Шины --><?php //echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $filter), array('escape' => false));?><!--</li>-->
<!--				--><?php //} ?>
<!--			</ul>-->
<!--		</li>-->
<!--	</ul>-->
<!--	--><?php //} ?>
<!--	--><?php //if (!empty($car['Car']['replace_tyres'])) { ?>
<!--	<ul>-->
<!--		<li>Варианты замены-->
<!--			<ul>-->
<!--				--><?php
//				$tyres = explode('|', $car['Car']['replace_tyres']);
//				foreach ($tyres as $tyre) {
//					$filter = $this->Frontend->getTyreParams($tyre);?>
<!--				<li>Шины --><?php //echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $filter), array('escape' => false));?><!--</li>-->
<!--				--><?php //} ?>
<!--			</ul>-->
<!--		</li>-->
<!--	</ul>-->
<!--	--><?php //} ?>
<!--	--><?php //if (!empty($car['Car']['tuning_tyres'])) { ?>
<!--	<ul>-->
<!--		<li>Тюнинг-->
<!--			<ul>-->
<!--				--><?php
//				$tyres = explode('|', $car['Car']['tuning_tyres']);
//				foreach ($tyres as $tyre) {
//					if (substr_count($tyre, '#') > 0) {
//						list($tyre_front, $tyre_back) = explode('#', $tyre);
//						$filter_front = $this->Frontend->getTyreParams($tyre_front);
//						$filter_back = $this->Frontend->getTyreParams($tyre_back);?>
<!--						<li>передняя ось --><?php //echo $this->Html->link($tyre_front, array('controller' => 'tyres', 'action' => 'index', '?' => $filter_front), array('escape' => false));?><!-- задняя ось --><?php //$this->Html->link($tyre_back, array('controller' => 'tyres', 'action' => 'index', '?' => $filter_back), array('escape' => false)); ?><!--</li>-->
<!--					--><?php //} else { $filter = $this->Frontend->getTyreParams($tyre); ?>
<!--						<li>--><?php //$this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $filter), array('escape' => false)); ?><!--</li>-->
<!--					--><?php //} ?>
<!--				--><?php //} ?>
<!---->
<!--			</ul>-->
<!--		</li>-->
<!--	</ul>-->
<!--	--><?php //} ?>
<!--</div>-->
<!--<div class="tyresBox">-->
<!--	<h2 class="disks">ДИСКИ</h2>-->
<!--	<div class="paramDisks">-->
<!--		<strong>Параметры дисков</strong>-->
<!--		--><?php //$pcd = str_replace('*', 'x', $car['Car']['pcd']); ?>
<!--		--><?php //if (!empty($car['Car']['pcd'])) { ?>
<!--		<table cellpadding="0" cellspacing="0">-->
<!--			<col width="50" />-->
<!--			<tr>-->
<!--				<th>PCD:</th>-->
<!--				<td>--><?php //echo $car['Car']['pcd']; ?><!--</td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<th>DIA:</th>-->
<!--				<td>--><?php //echo $car['Car']['diameter']; ?><!--</td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<th></th>-->
<!--				<td>--><?php //echo $car['Car']['nut']; ?><!--</td>-->
<!--			</tr>-->
<!--		</table>-->
<!--		--><?php //} ?>
<!--	</div>-->
<!--	<ul>-->
<!--		--><?php //if (!empty($car['Car']['factory_disks'])) { ?>
<!--		<li>Заводская комплектация-->
<!--			<ul>-->
<!--				--><?php
//				$disks = explode('|', $car['Car']['factory_disks']);
//				foreach ($disks as $disk) {
//					if (substr_count($disk, '#') > 0) {
//						list($disk_front, $disk_back) = explode('#', $disk);
//						$filter_front = $this->Frontend->getDiskParams($disk_front);
//						$filter_back = $this->Frontend->getDiskParams($disk_back);
//						$filter_front['size2'] = str_replace(',', '.', $pcd);
//						$filter_back['size2'] = str_replace(',', '.', $pcd);
//						?>
<!--						<li>передняя ось --><?php //echo $this->Html->link($disk_front, array('controller' => 'disks', 'action' => 'index', '?' => $filter_front), array('escape' => false)); ?><!-- задняя ось --><?php //$this->Html->link($disk_back, array('controller' => 'disks', 'action' => 'index', '?' => $filter_back), array('escape' => false));?><!--</li>-->
<!--					--><?php //} else {
//						$filter = $this->Frontend->getDiskParams($disk);
//						$filter['size2'] = str_replace(',', '.', $pcd); ?>
<!--						<li>Диски --><?php //echo $this->Html->link($disk, array('controller' => 'disks', 'action' => 'index', '?' => $filter), array('escape' => false)); ?><!--</li>-->
<!--					--><?php //} ?>
<!--				--><?php //} ?>
<!--			</ul>-->
<!--		</li>-->
<!--		--><?php //} ?>
<!--	</ul>-->
<!--	--><?php //if (!empty($car['Car']['replace_disks'])) { ?>
<!--	<ul>-->
<!--		<li>Варианты замены-->
<!--			<ul>-->
<!--				--><?php
//				$disks = explode('|', $car['Car']['replace_disks']);
//				foreach ($disks as $disk) {
//					if (substr_count($disk, '#') > 0) {
//						list($disk_front, $disk_back) = explode('#', $disk);
//						$filter_front = $this->Frontend->getDiskParams($disk_front);
//						$filter_back = $this->Frontend->getDiskParams($disk_back);
//						$filter_front['size2'] = str_replace(',', '.', $pcd);
//						$filter_back['size2'] = str_replace(',', '.', $pcd);?>
<!--						<li>передняя ось --><?php //echo $this->Html->link($disk_front, array('controller' => 'disks', 'action' => 'index', '?' => $filter_front), array('escape' => false)); ?><!-- задняя ось --><?php //$this->Html->link($disk_back, array('controller' => 'disks', 'action' => 'index', '?' => $filter_back), array('escape' => false));?><!--</li>-->
<!--					--><?php //} else {
//						$filter = $this->Frontend->getDiskParams($disk);
//						$filter['size2'] = str_replace(',', '.', $pcd); ?>
<!--						<li>Диски --><?php //echo $this->Html->link($disk, array('controller' => 'disks', 'action' => 'index', '?' => $filter), array('escape' => false)); ?><!--</li>-->
<!--					--><?php //} ?>
<!--				--><?php //} ?>
<!--			</ul>-->
<!--		</li>-->
<!--	</ul>-->
<!--	--><?php //} ?>
<!--	--><?php //if (!empty($car['Car']['tuning_disks'])) { ?>
<!--	<ul>-->
<!--		<li>Тюнинг-->
<!--			<ul>-->
<!--				--><?php
//				$disks = explode('|', $car['Car']['tuning_disks']);
//					foreach ($disks as $disk) {
//						if (substr_count($disk, '#') > 0) {
//							list($disk_front, $disk_back) = explode('#', $disk);
//							$filter_front = $this->Frontend->getDiskParams($disk_front);
//							$filter_back = $this->Frontend->getDiskParams($disk_back);
//							$filter_front['size2'] = str_replace(',', '.', $pcd);
//							$filter_back['size2'] = str_replace(',', '.', $pcd);?>
<!--						<li>передняя ось --><?php //echo $this->Html->link($disk_front, array('controller' => 'disks', 'action' => 'index', '?' => $filter_front), array('escape' => false)); ?><!-- задняя ось --><?php //echo $this->Html->link('<span class="podbor">' . $disk_back . '</span>', array('controller' => 'disks', 'action' => 'index', '?' => $filter_back), array('escape' => false));?><!--</li>-->
<!--					--><?php //} else {
//						$filter = $this->Frontend->getDiskParams($disk);
//						$filter['size2'] = str_replace(',', '.', $pcd); ?>
<!--						<li>Диски --><?php //echo $this->Html->link($disk, array('controller' => 'disks', 'action' => 'index', '?' => $filter), array('escape' => false)); ?><!--</li>-->
<!--					--><?php //} ?>
<!--				--><?php //} ?>
<!--			</ul>-->
<!--		</li>-->
<!--	</ul>-->
<!--	--><?php //} ?>
<!--</div>-->
<!--<div class="tyresBox akbBox">-->
<!--	<h2 class="akb">АКБ</h2>-->
<!--	--><?php //if (!empty($car['Car']['width'])) { ?>
<!--		<div class="paramDisks">-->
<!--			<strong>Параметры аккумулятора</strong>-->
<!--			--><?php //$pcd = str_replace('*', 'x', $car['Car']['pcd']); ?>
<!--			--><?php //if (!empty($car['Car']['pcd'])) { ?>
<!--			<table cellpadding="0" cellspacing="0">-->
<!--				<col width="50" />-->
<!--				<tr>-->
<!--					<th>Размер:</th>-->
<!--					<td>--><?php //echo $car['Car']['length']; ?><!--x--><?php //echo $car['Car']['width']; ?><!--x--><?php //echo $car['Car']['height']; ?><!--</td>-->
<!--				</tr>-->
<!--				<tr>-->
<!--					<th>Емкость:</th>-->
<!--					<td>от --><?php //echo $car['Car']['ah_from']; ?><!-- Ач до --><?php //echo $car['Car']['ah_to']; ?><!-- Ач</td>-->
<!--				</tr>-->
<!--				<tr>-->
<!--					<th>Пусковой ток:</th>-->
<!--					<td>до --><?php //echo $car['Car']['current']; ?><!-- А</td>-->
<!--				</tr>-->
<!--				<tr>-->
<!--					<th>Полярность:</th>-->
<!--					<td>--><?php //echo $car['Car']['f1']; ?><!--</td>-->
<!--				</tr>-->
<!--				<tr>-->
<!--					<th>Тип клемм:</th>-->
<!--					<td>--><?php //echo $car['Car']['f2']; ?><!--</td>-->
<!--				</tr>-->
<!--			</table>-->
<!--			--><?php //} ?>
<!--		</div>-->
<!--		--><?php //if (!empty($akb)) { ?>
<!--		<ul>-->
<!--			<li>Варианты замены-->
<!--				<ul>--><?php
//					foreach ($akb as $item) {
//						echo '<li>' . $this->Html->link('<span class="podbor">' . $item['Brand']['title'] . ' ' . $item['BrandModel']['title'] . ' ' . $item['Product']['ah'] . ' Ач ' . $item['Product']['current'] . ' А</span>', array('controller' => 'akb', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)) . '</li>';
//					}
//				?><!--</ul>-->
<!--			</li>-->
<!--		</ul>-->
<!--		--><?php //} ?>
<!--	--><?php //} else { ?>
<!--		<p>параметры аккумулятора для этой модификации не известны</p>-->
<!--	--><?php //} ?>
<!--</div>-->

<div>
    tst
</div>