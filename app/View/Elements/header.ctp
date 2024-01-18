<?php 
if (empty($active_menu)) {
	$active_menu = 'home';
}
if (empty($current_season)) {
    $current_season = 'summer';
}
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
			<div class="cart"><button onclick="window.location='/checkout';"><?php if (isset($cart) && !empty($cart['items'])) { ?><em><?php echo count($cart['items']); ?></em><?php } ?><span>Корзина</span></button></div>
            </div>
			<div id="nav" class="toggle__menu">
				<ul>
					<li<?php if ($active_menu == 'home') { ?> class="activ"<?php } ?>><a href="/">Главная</a></li>
					<li<?php if ($active_menu == 'tyres') { ?> class="activ"<?php } ?>><a href="/tyres<?php if (CONST_ENABLE_POPULAR_SORT != '1') { ?>?auto=cars<?php } ?>">Шины</a></li>
					<li<?php if ($active_menu == 'disks') { ?> class="activ"<?php } ?>><a href="/disks?material=cast">Диски</a></li>
					<li<?php if ($active_menu == 'akb') { ?> class="activ"<?php } ?>><a href="/akb">АКБ</a></li>
					<li<?php if ($active_menu == 'sales') { ?> class="activ"<?php } ?>><a href="/page-sales">Масла</a></li>
					<li<?php if ($active_menu == 'selection') { ?> class="activ"<?php } ?>><a href="/selection">Подбор</a></li>
					<li<?php if ($active_menu == 'stations') { ?> class="activ"<?php } ?>><a href="/page-stations">Сервис</a></li>
					<li<?php if ($active_menu == 'contacts') { ?> class="activ"<?php } ?>><a href="/page-contacts">8 центров</a></li>
				</ul>
				<div class="clear"></div>
			</div>
            <img class="header-background" src="/img/tyres.v1.png" alt="Шины" />
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