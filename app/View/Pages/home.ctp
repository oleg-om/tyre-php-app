<div class="block-home">
	<?php $home_photos = $this->requestAction(array('controller' => 'home_photos', 'action' => 'all')); ?>
	<?php if (!empty($home_photos)) { ?>
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<ul><?php
				foreach ($home_photos as $item) {
					if (!empty($item['HomePhoto']['filename'])) {
						echo '<li>';
						$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['HomePhoto']['id'], 'filename' => $item['HomePhoto']['filename'], 'path' => 'slider', 'width' => 870, 'height' => 420, 'crop' => true)));
						if (!empty($item['HomePhoto']['link'])) {
							echo $this->Html->link($image, $item['HomePhoto']['link'], array('escape' => false));
						}
						else {
							echo $image;
						}
						echo '</li>';
					}
				}
		?></ul>
		</div>
		<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
		<a href="#" class="jcarousel-control-next">&rsaquo;</a>
		<p class="jcarousel-pagination"></p>
	</div>
	<div class="clear"></div>
	
<?php } elseif ($show_filter == 4) { ?>
<div class="filter-group" id="filter">
	<?php
		$url = array('controller' => 'selection', 'action' => 'view');
		echo $this->Form->create('Car', array('type' => 'get', 'url' => $url));
	?>
	<div class="item item5">
		<div class="item-inner">
			<label class="name" for="CarBrandId">Производитель:</label>
			<div class="inp"><?php
				echo $this->Form->input('brand_id', array('type' => 'select', 'label' => false, 'options' => $car_brands, 'empty' => array('' => '...'), 'div' => false, 'class' => 'sel-style1', 'required' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="CarModelId">Модель:</label>
			<div class="inp"><?php
				echo $this->Form->input('model_id', array('type' => 'select', 'label' => false, 'options' => $car_models, 'empty' => array('' => '...'), 'div' => false, 'class' => 'sel-style1'));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item">
		<div class="item-inner">
			<label class="name" for="CarYear">Год выпуска:</label>
			<div class="inp"><?php
				echo $this->Form->input('year', array('class' => 'sel-style1', 'type' => 'select', 'label' => false, 'options' => $car_years, 'empty' => array('' => '...'), 'div' => false, 'name' => 'year'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner" for="CarMod">
			<label class="name">Модификация:</label>
			<div class="inp"><?php
				echo $this->Form->input('mod', array('class' => 'sel-style1', 'type' => 'select', 'label' => false, 'options' => $car_modifications, 'empty' => array('' => '...'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item">
		<button class="bt-style1" id="sel_submit">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<script type="text/javascript">
<!--
$(function(){
	$('#sel_submit').click(function() {
		if ($('#CarBrandId').val() == 0 || $('#CarBrandId').val() == '') {
			return false;
		}
	});
	$('#CarBrandId').change(function() {
		if (parseInt($(this).val()) != 0) {
			$('#CarModelId option').remove();
			$('#CarModelId').ajaxAddOption('/car_models/get_models/'+$(this).val(), {}, false);
		}
	});
	$('#CarModelId').change(function() {
		if (parseInt($(this).val()) != 0) {
			$('#CarYear option').remove();
			$('#CarYear').ajaxAddOption('/car_models/get_years/'+$(this).val(), {}, false);
		}
	});
	$('#CarYear').change(function() {
		var brand_id = $('#CarBrandId').val();
		var model_id = $('#CarModelId').val();
		if (parseInt($(this).val()) != 0) {
			$('#CarMod option').remove();
			$('#CarMod').ajaxAddOption('/car_modifications/get_modifications/' + brand_id + '/' + model_id + '/' + $(this).val(), {}, false);
		}
	});
});
//-->
</script>	
	
	<?php } ?>
	<div class="pageText"><?php echo $page['Page']['content'];?></div>
</div>
<div class="clear"></div>
<?php if (!empty($home_photos)) { ?>
<script type="text/javascript">
<!--
(function($) {
    $(function() {
        $('.jcarousel').jcarousel({wrap: 'circular'}).jcarouselAutoscroll({
			interval: <?php echo CONST_SLIDER_SCROLL; ?>,
			target: '+=1',
			autostart: true
		});

        $('.jcarousel-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination();
    });
})(jQuery);
//-->
</script>
<?php } ?>