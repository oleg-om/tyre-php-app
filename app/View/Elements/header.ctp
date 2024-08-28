<?php 
if (empty($active_menu)) {
	$active_menu = 'home';
}
if (empty($current_season)) {
    $current_season = 'summer';
}
//$modification_slug = $this->request->query['modification'];
?>
<div id="header">
	<div class="tyres <?php echo $current_season; ?>-season">
		<div class="wrap header-wrapper">
            <div class="header-wrap">
                <a href="javascript:void(0);" onclick="switchToggle();" class="header-toggle">
                    <svg viewBox="0 0 100 80" width="40" height="40">
                        <rect width="100" height="10" fill="#FFFFFF"></rect>
                        <rect y="30" width="100" height="10" fill="#FFFFFF"></rect>
                        <rect y="60" width="100" height="10" fill="#FFFFFF"></rect>
                    </svg>
                </a>

			<div class="info-group">
                <a class="header-griffon" href="/"><img src="/img/griffon-sm.webp" alt="Керчьшина" /></a>
                <div class="desc"><span class="desc-title">КерчьШИНА</span><span class="desc-description">Сеть шинных центров</span></div>
				<div class="info">
					<?php echo CONST_ADDRESS; ?><br/>
					<?php echo CONST_PHONE; ?>
				</div>
			</div>
                <div class="logos">
                    <div class="logo logo__autodom"><img src="/img/kerchshina.png" alt="Шинный центр" /><span class="logo__years">25 лет</span></div>
                    <div class="logo logo__vianor"><img src="/img/vianor-logo.webp" alt="Vianor" /></div>
                </div>
			<div class="cart"><button onclick="window.location='/checkout';"><?php if (isset($cart) && !empty($cart['items'])) { ?><em id="checkout-count"><?php echo count($cart['items']); ?></em><?php } ?><span>Корзина</span></button></div>
            </div>
			<div id="nav" class="toggle__menu">
				<ul>
                    <?php $modification = $this->Session->read('car_modification_slug'); ?>
					<li<?php if ($active_menu == 'home') { ?> class="activ"<?php } ?>><a href="/">Главная</a></li>
					<li<?php if ($active_menu == 'tyres') { ?> class="activ"<?php } ?>><a href="/tyres<?php if (!empty($modification)) { echo '?modification='.$modification; } else { echo CONST_DEFAULT_TYRES_PATH; } ?>">Шины</a></li>
					<li<?php if ($active_menu == 'disks') { ?> class="activ"<?php } ?>><a href="/disks<?php if (!empty($modification)) { echo '?modification='.$modification; } else { echo CONST_DEFAULT_DISKS_PATH; } ?>">Диски</a></li>
					<li<?php if ($active_menu == 'akb') { ?> class="activ"<?php } ?>><a href="/akb<?php if (!empty($modification)) { echo '?modification='.$modification; } else { echo CONST_DEFAULT_AKB_PATH; } ?>">АКБ</a></li>
					<li<?php if ($active_menu == 'truck-tyres' || $active_menu == 'truck-disks') { ?> class="activ"<?php } ?>><a href="<?php echo '/tyres'.CONST_DEFAULT_TRUCK_TYRES_PATH; ?>">Грузовые авто</a></li>
					<li<?php if ($active_menu == 'selection') { ?> class="activ"<?php } ?>><a href="/selection">Подбор</a></li>
					<li<?php if ($active_menu == 'stations') { ?> class="activ"<?php } ?>><a href="/page-stations">Сервис</a></li>
					<li<?php if ($active_menu == 'contacts') { ?> class="activ"<?php } ?>><a href="/page-contacts">8 центров <span>(контакты)</span></a></li>
				</ul>
				<div class="clear"></div>
			</div>
            <img class="header-background" src="/img/tyres.v2.png" alt="Шины" />
		</div>
	</div>
    <script>
        var toggle = false;
        function switchToggle() {
            if (!toggle) {
                document.getElementById("nav").className = "toggle__menu-open";
                toggle = true
            } else {
                document.getElementById("nav").className = "toggle__menu";
                toggle = false
            }
        }
    </script>
</div>