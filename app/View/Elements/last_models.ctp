<?php if (!empty($last_models)) { ?>
<div class="leftNav">
	<div class="last-models">
	<div class="titleLeft">Последние просмотренные модели</div>
	<?php
		krsort($last_models);
		$i = 0;
		foreach ($last_models as $item) {
		?>
		<div class="item">
		<?php
			if ($item['BrandModel']['category_id'] == 1) {
				if (!empty($item['BrandModel']['filename'])) {
					$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 30, 'height' => 30, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
					$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
				} elseif ($item['BrandModel']['category_id'] == 1) {
					$image = $this->Html->image('no-tyre-last.jpg');
					$image_big = '/img/tyre.jpg';
				} elseif ($item['BrandModel']['category_id'] == 2){
					$image = $this->Html->image('no-disk-last.jpg');
					$image_big = '/img/no-disk-big.jpg';
				}
				echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox'));
				echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
			}
			else {
				if (!empty($item['BrandModel']['filename'])) {
					$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 30, 'height' => 30, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
					$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
				} elseif ($item['BrandModel']['category_id'] == 1) {
					$image = $this->Html->image('no-tyre-last.jpg');
					$image_big = '/img/tyre.jpg';
				} elseif ($item['BrandModel']['category_id'] == 2){
					$image = $this->Html->image('no-disk-last.jpg');
					$image_big = '/img/no-disk-big.jpg';
				}
				echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox'));
				echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
			}
		?>
		<div class="clear"></div>
		</div>
		<?php
			if ($i == 4) {
				$i ++;
				break;
			}
			$i ++;
		} 
		if (count($last_models) > 5) {
			echo $this->Html->link('Все просмотренные', array('controller' => 'pages', 'action' => 'last'));
		}
?>
		<div class="clear"></div>
	</div>
</div>
<?php
	}
?>