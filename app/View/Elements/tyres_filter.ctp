<div class="clear"></div>
<div class="boxFilter">
	<?php
		if (isset($brand)) {
			$url = array('controller' => 'tyres', 'action' => 'brand', 'slug' => $brand['Brand']['slug']);
		}
		else {
			$url = array('controller' => 'tyres', 'action' => 'index');
		}
		echo $this->Form->create('Product', array('type' => 'get', 'url' => $url));
		echo $this->Form->hidden('model_id');
	?>
	<div class="boxParam">
		<label for="ProductBrandId">производитель</label>
		<div class="select1">
			<div class="textSel">все</div>
			<select id="ProductBrandId" name="brand_id">
				<option value="">Blackstone</option>
			</select>
		</div>
	</div>
	<div class="boxParam">
		<label for="ProductBrandId">ширина</label>
		<div class="select2">
			<div class="textSel">все</div>
			<select id="ProductBrandId" name="brand_id">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="boxParam">
		<label for="ProductBrandId">высота</label>
		<div class="select2">
			<div class="textSel">все</div>
			<select id="ProductBrandId" name="brand_id">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="boxParam">
		<label for="ProductBrandId">диаметр</label>
		<div class="select2">
			<div class="textSel">все</div>
			<select id="ProductBrandId" name="brand_id">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="boxParam">
		<label for="ProductBrandId">сезонность</label>
		<div class="select3">
			<div class="textSel">все</div>
			<select id="ProductBrandId" name="brand_id">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="boxParam">
		<label for="ProductBrandId">тип транспорта</label>
		<div class="select3">
			<div class="textSel">все</div>
			<select id="ProductBrandId" name="brand_id">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="btBoxFilter">
		<button class="btVer1">Подобрать</button>
	</div>
	<div class="clear"></div>
</div>