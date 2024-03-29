<div class="left-nav left-nav-open" id="left-nav-filter">
    <div class="left-nav__sticky">


            <?php
                if (empty(isset($show_switch_params_and_auto))) {
                    $show_switch_params_and_auto = true;

                }
            ?>

<?php if ($show_switch_params_and_auto == true): ?>
<div class="title__switch">
<div class="left-nav__switch">
    <a href="javascript:void(0);" onclick="switchTab('params');" id="left-nav__switch__button-params" class="left-nav__switch__button <?php if (empty($modification_slug)) { echo 'active'; } ?>">
        По параметрам
    </a>
        <a href="javascript:void(0);" onclick="switchTab('auto');" id="left-nav__switch__button-auto" class="left-nav__switch__button <?php if (!empty($modification_slug)) { echo 'active'; } ?>">
        По авто
    </a>
</div>
    <a href="javascript:void(0);" onclick="switchFilter();" class="left-nav__button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 10L12 15L17 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
    </a>
</div>
<?php else: ?>
   <div class="title">
    <span class="left-nav__title">
        Фильтр по параметрам:
    </span>
       <a href="javascript:void(0);" onclick="switchFilter();" class="left-nav__button">
           <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 10L12 15L17 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
       </a>
   </div>
<?php endif ?>



    <script>
        var openFilter = true;
        function switchFilter() {
            if (!openFilter) {
                document.getElementById("left-nav-filter").className = "left-nav left-nav-open";
                openFilter = true
            } else {
                document.getElementById("left-nav-filter").className = "left-nav";
                openFilter = false
            }
        }

        function switchTab(params) {

            if (params === 'params') {
                document.getElementById("left-nav__switch__button-params").className = "left-nav__switch__button left-nav__switch__button-params active";
                document.getElementById("left-nav__switch__button-auto").className = "left-nav__switch__button left-nav__switch__button-auto";

                document.getElementById("filter").style = "display: block";
                document.getElementById("filter-group__auto").style = "display: none";
            } else {
                document.getElementById("left-nav__switch__button-params").className = "left-nav__switch__button left-nav__switch__button-params";
                document.getElementById("left-nav__switch__button-auto").className = "left-nav__switch__button left-nav__switch__button-auto active";

                document.getElementById("filter").style = "display: none";
                document.getElementById("filter-group__auto").style = "display: block";
            }
        }

        function setAuto() {
            $("#CarBrandSlug").html('<?php echo $car_brand['CarBrand']['title']; ?>').change();
            $("#CarBrandSlug").attr('value', '<?php echo $car_brand['CarBrand']['slug']; ?>');

            $("#CarModelSlug").html('<?php echo $car_model['CarModel']['title']; ?>').change();
            $("#CarModelSlug").attr('value', '<?php echo $car_model['CarModel']['slug']; ?>');

            $("#CarGenerationSlug").html('<?php echo $car_generation['CarGeneration']['title']; ?>').change();
            $("#CarGenerationSlug").attr('value', '<?php echo $car_generation['CarGeneration']['slug']; ?>');

            $("#CarModificationSlug").html('<?php echo $car_modification['CarModification']['title']; ?>').change();
            $("#CarModificationSlug").attr('value', '<?php echo $car_modification['CarModification']['slug']; ?>');

            if ('<?php echo $season; ?>') {
                $("#AutoSelectionSeason").val('<?php echo $season; ?>').change();
            }
            if ('<?php echo $material; ?>') {
                $("#AutoSelectionMaterial").val('<?php echo $material; ?>').change();
            }

        }

        function getTab() {
            if ('<?php echo $modification_slug; ?>') {
                setTimeout(()=> {
                    // switchTab('auto');
                    setAuto();
                    }, 1);
            }
        }

        getTab();
    </script>

<?php
 //print_r($this->request->data['Product']);

if (empty($show_filter)) {
	$show_filter = 0;
}
$path = 'tyres';
$settings = Cache::read('settings', 'long');

/*
	echo "======";
	print_r($select);
	echo "======";
*/

/*
	echo $settings['SHOW_TYRES_VSE_SAMER'];   	echo "<br>";	Отображать всезезонную только при выборе летних
	echo $settings['SHOW_TYRES_VSE_WINTER'];  	echo "<br>";	Отображать всезезонную только при выборе зимних
	echo $settings['SHOW_TYRES_VSE_VSE'];  		echo "<br>";	Отображать всезезонную только при выборе всесезонных
	
	
	echo $settings['SHOW_DISKS_IMG'];  			echo "<br>";	Показывать модели дистов только с картинками
	echo $settings['SHOW_TYRES_IMG'];  			echo "<br>";	Показывать модели шин только с картинками
	echo $settings['SHOW_TYRES_IMG_TOVAR'];  	echo "<br>";	Показывать товары шин только с картинками
	echo $settings['SHOW_DISKS_IMG_TOVAR'];  	echo "<br>";	Показывать товары дисков только с картинками

*/
	$upr_all = '';
	if ( $settings['SHOW_TYRES_VSE_SAMER'] == 1 ) 	{ $upr_all = 1; } 	
	if ( $settings['SHOW_TYRES_VSE_WINTER'] == 1 ) 	{ $upr_all = 2; } 	
	//if ( $settings['SHOW_TYRES_VSE_VSE'] == 1 ) 	{ $upr_all = 3; } 		

	
	
?>
<?php if ($show_filter == 1) { ?>
<div class="filter-group tyres" id="filter" style="<?php if (!empty($modification_slug)) { echo 'display: none'; } ?>">
	<?php
		$url = array('controller' => 'tyres', 'action' => 'index');

		if (!isset($this->request->data['Product']['in_stock'])) {
			if ( $settings['SHOW_TYRES_BAR'] == 1 ) { $in_stocky = 1; } else { $in_stocky = 2; }
		//	$this->request->data['Product']['in_stock'] = $in_stocky;
		}
		echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
		?>
	<div class="item">
		<div class="item-inner">
			<label class="name" for="ProductAuto">Тип авто:</label>
			<div class="inp"><?php
		
				echo $this->Form->input('auto', array('type' => 'select', 'label' => false, 
				
				'options' => $filter_auto, 
				'empty' => array('' => 'Все'), 
				
				'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner axis-select">
			<label class="name" for="ProductAxis">Ось:</label>
			<div class="inp"><?php
				echo $this->Form->input('axis', array('type' => 'select', 'label' => false, 'options' => $tyre_axis, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
        <div class="item-group">
		<div class="item-inner">
			<label class="name">Ширина:</label>
			<div class="inp"><?php
				echo $this->Form->input('size1', array('type' => 'select', 'label' => false, 'options' => $tyre_size1, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>			
		<div class="item-inner">
			<label class="name">Высота:</label>
			<div class="inp"><?php
				echo $this->Form->input('size2', array('type' => 'select', 'label' => false, 'options' => $tyre_size2, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>			
		<div class="item-inner">
			<label class="name">Диаметр:</label>
			<div class="inp"><?php
				echo $this->Form->input('size3', array('type' => 'select', 'label' => false, 'options' => $tyre_size3, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
        </div>
        <div class="item-inner">
			<label class="name" for="ProductSeason">Сезон:</label>
			<div class="inp"><?php 
		
				echo $this->Form->input('season', array('type' => 'select', 'label' => false, 'options' => $filter_seasons, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>	
		<div class="item-inner">
			<label class="name" for="ProductBrandId">Производитель:</label>
			<div class="inp"><?php
				echo $this->Form->input('brand_id', array('type' => 'select', 'label' => false, 'options' => $filter_brands, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select', 'required' => false));
			?></div>
			<div class="clear"></div>
		</div>		
	</div>
	<div class="item item2">
		<div class="item item3 col-l">
            <div class="item-group">
			<div class="item-inner">
				<?php
					$disabled = '';
					if ($stud == 0) {
						$disabled = 'disabled';
					}
					echo $this->Form->input('stud', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'checkbox filter-checkbox', 'disabled' => $disabled));
				?>
				<label class="checkbox-name" for="ProductStud">шипованная</label>
				<div class="clear"></div>
			</div>
			<div class="item-inner">
				<?php
					$disabled = '';
					if ($in_stock4 == 0) {
						$disabled = 'disabled';
					}
					echo $this->Form->input('in_stock4', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'checkbox filter-checkbox', 'disabled' => $disabled));
				?>
				<label class="checkbox-name" for="ProductInStock4">более 4</label>
				<div class="clear"></div>
			</div>
            </div>
		</div>
		<div class="item item3 col-r">
            <label class="item-inner__label">Наличие:</label>
            <div class="item-group">
			<div class="item-inner">
				<?php
				//print_r($select['PRODUCTINSTOCK']);
					
				$attr=array('label' => false,'class' => 'checkbox','hiddenField' => false, 'checked' => true);
				if(isset($select['PRODUCTINSTOCK']['все'])):
					$attr['checked']=$select['PRODUCTINSTOCK']['все'] == 0 ? FALSE : TRUE;
				endif;
				echo $this->Form->radio('in_stock', array('2' => ''), $attr);
				?>
				
				<label class="checkbox-name" for="ProductInStock2">все</label>
				<div class="clear"></div>
			</div>
			<div class="item-inner">
				<?php
				
				$attr=array('label' => false,'class' => 'checkbox','hiddenField' => false);
				if(isset($select['PRODUCTINSTOCK']['в наличии'])):
					$attr['checked']=$select['PRODUCTINSTOCK']['в наличии'] == 0 ? FALSE : TRUE;
				endif;
				echo $this->Form->radio('in_stock', array('1' => ''), $attr);
				?>
				<label class="checkbox-name" for="ProductInStock1">в наличии</label>
				<div class="clear"></div>
			</div>
			<div class="item-inner">
				<?php
					
				$attr=array('label' => false,'class' => 'checkbox','hiddenField' => false);
				if(isset($select['PRODUCTINSTOCK']['под заказ'])):
					$attr['checked']=$select['PRODUCTINSTOCK']['под заказ'] == 0 ? FALSE : TRUE;
				endif;
				echo $this->Form->radio('in_stock', array('0' => ''), $attr);

					
					
		//  ,'display' => 'none'			
				?>
				<label class="checkbox-name" for="ProductInStock0">под заказ</label>
				<div class="clear"></div>
			</div></div>
		</div>	
			<div class="item">
			<div class="item-inner">
				<?php
					echo $this->Form->hidden('upr_all', array('value' => $upr_all));
				?>
				
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="item">
		<button class="bt-style1">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<?php } elseif ($show_filter == 2) { $path = 'disks';?>
<div class="filter-group disks" id="filter" style="<?php if (!empty($modification_slug)) { echo 'display: none'; } ?>">
	<?php
		if (!isset($this->request->data['Product']['in_stock'])) {
			if ( $settings['SHOW_DISKS_BAR'] == 1 ) { $in_stocky = 1; } else { $in_stocky = 2; }
		//	$this->request->data['Product']['in_stock'] = $in_stocky;
		}
		$url = array('controller' => 'disks', 'action' => 'index');
		echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
		echo $this->Form->hidden('size3');
	?>
	<div class="item">

		<div class="item-inner">
			<label class="name" for="ProductSize1">Диаметр:</label>
			<div class="inp"><?php
				echo $this->Form->input('size1', array('type' => 'select', 'label' => false, 'options' => $disk_size1, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="ProductMaterial">Материал:</label>
			<div class="inp"><?php
				echo $this->Form->input('material', array('type' => 'select', 'label' => false, 'options' => $materials, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item item2">
		<div class="item-inner item-inner-et">
			<label class="name" for="ProductEtFrom">ET</label>
			<div class="inp inp-et">
				<?php echo $this->Form->input('et_from', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'sel-style3 filter-text')); ?>- <?php echo $this->Form->input('et_to', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'sel-style3 filter-text')); ?>
			</div>
			<div class="clear"></div>
		</div>
        <div class="item-group">
		<div class="item-inner">
			<label class="name" for="ProductSize2">PCD:</label>
			<div class="inp"><?php
				echo $this->Form->input('size2', array('type' => 'select', 'label' => false, 'options' => $disk_size2, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="ProductHub">Ступица:</label>
			<div class="inp"><?php
				echo $this->Form->input('hub', array('type' => 'select', 'label' => false, 'options' => $disk_hub, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
        </div></div>
		<div class="item-inner">
			<label class="name" for="ProductBrandId">Производитель:</label>
			<div class="inp"><?php
				echo $this->Form->input('brand_id', array('type' => 'select', 'label' => false, 'options' => $filter_brands, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select', 'required' => false));
			?></div>
			<div class="clear"></div>
		</div>		
	</div>
	<div class="item item3 col-r">
		<div class="item-inner">
			<?php
				$disabled = '';
				if ($in_stock4 == 0) {
					$disabled = 'disabled';
				}
				echo $this->Form->input('in_stock4', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'checkbox filter-checkbox', 'disabled' => $disabled));
			?>
			<label class="checkbox-name" for="ProductInStock4">более 4</label>
			<div class="clear"></div>
		</div>
        <label class="item-inner__label">Наличие:</label>
        <div class="item-group">
        <div class="item-inner">

			<?php
			
			$attr=array('label' => false,'class' => 'checkbox','hiddenField' => false, 'checked' => true);
				if(isset($select['PRODUCTINSTOCK2']['все'])):
					$attr['checked']=$select['PRODUCTINSTOCK2']['все'] == 0 ? FALSE : TRUE;
				endif;
				echo $this->Form->radio('in_stock', array('2' => ''), $attr);
			
				//echo $this->Form->radio('in_stock', array('2' => ''), array('label' => false, 'class' => 'checkbox', 'hiddenField' => false));
			?>
			<label class="checkbox-name" for="ProductInStock2">все</label>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<?php
			
			$attr=array('label' => false,'class' => 'checkbox','hiddenField' => false);
				if(isset($select['PRODUCTINSTOCK2']['в наличии'])):
					$attr['checked']=$select['PRODUCTINSTOCK2']['в наличии'] == 0 ? FALSE : TRUE;
				endif;
				echo $this->Form->radio('in_stock', array('1' => ''), $attr);
			
			
				//echo $this->Form->radio('in_stock', array('1' => ''), array('label' => false, 'class' => 'checkbox', 'hiddenField' => false));
			?>
			<label class="checkbox-name" for="ProductInStock1">в наличии</label>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<?php
				
			$attr=array('label' => false,'class' => 'checkbox','hiddenField' => false);
				if(isset($select['PRODUCTINSTOCK2']['под заказ'])):
					$attr['checked']=$select['PRODUCTINSTOCK2']['под заказ'] == 0 ? FALSE : TRUE;
				endif;
				echo $this->Form->radio('in_stock', array('0' => ''), $attr);
			
			
			//echo $this->Form->radio('in_stock', array('0' => ''), array('label' => false, 'class' => 'checkbox', 'hiddenField' => false));
			?>
			<label class="checkbox-name" for="ProductInStock0">под заказ</label>
			<div class="clear"></div>
		</div>
        </div>
	</div>
	<div class="item">
		<button class="bt-style1 bt-style1-disks">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<?php } elseif ($show_filter == 7) { $path = 'bolts';?>
<div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) { echo 'display: none'; } ?>">
	<?php
		$url = array('controller' => 'bolts', 'action' => 'index');
		echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
	?>
	<div class="item">
		<div class="item-inner">
			<label class="name" for="ProductBoltType">Тип:</label>
			<div class="inp"><?php
				echo $this->Form->input('bolt_type', array('type' => 'select', 'label' => false, 'options' => $bolt_types, 'empty' => false, 'div' => false, 'class' => 'sel-style1 filter-select', 'required' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner size1 bolt">
			<label class="name" for="ProductSize1">Диаметр:</label>
			<div class="inp"><?php
				echo $this->Form->input('size1', array('type' => 'select', 'label' => false, 'options' => $bolts_size1, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner size2 bolt">
			<label class="name" for="ProductSize2">Шаг резьбы:</label>
			<div class="inp"><?php
				echo $this->Form->input('size2', array('type' => 'select', 'label' => false, 'options' => $bolts_size2, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner ring bolt">
			<label class="name" for="ProductSize3">Длина резьбы:</label>
			<div class="inp"><?php
				echo $this->Form->input('size3', array('type' => 'select', 'label' => false, 'options' => $bolts_size3, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item">
		<div class="item-inner ring bolt">
			<label class="name" for="ProductF1">Размер ключа:</label>
			<div class="inp"><?php
				echo $this->Form->input('f1', array('type' => 'select', 'label' => false, 'options' => $bolts_f1, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner ring bolt">
			<label class="name" for="ProductColor">Тип гайки/болта:</label>
			<div class="inp"><?php
				echo $this->Form->input('color', array('type' => 'select', 'label' => false, 'options' => $bolts_color, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner ring bolt">
			<label class="name" for="ProductMaterial">Покрытие:</label>
			<div class="inp"><?php
				echo $this->Form->input('material', array('type' => 'select', 'label' => false, 'options' => $bolts_material, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner valve">
			<label class="name" for="ProductSku">Тип вентиля:</label>
			<div class="inp"><?php
				echo $this->Form->input('sku', array('type' => 'select', 'label' => false, 'options' => $bolts_sku, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item item3">
		<div class="item-inner">
			<?php
				$disabled = '';
				if ($in_stock == 0) {
					$disabled = 'disabled';
				}
				echo $this->Form->input('in_stock', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'checkbox filter-checkbox', 'disabled' => $disabled));
			?>
			<label class="checkbox-name" for="ProductInStock">есть в наличии</label>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item bt">
		<button class="bt-style1">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<?php } elseif ($show_filter == 3) { $path = 'akb';?>
<div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) { echo 'display: none'; } ?>">
	<?php
		$url = array('controller' => 'akb', 'action' => 'index');
		echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
	?>
	<div class="item">
        <div class="item-group">
		<div class="item-inner">
			<label class="name" for="ProductAh">Ah:</label>
			<div class="inp"><?php
				echo $this->Form->input('ah', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $akb_ah, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="ProductCurrent">Ток:</label>
			<div class="inp"><?php
				echo $this->Form->input('current', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $akb_current, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
        </div>
		<div class="item-inner">
			<label class="name" for="Productf1">Тип:</label>
			<div class="inp"><?php
				echo $this->Form->input('f1', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $akb_f1, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item item2">
        <div class="item-group">
		<div class="item-inner">
			<label class="name" for="ProductWidth">Ширина:</label>
			<div class="inp"><?php
				echo $this->Form->input('width', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $akb_width, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner" for="ProductLength">
			<label class="name">Длина:</label>
			<div class="inp"><?php
				echo $this->Form->input('length', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $akb_length, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="ProductHeight">Высота:</label>
			<div class="inp"><?php
				echo $this->Form->input('height', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $akb_height, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
        </div>
		<div class="item-inner">
			<label class="name" for="ProductBrandId">Производитель:</label>
			<div class="inp"><?php
				echo $this->Form->input('brand_id', array('class' => 'filter-select sel-style1', 'type' => 'select', 'label' => false, 'options' => $filter_brands, 'empty' => array('' => 'Все'), 'div' => false, 'required' => false));
			?></div>
			<div class="clear"></div>
		</div>		
	</div>
	<div class="item">
		<button class="bt-style1">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<?php } if ($show_filter == 4 || $show_switch_params_and_auto == true) { ?>
<div class="filter-group" id="filter-group__auto" style="<?php if ($show_switch_params_and_auto == true) { echo 'display: none'; } ?> <?php if (!empty($modification_slug)) { echo 'display: block'; } ?>">
	<?php
		$url = array('controller' => 'selection', 'action' => 'view');
		echo $this->Form->create('Car', array('type' => 'get', 'url' => $url));
	?>
        <div class="item item5">
            <div class="item-inner">
                <label class="name" for="CarBrandSlug">Производитель:</label>
                <a class="inp" href="javascript:void(0);" onclick="openSelectionBrandModal();">
                    <span name="brand_id" id="CarBrandSlug" value="" class="sel-style1">...</span>
                </a>
            </div>
            <div class="item-inner">
                <label class="name" for="CarModelSlug">Модель:</label>
                <a class="inp" href="javascript:void(0);" onclick="openSelectionModelModal();">
                    <span name="model_id" id="CarModelSlug" value="" class="sel-style1" >...</span>
                </a>
            </div>
        </div>
        <div class="item">
            <div class="item-inner">
                <label class="name" for="CarGenerationSlug">Поколение:</label>
                <a class="inp" href="javascript:void(0);" onclick="openSelectionGenerationModal();">
                    <span name="year_id" id="CarGenerationSlug" value="" class="sel-style1" />...</span>
                </a>
            </div>
            <div class="item-inner" for="CarModificationSlug">
                <label class="name">Модификация:</label>
                <a class="inp" href="javascript:void(0);" onclick="openSelectionModModal();">
                    <span name="year_id" id="CarModificationSlug" value="" class="sel-style1" />...</span>
                </a>
            </div>
        </div>
    <div class="item" style="<?php if ($show_filter != 1 || empty($modification_slug)) { echo 'display: none'; } ?>">
        <div class="item-inner">
            <label class="name" for="ProductSeason">Сезон:</label>
            <div class="inp"><?php
                echo $this->Form->input('season', array('type' => 'select', 'label' => false, 'options' => $filter_seasons, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select', 'id' => 'AutoSelectionSeason'));
                ?></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="item" style="<?php if ($show_filter != 2 || empty($modification_slug)) { echo 'display: none'; } ?>">
        <div class="item-inner">
            <label class="name" for="ProductMaterial">Материал:</label>
            <div class="inp"><?php
                echo $this->Form->input('material', array('type' => 'select', 'label' => false, 'options' => $materials, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select', 'id' => 'AutoSelectionMaterial'));
                ?></div>
            <div class="clear"></div>
        </div>
    </div>
        <script type="text/javascript">
            function openSelectionBrandModal() {
                open_popup({
                    url: '/selection-modal/<?php echo $show_filter;?>',
                    type: 'post',
                    size: 'lg'
                });
            }
            function openSelectionModelModal() {
                if ($('#CarBrandSlug').attr('value') != 0 && $('#CarBrandSlug').attr('value') != '') {
                    open_popup({
                        url: `/selection-modal/<?php echo $show_filter;?>/${$('#CarBrandSlug').attr('value')}`,
                        type: 'post',
                        size: 'lg'
                    });
                } else {
                    openSelectionBrandModal();
                }
            }
            function openSelectionGenerationModal() {
                if ($('#CarModelSlug').attr('value') != 0 && $('#CarModelSlug').attr('value') != '') {
                    open_popup({
                        url: `/selection-modal/<?php echo $show_filter;?>/${$('#CarBrandSlug').attr('value')}/${$('#CarModelSlug').attr('value')}`,
                        type: 'post',
                        size: 'lg'
                    });
                } else {
                    openSelectionModelModal();
                }
            }
            function openSelectionModModal() {
                if ($('#CarGenerationSlug').attr('value') != 0 && $('#CarGenerationSlug').attr('value') != '') {
                    open_popup({
                        url: `/selection-modal/<?php echo $show_filter;?>/${$('#CarBrandSlug').attr('value')}/${$('#CarModelSlug').attr('value')}/${$('#CarGenerationSlug').attr('value')}`,
                        type: 'post',
                        size: 'lg'
                    });
                } else {
                    openSelectionGenerationModal();
                }
            }
        </script>

	<div class="item">
		<button class="bt-style1" id="sel_submit" type="button" onclick="onSearchModifications()">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<script type="text/javascript">
<!--
$(function(){
	$('#sel_submit').click(function() {
		if ($('#CarBrandSlug').val() == 0 || $('#CarBrandSlug').val() == '') {
			return false;
		}
	});
});
//-->
</script>
<?php } elseif ($show_filter == 5) { ?>
<div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) { echo 'display: none'; } ?>">
	<?php
		echo $this->Form->create('UsedTyre', array('type' => 'get', 'url' => array('controller' => 'used_tyres', 'action' => 'index')));
	?>
	<div class="item item7">
		<div class="item-inner">
			<label class="name" for="UsedTyreSize1">Размер:</label>
			<div class="inp"><?php
				echo $this->Form->input('size1', array('class' => 'sel-style4', 'type' => 'select', 'label' => false, 'options' => $used_tyre_size1, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="UsedTyreSize2">\:</label>
			<div class="inp"><?php
				echo $this->Form->input('size2', array('class' => 'sel-style4', 'type' => 'select', 'label' => false, 'options' => $used_tyre_size2, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
		<div class="item-inner">
			<label class="name" for="UsedTyreSize3">R:</label>
			<div class="inp"><?php
				echo $this->Form->input('size3', array('class' => 'sel-style4', 'type' => 'select', 'label' => false, 'options' => $used_tyre_size3, 'empty' => array('' => 'Все'), 'div' => false));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item bt bt2">
		<button class="bt-style1">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<?php } elseif ($show_filter == 6) { ?>
<div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) { echo 'display: none'; } ?>">
	<?php
		$url = array('controller' => 'tubes', 'action' => 'index');
		echo $this->Form->create('Product', array('type' => 'get', 'url' => $url));
	?>
	<div class="item item10">
		<div class="item-inner">
			<label class="name" for="ProductType">Тип:</label>
			<div class="inp"><?php
				echo $this->Form->input('type', array('type' => 'select', 'label' => false, 'options' => $types, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1'));
			?></div>
			<div class="clear"></div>
		</div>

	</div>
	<div class="item item8">
		<div class="item-inner">
			<label class="name" for="ProductInfo">Найти размер:</label>
			<div class="inp"><?php
				echo $this->Form->input('info', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'sel-style1'));
			?></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item item9">
		<div class="item-inner">
			<?php
				echo $this->Form->input('in_stock', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'checkbox'));
			?>
			<label class="checkbox-name" for="ProductInStock">есть в наличии</label>
			<div class="clear"></div>
		</div>
	</div>
	<div class="item bt bt2">
		<button class="bt-style1">ПОИСК</button>
	</div>
	<div class="clear"></div>
	</form>
</div>
<?php } ?>

<script type="text/javascript">
<!--
<?php if (CONST_DISABLE_FILTERS == '0') { ?>
function loadSelectData(data, status)  {
	$.each(data, function(field_key, field_value) {
		if (typeof(field_value) == 'object') {
			var options = '<option value="0">Все</option>';
			if (field_value.length == 0) {
				options = '<option value="0">---</option>';
			}
			var curr_select = $('select[name="' + field_key + '"]');
			var curr_value = curr_select.find(':selected').val(), selected_added = false;
			$.each(field_value, function(key, value) {
				var selected = '';
				if (curr_value == key && !selected_added && key != 0) {
					selected = ' selected';
					selected_added = true;
				}
				options += '<option' + selected + ' value="' + key + '">' + value + '</option>';
			});
			if (!curr_select.hasClass('changed')) {
				curr_select.html(options).removeAttr('disabled');
			}
		}
		else {
			if (field_value == 0) {
				$('input[name="' + field_key + '"]').attr('disabled', 'disabled');
			}
			else {
				$('input[name="' + field_key + '"]').removeAttr('disabled');
			}
		}
	});
}
<?php } ?>
function auto_handler() {
	var auto = $('#ProductAuto').val();
	if (auto == 'trucks') {
		$('.axis-select').show();
	}
	else {
		$('.axis-select').hide();
	}
}


$(function(){
	
	function ksort(w) {
		var sArr = [], tArr = [], n = 0;
		for (i in w){tArr[n++] = i;}
		tArr = tArr.sort(function (a, b) { return a-b; });
		for (var i=0, n = tArr.length; i<n; i++) {sArr[i] = w[tArr[i]];}
		return sArr;
	}

	$('select[name=auto]').change(function() {
		$.ajax({
  		type: "GET",
  		url: "/tyres/auto?auto=" + $(this).val(),
  		dataType:'json',
		success: function(res) {
			var options = '<option value="0">Все</option>';
			res = ksort(res);
			$.each(res, function(key, value) {
				var selected = '';
				options += '<option' + selected + ' value="' + key + '">' + value + '</option>';
			});
			$("select[name=size1] option").remove();
			$("select[name=size1]").append(options); 
		}
	});
    });
	
  
	
	$('#ProductAuto').change(auto_handler);
	auto_handler();
	<?php if (CONST_DISABLE_FILTERS == '0') { ?>
	$('.filter-select').change(function() {
		$('.filter-select').removeClass('changed');
		$(this).addClass('changed');
		$('.filter-select').each(function(){
			if (!$(this).hasClass('changed')) {
				var curr_value = $(this).find(':selected').val();
				$(this).html('<option value="' + curr_value +'" selected>загрузка...</option>').attr('disabled', 'disabled');
			}
		});
		$.get(
			'/<?php echo $path; ?>/set_filter',
			serializeArray($('#filter-form')),
			loadSelectData,
			'json'
		);
	});
	$('.filter-checkbox').click(function() {
		$('.filter-select').removeClass('changed');
		$('.filter-select').each(function(){
			var curr_value = $(this).find(':selected').val();
			$(this).html('<option value="' + curr_value +'" selected>загрузка...</option>').attr('disabled', 'disabled');
		});
		$.get(
			'/<?php echo $path; ?>/set_filter',
			serializeArray($('#filter-form')),
			loadSelectData,
			'json'
		);
	});
	$('.filter-text').keypress(function() {
		$('.filter-select').removeClass('changed');
		$('.filter-select').each(function(){
			var curr_value = $(this).find(':selected').val();
			$(this).html('<option value="' + curr_value +'" selected>загрузка...</option>').attr('disabled', 'disabled');
		});
		$.get(
			'/<?php echo $path; ?>/set_filter',
			serializeArray($('#filter-form')),
			loadSelectData,
			'json'
		);
	});
	<?php } ?>
	if ($('#ProductBoltType').length) {
		$('#ProductBoltType').change(function(){
			var type = $(this).val();
			if (type == 'ring') {
				$('.bolt').show();
				$('.valve').hide();
				$('.ring').hide();
				$('.size1 label').html('Внешний диаметр:');
				$('.size2 label').html('Внутренний диаметр:');
			}
			else if (type == 'valve') {
				$('.bolt').hide();
				$('.valve').show();
			}
			else {
				$('.bolt').show();
				$('.valve').hide();
				$('.ring').show();
				$('.size1 label').html('Диаметр:');
				$('.size2 label').html('Шаг резьбы:');
			}
		});
		$('#ProductBoltType').change();
	}
});
function serializeArray(form) {
	var ar = [];
	form.find('input[type=text],select').each(function(){
		var val = $(this).val();
		ar[ar.length] = {name: $(this).prop('name'), value: val};
	});
	form.find('input[type=checkbox]').each(function(){
		ar[ar.length] = {name: $(this).prop('name'), value: $(this).prop('checked') ? 1 : 0};
	});
	return ar;
}

function onSearchModifications() {
    const season = $('#AutoSelectionSeason').val();
    const disk_material = $('#AutoSelectionMaterial').val();
    const mod = $('#CarModificationSlug').attr('value');

    if (<?php echo $show_filter; ?> === 1) {
        // tyres
        window.location = `${origin}/tyres?modification=${mod}&season=${season ? season : ''}<?php if (!empty($size1)) { echo '&size1='.$size1; } ?><?php if (!empty($size2)) { echo '&size2='.$size2; } ?><?php if (!empty($size3)) { echo '&size3='.$size3; } ?><?php echo '&diameter='.$this->request->query['diameter']; ?>`;
    }
    if (<?php echo $show_filter; ?> === 2) {
        // disks
        window.location = `${origin}/disks?modification=${mod}&material=${disk_material ? disk_material : ''}<?php echo '&diameter='.$this->request->query['diameter']; ?>`;
    }
    if (<?php echo $show_filter; ?> === 3) {
        // disks
        window.location = `${origin}/akb?modification=${mod}`;
    }
}

//-->
</script>
<?php if (CONST_SELECTION_WITH_MODALS == '1') { ?>
        <script type="text/javascript">
            $('#CarBrandSlug').on('mousedown', function(e) {
                e.preventDefault();
                this.blur();
                window.focus();
            });
            $('#CarModelSlug').on('mousedown', function(e) {
                e.preventDefault();
                this.blur();
                window.focus();
            });
            $('#CarGenerationSlug').on('mousedown', function(e) {
                e.preventDefault();
                this.blur();
                window.focus();
            });
            $('#CarModificationSlug').on('mousedown', function(e) {
                e.preventDefault();
                this.blur();
                window.focus();
            });
        </script>
<?php } ?>
</div></div>