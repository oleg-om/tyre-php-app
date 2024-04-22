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
                    <a href="javascript:void(0);" onclick="switchTab('params');" id="left-nav__switch__button-params" class="left-nav__switch__button <?php if (empty($modification_slug)) {
                        echo 'active';
                    } ?>">
                        По параметрам
                    </a>
                    <a href="javascript:void(0);" onclick="switchTab('auto');" id="left-nav__switch__button-auto" class="left-nav__switch__button <?php if (!empty($modification_slug)) {
                        echo 'active';
                    } ?>">
                        По авто
                    </a>
                </div>
                <a href="javascript:void(0);" onclick="switchFilter();" class="left-nav__button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M7 10L12 15L17 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <div class="title">
                <span class="left-nav__title">
                    Фильтр по параметрам:
                </span>
                <a href="javascript:void(0);" onclick="switchFilter();" class="left-nav__button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M7 10L12 15L17 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
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
                    document.getElementById("left-nav__switch__button-params").className =
                        "left-nav__switch__button left-nav__switch__button-params active";
                    document.getElementById("left-nav__switch__button-auto").className =
                        "left-nav__switch__button left-nav__switch__button-auto";

                    document.getElementById("filter").style = "display: block";
                    document.getElementById("filter-group__auto").style = "display: none";
                } else {
                    document.getElementById("left-nav__switch__button-params").className =
                        "left-nav__switch__button left-nav__switch__button-params";
                    document.getElementById("left-nav__switch__button-auto").className =
                        "left-nav__switch__button left-nav__switch__button-auto active";

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
                    setTimeout(() => {
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
        if ($settings['SHOW_TYRES_VSE_SAMER'] == 1) {
            $upr_all = 1;
        }
        if ($settings['SHOW_TYRES_VSE_WINTER'] == 1) {
            $upr_all = 2;
        }
        //if ( $settings['SHOW_TYRES_VSE_VSE'] == 1 ) 	{ $upr_all = 3; } 		
        


        ?>
        <?php if ($show_filter == 1) { ?>
            <div class="filter-group tyres" id="filter" style="<?php if (!empty($modification_slug)) {
                echo 'display: none';
            } ?>">
                <button type="reset" class="filter-reset" id="filter-reset" onclick="resetTyresFilter()">Сбросить
                    фильтр<span>x</span>
                    <script type="text/javascript">
                        function resetTyresFilter() {
                            window.location = '/tyres?in_stock=2';
                        }
                    </script>
                </button>
                <?php
                $url = array('controller' => 'tyres', 'action' => 'index');

                if (!isset($this->request->data['Product']['in_stock'])) {
                    if ($settings['SHOW_TYRES_BAR'] == 1) {
                        $in_stocky = 1;
                    } else {
                        $in_stocky = 2;
                    }
                    //	$this->request->data['Product']['in_stock'] = $in_stocky;
                }
                echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
                ?>
                <div class="item">
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Тип авто', 'name' => 'auto', 'options' => $filter_auto, 'multiple' => false, 'search' => false)); ?>
                    </div>
                    <div class="item-inner axis-select">
                        <label class="name" for="ProductAxis">Ось:</label>
                        <div class="inp"><?php
                        echo $this->Form->input('axis', array('type' => 'select', 'label' => false, 'options' => $tyre_axis, 'empty' => array('' => 'Все'), 'div' => false, 'class' => 'sel-style1 filter-select'));
                        ?></div>
                        <div class="clear"></div>
                    </div>
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Ширина', 'placeholder' => 'Все', 'auto_add_options' => true, 'name' => 'size1', 'options' => $tyre_size1, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                        <?php echo $this->element('custom_select', array('label' => 'Длина', 'placeholder' => 'Все', 'auto_add_options' => true, 'name' => 'size2', 'options' => $tyre_size2, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                        <?php echo $this->element('custom_select', array('label' => 'Диаметр', 'placeholder' => 'Все', 'auto_add_options' => true, 'name' => 'size3', 'options' => $tyre_size3, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                    </div>
                    <?php
                    $season_main_options = array('summer' => array('label' => 'Летние', 'query' => 'season', 'icon' => '/img/icons/season-summer.png'), 'winter' => array('label' => 'Зимние', 'query' => 'season', 'icon' => '/img/icons/season-winter.png'));
                    echo $this->element('custom_radio', array('label' => 'Сезон:', 'options' => $season_main_options));
                    ?>
                    <div class="item-inner-m-0">
                        <?php
                        $season_all_option = array('all' => array('label' => 'Всесезонные', 'query' => 'season', 'icon' => '/img/icons/season-all.png'));
                        echo $this->element('custom_radio', array('options' => $season_all_option));
                        ?>
                    </div>
                    <?php echo $this->element('custom_select', array('label' => 'Бренд', 'name' => 'brand_id', 'options' => $filter_brands, 'multiple' => true, 'search' => true)); ?>

                    <?php
                    $extra_options = array('run_flat' => array('label' => 'RunFlat'), 'stud' => array('label' => 'Шипованная', 'icon' => '/img/studded.png'));
                    echo $this->element('custom_checkbox', array('options' => $extra_options));
                    ?>
                    <?php
                    $extra_options = array('in_stock4' => array('label' => 'Более 4'));
                    echo $this->element('custom_checkbox', array('options' => $extra_options));
                    ?>
                    <div class="item-inner-space-around">
                        <?php
                        $stock_options = array('2' => array('label' => 'Все', 'query' => 'in_stock'), '1' => array('label' => 'В наличии', 'query' => 'in_stock'), '0' => array('label' => 'Под заказ', 'query' => 'in_stock'));
                        echo $this->element('custom_radio', array('label' => 'Наличие:', 'options' => $stock_options, 'size' => 'small', 'default_value' => '2'));
                        ?>
                    </div>
                    <?php
                    echo $this->Form->hidden('upr_all', array('value' => $upr_all));
                    echo $this->Form->hidden('modification', array('value' => $modification_slug));
                    echo $this->Form->hidden('diameter', array('value' => $this->request->query['diameter']));
                    ?>
                </div>
                <div class="item">
                    <button class="bt-style1">ПОИСК</button>
                </div>
                <div class="clear"></div>
                </form>
            </div>
        <?php } elseif ($show_filter == 2) {
            $path = 'disks'; ?>
            <div class="filter-group disks" id="filter" style="<?php if (!empty($modification_slug)) {
                echo 'display: none';
            } ?>">
                <?php
                if (!isset($this->request->data['Product']['in_stock'])) {
                    if ($settings['SHOW_DISKS_BAR'] == 1) {
                        $in_stocky = 1;
                    } else {
                        $in_stocky = 2;
                    }
                    //	$this->request->data['Product']['in_stock'] = $in_stocky;
                }
                $url = array('controller' => 'disks', 'action' => 'index');
                echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
                echo $this->Form->hidden('size3');
                ?>
                <button type="reset" class="filter-reset" id="filter-reset" onclick="resetDisksFilter()">Сбросить
                    фильтр<span>x</span>
                    <script type="text/javascript">
                        function resetDisksFilter() {
                            window.location = '/disks?in_stock=2';
                        }
                    </script>
                </button>
                <div class="item">
                    <div class="item-group">
                    <?php echo $this->element('custom_select', array('label' => 'Диаметр обода', 'placeholder' => 'Все', 'auto_add_options' => true, 'name' => 'size1', 'options' => $disk_size1, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                    <?php echo $this->element('custom_select', array('label' => 'Сверловка (PCD)', 'placeholder' => 'Все', 'auto_add_options' => true, 'name' => 'size2', 'options' => $disk_size2, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                    </div>
                </div>
                <div class="item item-icon__disk">
                    <?php
                    $material_options = array('cast' => array('label' => 'Литые', 'query' => 'material', 'icon' => '/img/icons/disk-cast.png'), 'steel' => array('label' => 'Стальные', 'query' => 'material', 'icon' => '/img/icons/disk-steel.png'));
                    echo $this->element('custom_radio', array('label' => 'Материал:', 'options' => $material_options, 'size' => 'large'));
                    ?>
                </div>
                <div class="item item2">
                    <div class="item-inner item-inner-et">
                        <label class="name" for="ProductEtFrom">Вылет (ET), мм:</label>
                        <div class="inp inp-et">
                            <?php echo $this->element('custom_select', array('add_prefix' => 'От: ', 'auto_add_options' => true, 'name' => 'et_from', 'placeholder' => 'От', 'options' => $disk_et, 'multiple' => false, 'search' => false)); ?>
                            <?php echo $this->element('custom_select', array('add_prefix' => 'До: ', 'auto_add_options' => true, 'name' => 'et_to', 'placeholder' => 'До', 'options' => $disk_et, 'multiple' => false, 'search' => false)); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Диаметр ступицы, мм', 'placeholder' => 'Все', 'auto_add_options' => true, 'name' => 'hub', 'options' => $disk_hub, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                    </div>
                    <?php echo $this->element('custom_select', array('label' => 'Бренд', 'name' => 'brand_id', 'options' => $filter_brands, 'multiple' => true, 'search' => true)); ?>
                </div>
                    <div class="item">
                    <?php
                    $extra_options = array('in_stock4' => array('label' => 'Более 4'));
                    echo $this->element('custom_checkbox', array('options' => $extra_options));
                    ?>
                    <div class="item-inner-space-around">
                        <?php
                        $stock_options = array('2' => array('label' => 'Все', 'query' => 'in_stock'), '1' => array('label' => 'В наличии', 'query' => 'in_stock'), '0' => array('label' => 'Под заказ', 'query' => 'in_stock'));
                        echo $this->element('custom_radio', array('label' => 'Наличие:', 'options' => $stock_options, 'size' => 'small', 'default_value' => '2'));
                        ?>
                    </div>
                </div>
                <?php
                echo $this->Form->hidden('modification', array('value' => $modification_slug));
                echo $this->Form->hidden('diameter', array('value' => $this->request->query['diameter']));
                echo $this->Form->hidden('hub_from', array('value' => $this->request->query['hub_from']));
                echo $this->Form->hidden('hub_to', array('value' => $this->request->query['hub_to']));
                ?>
                <div class="item">
                    <button class="bt-style1 bt-style1-disks">ПОИСК</button>
                </div>
                <div class="clear"></div>
                </form>
            </div>
        <?php } elseif ($show_filter == 7) {
            $path = 'bolts'; ?>
            <div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) {
                echo 'display: none';
            } ?>">
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
        <?php } elseif ($show_filter == 3) {
            $path = 'akb'; ?>
            <div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) {
                echo 'display: none';
            } ?>">
                <button type="reset" class="filter-reset" id="filter-reset" onclick="resetAkbFilter()">Сбросить
                    фильтр<span>x</span>
                    <script type="text/javascript">
                        function resetAkbFilter() {
                            window.location = '/akb';
                        }
                    </script>
                </button>
                <?php
                $url = array('controller' => 'akb', 'action' => 'index');
                echo $this->Form->create('Product', array('type' => 'get', 'id' => 'filter-form', 'url' => $url));
                ?>
                <div class="item">
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Вид аккумулятора', 'name' => 'auto', 'options' => $filter_auto, 'multiple' => false, 'search' => false)); ?>
                    </div>
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Емкость, Ah', 'options_postfix' => 'ач', 'add_prefix' => 'От: ', 'auto_add_options' => true, 'name' => 'ah_from', 'placeholder' => 'От', 'options' => $akb_ah, 'multiple' => false, 'search' => false)); ?>
                        <?php echo $this->element('custom_select', array('label' => 'Пусковой ток, A', 'name' => 'current_from', 'add_prefix' => 'От: ', 'auto_add_options' => true, 'placeholder' => 'От', 'options' => $akb_current, 'multiple' => false, 'search' => false)); ?>
                    </div>
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('name' => 'ah_to', 'options_postfix' => 'ач', 'add_prefix' => 'До: ', 'auto_add_options' => true, 'placeholder' => 'До', 'options' => $akb_ah, 'multiple' => false, 'search' => false)); ?>
                        <?php echo $this->element('custom_select', array('name' => 'current_to', 'auto_add_options' => true, 'add_prefix' => 'До: ', 'placeholder' => 'До', 'options' => $akb_current, 'multiple' => false, 'search' => false)); ?>
                    </div>
                    <?php
                    echo $this->element('akb_polarity_filter');
                    ?>
                    <?php
                    $f1_options = array('euro' => array('label' => 'Евро', 'query' => 'f1'), 'asia' => array('label' => 'Азия', 'query' => 'f1'));
                    echo $this->element('custom_radio', array('label' => 'Тип корпуса:', 'options' => $f1_options));
                    ?>
                    <?php
                    $size__options = array('short' => array('label' => 'Низкий'), 'tight' => array('label' => 'Узкий'));
                    echo $this->element('custom_checkbox', array('options' => $size__options));
                    ?>
                    <?php
                    $start_stop__options = array('efb' => array('label' => 'EFB'), 'agm' => array('label' => 'AGM'));
                    echo $this->element('custom_checkbox', array('label' => 'Start-stop:', 'options' => $start_stop__options));
                    ?>
                </div>
                <div class="item item2">
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Длина', 'disabled' => $modification_slug, 'placeholder' => 'От', 'add_prefix' => 'От: ', 'auto_add_options' => true, 'name' => 'length_from', 'options' => $akb_length, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                        <?php echo $this->element('custom_select', array('label' => 'Ширина', 'disabled' => $modification_slug, 'placeholder' => 'От', 'add_prefix' => 'От: ', 'auto_add_options' => true, 'name' => 'width_from', 'options' => $akb_width, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                        <?php echo $this->element('custom_select', array('label' => 'Высота', 'placeholder' => 'От', 'auto_add_options' => true, 'add_prefix' => 'От: ', 'name' => 'height_from', 'options' => $akb_height, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                    </div>
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('name' => 'length_to', 'disabled' => $modification_slug, 'placeholder' => 'До', 'add_prefix' => 'До: ', 'auto_add_options' => true, 'options' => $akb_length, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                        <?php echo $this->element('custom_select', array('name' => 'width_to', 'disabled' => $modification_slug, 'placeholder' => 'До', 'add_prefix' => 'До: ', 'auto_add_options' => true, 'options' => $akb_width, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                        <?php echo $this->element('custom_select', array('name' => 'height_to', 'placeholder' => 'До', 'auto_add_options' => true, 'add_prefix' => 'До: ', 'options' => $akb_height, 'multiple' => false, 'search' => false, 'hideClearButton' => true)); ?>
                    </div>
                    <?php echo $this->element('custom_select', array('label' => 'Бренд', 'name' => 'brand_id', 'options' => $filter_brands, 'multiple' => true, 'search' => true)); ?>
                    <div class="item-group">
                        <?php echo $this->element('custom_select', array('label' => 'Технология изг.', 'name' => 'color', 'options' => $akb_technology)); ?>
                        <?php echo $this->element('custom_select', array('label' => 'Гарантия', 'name' => 'axis', 'options' => $akb_warranty)); ?>
                    </div>
                    <?php echo $this->element('custom_select', array('label' => 'Страна-производитель', 'name' => 'material', 'options' => $akb_country, 'multiple' => true)); ?>
                    <input class="d-none" type="hidden" value="<?php echo $modification_slug; ?>" name="modification" />
                </div>
                <div class="item">
                    <button class="bt-style1">ПОИСК</button>
                </div>
                <div class="clear"></div>
                </form>
            </div>
        <?php }
        if ($show_filter == 4 || $show_switch_params_and_auto == true) { ?>
            <div class="filter-group" id="filter-group__auto" style="<?php if ($show_switch_params_and_auto == true) {
                echo 'display: none';
            } ?> <?php if (!empty($modification_slug)) {
                  echo 'display: block';
              } ?>">
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
                            <span name="model_id" id="CarModelSlug" value="" class="sel-style1">...</span>
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
                <?php if ($show_filter != 1 || empty($modification_slug)) { echo ''; } else { ?>
                    <div class="item">
                        <?php
                        $season_main_options = array('summer' => array('label' => 'Летние', 'query' => 'season', 'icon' => '/img/icons/season-summer.png'), 'winter' => array('label' => 'Зимние', 'query' => 'season', 'icon' => '/img/icons/season-winter.png'));
                        echo $this->element('custom_radio', array('label' => 'Сезон:', 'options' => $season_main_options));
                        ?>
                        <div class="item-inner-m-0">
                            <?php
                            $season_all_option = array('all' => array('label' => 'Всесезонные', 'query' => 'season', 'icon' => '/img/icons/season-all.png'));
                            echo $this->element('custom_radio', array('options' => $season_all_option));
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($show_filter != 2 || empty($modification_slug)) { echo ''; } else { ?>
                    <div class="item item-icon__disk">
                        <?php
                        $material_options = array('cast' => array('label' => 'Литые', 'query' => 'material', 'icon' => '/img/icons/disk-cast.png'), 'steel' => array('label' => 'Стальные', 'query' => 'material', 'icon' => '/img/icons/disk-steel.png'));
                        echo $this->element('custom_radio', array('label' => 'Материал:', 'options' => $material_options, 'size' => 'large'));
                        ?>
                    </div>
                <?php } ?>

                <script type="text/javascript">
                    function openSelectionBrandModal() {
                        open_popup({
                            url: '/selection-modal/<?php echo $show_filter; ?>',
                            type: 'post',
                            size: 'lg'
                        });
                    }

                    function openSelectionModelModal() {
                        if ($('#CarBrandSlug').attr('value') != 0 && $('#CarBrandSlug').attr('value') != '') {
                            open_popup({
                                url: `/selection-modal/<?php echo $show_filter; ?>/${$('#CarBrandSlug').attr('value')}`,
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
                                url: `/selection-modal/<?php echo $show_filter; ?>/${$('#CarBrandSlug').attr('value')}/${$('#CarModelSlug').attr('value')}`,
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
                                url: `/selection-modal/<?php echo $show_filter; ?>/${$('#CarBrandSlug').attr('value')}/${$('#CarModelSlug').attr('value')}/${$('#CarGenerationSlug').attr('value')}`,
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
            < !-
                    -
                    $(function () {
                        $('#sel_submit').click(function () {
                            if ($('#CarBrandSlug').val() == 0 || $('#CarBrandSlug').val() == '') {
                                return false;
                            }
                        });
                    });
                //
                -- >
            </script>
        <?php } elseif ($show_filter == 5) { ?>
            <div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) {
                echo 'display: none';
            } ?>">
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
            <div class="filter-group" id="filter" style="<?php if (!empty($modification_slug)) {
                echo 'display: none';
            } ?>">
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

                    function loadSelectData(data, status) {
                        $.each(data, function (field_key, field_value) {
                            if (typeof (field_value) == 'object') {
                                var options = '<option value="0">Все</option>';
                                if (field_value.length == 0) {
                                    options = '<option value="0">---</option>';
                                }
                                var curr_select = $('select[name="' + field_key + '"]');
                                var curr_value = curr_select.find(':selected').val(),
                                    selected_added = false;
                                $.each(field_value, function (key, value) {
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
                            } else {
                                if (field_value == 0) {
                                    $('input[name="' + field_key + '"]').attr('disabled', 'disabled');
                                } else {
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
                } else {
                    $('.axis-select').hide();
                }
            }


            $(function () {

                function ksort(w) {
                    var sArr = [],
                        tArr = [],
                        n = 0;
                    for (i in w) {
                        tArr[n++] = i;
                    }
                    tArr = tArr.sort(function (a, b) {
                        return a - b;
                    });
                    for (var i = 0, n = tArr.length; i < n; i++) {
                        sArr[i] = w[tArr[i]];
                    }
                    return sArr;
                }

                $('select[name=auto]').change(function () {
                    $.ajax({
                        type: "GET",
                        url: "/tyres/auto?auto=" + $(this).val(),
                        dataType: 'json',
                        success: function (res) {
                            var options = '<option value="0">Все</option>';
                            res = ksort(res);
                            $.each(res, function (key, value) {
                                var selected = '';
                                options += '<option' + selected + ' value="' + key +
                                    '">' + value + '</option>';
                            });
                            $("select[name=size1] option").remove();
                            $("select[name=size1]").append(options);
                        }
                    });
                });



                $('#ProductAuto').change(auto_handler);
                auto_handler();
                <?php if (CONST_DISABLE_FILTERS == '0') { ?>
                    $('.filter-select').change(function () {
                        $('.filter-select').removeClass('changed');
                        $(this).addClass('changed');
                        $('.filter-select').each(function () {
                            if (!$(this).hasClass('changed')) {
                                var curr_value = $(this).find(':selected').val();
                                $(this).html('<option value="' + curr_value +
                                    '" selected>загрузка...</option>').attr('disabled', 'disabled');
                            }
                        });
                        $.get(
                            '/<?php echo $path; ?>/set_filter',
                            serializeArray($('#filter-form')),
                            loadSelectData,
                            'json'
                        );
                    });
                    $('.filter-checkbox').click(function () {
                        $('.filter-select').removeClass('changed');
                        $('.filter-select').each(function () {
                            var curr_value = $(this).find(':selected').val();
                            $(this).html('<option value="' + curr_value +
                                '" selected>загрузка...</option>').attr('disabled', 'disabled');
                        });
                        $.get(
                            '/<?php echo $path; ?>/set_filter',
                            serializeArray($('#filter-form')),
                            loadSelectData,
                            'json'
                        );
                    });
                    $('.filter-text').keypress(function () {
                        $('.filter-select').removeClass('changed');
                        $('.filter-select').each(function () {
                            var curr_value = $(this).find(':selected').val();
                            $(this).html('<option value="' + curr_value +
                                '" selected>загрузка...</option>').attr('disabled', 'disabled');
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
                    $('#ProductBoltType').change(function () {
                        var type = $(this).val();
                        if (type == 'ring') {
                            $('.bolt').show();
                            $('.valve').hide();
                            $('.ring').hide();
                            $('.size1 label').html('Внешний диаметр:');
                            $('.size2 label').html('Внутренний диаметр:');
                        } else if (type == 'valve') {
                            $('.bolt').hide();
                            $('.valve').show();
                        } else {
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
                form.find('input[type=text],select').each(function () {
                    var val = $(this).val();
                    ar[ar.length] = {
                        name: $(this).prop('name'),
                        value: val
                    };
                });
                form.find('input[type=checkbox]').each(function () {
                    ar[ar.length] = {
                        name: $(this).prop('name'),
                        value: $(this).prop('checked') ? 1 : 0
                    };
                });
                return ar;
            }

            function onSearchModifications() {
                const season = $('#AutoSelectionSeason').val();
                const disk_material = $('#AutoSelectionMaterial').val();
                const mod = $('#CarModificationSlug').attr('value');

                if (<?php echo $show_filter; ?> === 1) {
                    // tyres
                    window.location = `${origin}/tyres?modification=${mod}&season=${season ? season : ''}<?php if (!empty($size1)) {
                        echo '&size1=' . $size1;
                    } ?><?php if (!empty($size2)) {
                         echo '&size2=' . $size2;
                     } ?><?php if (!empty($size3)) {
                          echo '&size3=' . $size3;
                      } ?><?php echo '&diameter=' . $this->request->query['diameter']; ?>`;
                }
                if (<?php echo $show_filter; ?> === 2) {
                    // disks
                    window.location =
                        `${origin}/disks?modification=${mod}&material=${disk_material ? disk_material : ''}<?php echo '&diameter=' . $this->request->query['diameter']; ?>`;
                }
                if (<?php echo $show_filter; ?> === 3) {
                    // disks
                    window.location = `${origin}/akb?modification=${mod}`;
                }
            }

            //
            -- >
        </script>
        <?php if (CONST_SELECTION_WITH_MODALS == '1') { ?>
            <script type="text/javascript">
                    $('#CarBrandSlug').on('mousedown', function (e) {
                        e.preventDefault();
                        this.blur();
                        window.focus();
                    });
                $('#CarModelSlug').on('mousedown', function (e) {
                    e.preventDefault();
                    this.blur();
                    window.focus();
                });
                $('#CarGenerationSlug').on('mousedown', function (e) {
                    e.preventDefault();
                    this.blur();
                    window.focus();
                });
                $('#CarModificationSlug').on('mousedown', function (e) {
                    e.preventDefault();
                    this.blur();
                    window.focus();
                });
            </script>
        <?php } ?>
    </div>
</div>