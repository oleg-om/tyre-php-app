<?php
$controller = 'tyres';
switch ($category_id) {
	case 2:
		$controller = 'disks';
		break;
}?>
<script type="text/javascript">
<!--

$(function(){
	$('a.moreBrands').click(function () {
		$(this).hide();
		$(this).siblings('a').show();
		$(this).parent('.boxNav').find('div.hidden').toggle(300);
		return false;
	});
	$('#slider').slider({
		range: true,
		min:<?php echo $price_from; ?>,
		max:<?php echo $price_to; ?>,
		step: 5,
		values: [<?php if (empty ($filter['price_from']) || $filter['price_from'] < $price_from) {echo $price_from;} else {echo $filter['price_from'];} ?>, <?php if (empty ($filter['price_to']) || $filter['price_to'] > $price_to) {echo $price_to;} else {echo $filter['price_to'];} ?>],
		slide: function(event, ui) {
			$('#price_from').val(ui.values[0]);
			$('#price_to').val(ui.values[1]);
		}
	});
});
//-->
</script>
<div id="left">
	<div class="leftNav">
		<div class="titleLeft">
			Параметры подбора
		</div>
		<?php
				$url = array('controller' => $controller, 'action' => 'index');
				echo $this->Form->create('Product', array('type' => 'get', 'url' => $url));
				echo $this->Form->hidden('mode');
				if ($controller == 'tyres') {
					echo $this->Form->hidden('size1');
					echo $this->Form->hidden('size2');
					echo $this->Form->hidden('size3');
					echo $this->Form->hidden('season');
					echo $this->Form->hidden('auto');
				}
				elseif ($controller == 'disks') {
					echo $this->Form->hidden('size1');
					echo $this->Form->hidden('size2');
					echo $this->Form->hidden('et');
					echo $this->Form->hidden('in_stock4');
				}
			?>
		<div class="boxNav">
			<h3>Стоимость</h3>
			от: <input type="text" name="price_from" id="price_from" value="<?php if (empty ($filter['price_from'])) {echo $price_from;} else {echo $filter['price_from'];} ?>"/>
			до: <input type="text" name="price_to" id="price_to" value="<?php if (empty ($filter['price_to'])) {echo $price_to;} else {echo $filter['price_to'];} ?>"/>
			<div class="price-control"><div id="slider"></div></div>
		</div>
		<?php if (false && !empty($auto)) {?>
		<div class="boxNav">
			<h3>Тип автомобиля</h3>
			<div class="checkFilter">
				<?php foreach ($auto as $key => $value) {
				$checked = false;
				if (!empty ($filter['auto'])) {
					if (is_array($filter['auto']) && in_array($key, $filter['auto'])) {
						$checked = true;
					} elseif ($filter['auto'] == $key) {
						$checked = true;
					}

				}
				?>

				<div class="checkBox">
					<input type="checkbox" <?php if($checked) echo 'checked'; ?> name="auto[]" value="<?php echo $key; ?>"/>
					<label>
						<?php
							echo $this->Html->link($value, array('controller' => $controller, 'action' => 'index', '?' => array('auto' => $key)), array('escape' => false));
						?>
					</label>
				</div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
		<?php if (false && !empty($seasons)) {?>
		<div class="boxNav">
			<h3>Сезонность</h3>
			<div class="checkFilter">
				<?php foreach ($seasons as $key => $value) {
				$checked = false;
				if (!empty ($filter['season'])) {
					if (is_array($filter['season']) && in_array($key, $filter['season'])) {
						$checked = true;
					} elseif ($filter['season'] == $key) {
						$checked = true;
					}

				}
				?>

				<div class="checkBox">
					<input type="checkbox" <?php if($checked) echo 'checked'; ?> name="season[]" value="<?php echo $key; ?>"/>
					<label>
						<?php
							echo $this->Html->link($value, array('controller' => $controller, 'action' => 'index', '?' => array('season' => $key)), array('escape' => false));
						?>
					</label>
				</div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
		<?php if ($controller == 'tyres') { ?>
		<div class="boxNav">
			<h3>Дополнительно</h3>
			<div class="checkFilter">
				<div class="checkBox">
					<input type="checkbox" <?php if (!empty ($filter['stud'])) echo 'checked'; ?> name="stud" value="1" />
					<label>
						<?php
							$stud_filter = $filter;
							unset($stud_filter['stud']);
							$stud_filter['stud'] = 1;
							echo $this->Html->link('Шипованная', array('controller' => $controller, 'action' => 'index', '?' => $stud_filter), array('escape' => false));
						?>
					</label>
				</div>
				<?php /*
				<div class="checkBox">
					<input type="checkbox" <?php if (!empty ($filter['in_stock'])) echo 'checked'; ?> name="in_stock" value="1" />
					<label>
						<?php
							$in_stock_filter = $filter;
							unset($in_stock_filter['in_stock']);
							$in_stock_filter['stud'] = 1;
							echo $this->Html->link('В наличии', array('controller' => $controller, 'action' => 'index', '?' => $in_stock_filter), array('escape' => false));
						?>
					</label>
				</div>
				*/ ?>
				<div class="checkBox">
					<input type="checkbox" <?php if (!empty ($filter['in_stock4'])) echo 'checked'; ?> name="in_stock4" value="1" />
					<label>
						<?php
							$in_stock4_filter = $filter;
							unset($in_stock4_filter['in_stock4']);
							$in_stock4_filter['in_stock4'] = 1;
							echo $this->Html->link('Больше 4х', array('controller' => $controller, 'action' => 'index', '?' => $in_stock4_filter), array('escape' => false));
						?>
					</label>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
		<div class="boxNav">
			<h3>Производитель</h3>
			<div class="checkFilter">
			<?php $i=1;
				foreach ($brands as $item) {

				$checked = false;
				if (!empty ($filter['brand_id'])) {
					if (is_array($filter['brand_id']) && in_array($item['Brand']['id'], $filter['brand_id'])) {
						$checked = true;
					} elseif ($filter['brand_id'] == $item['Brand']['id']) {
						$checked = true;
					} 
				} elseif (!empty($brand_id) && $brand_id == $item['Brand']['id']) {
					$checked = true;
				}
					$brand_mode = array();
					if ($controller == 'tyres') {
						$brand_mode = array('mode' => 'block');
					}
					?>

				<div class="checkBox">
					<input type="checkbox" <?php if($checked) echo 'checked'; ?> name="brand_id[]" value="<?php echo $item['Brand']['id'] ?>" />
					<label><?php echo $this->Html->link($item['Brand']['title'], array('controller' => $controller, 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $brand_mode)); ?></label>
				</div>
					<?php 
				if ($i == 10) echo '<div class="hidden">';
				$i++;
				}
				echo '</div>';
			?>
			</div>
			<div class="clear"></div>
			<a class="allLink moreBrands" href="#">показать все бренды</a>
			<a class="allLink moreBrands hidden" href="#">скрыть бренды</a>
		</div>
		<input type="submit" value="Фильтровать" class="btFilterLeft">
		</form>
		<div class="filter-default">
			<?php echo $this->Html->link('сбросить фильтры', array('controller' => $controller, 'action' => 'index')); ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php echo $this->element('last_models'); ?>
</div>