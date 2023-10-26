<?php 
if (empty($active_menu)) {
	$active_menu = 'home';
}
?>
<div id="header">
	<div class="tyres">
		<div class="wrap">
			<div class="logo"><a href="/"><img src="/img/kerchshina.png" alt="Шинный центр" /></a></div>
			<div class="info-group">
				<div class="desc">Шинный центр</div>
				<div class="info">
					<?php echo CONST_ADDRESS; ?><br/>
					<?php echo CONST_PHONE; ?>
				</div>
			</div>
			<div class="cart"><button onclick="window.location='/checkout';"><?php if (isset($cart) && !empty($cart['items'])) { ?><em><?php echo count($cart['items']); ?></em><?php } ?><span>Корзина</span></button></div>
			<div class="clear"></div>
			<div id="nav">
				<ul>
					<li<?php if ($active_menu == 'home') { ?> class="activ"<?php } ?>><a href="/">Главная</a></li>
					<li<?php if ($active_menu == 'tyres') { ?> class="activ"<?php } ?>><a href="/tyres?auto=cars">Шины</a></li>
					<li<?php if ($active_menu == 'disks') { ?> class="activ"<?php } ?>><a href="/disks?material=cast">Диски</a></li>
					<li<?php if ($active_menu == 'akb') { ?> class="activ"<?php } ?>><a href="/akb">АКБ</a></li>
					<li<?php if ($active_menu == 'sales') { ?> class="activ"<?php } ?>><a href="/page-sales">Масла</a></li>
					<li<?php if ($active_menu == 'selection') { ?> class="activ"<?php } ?>><a href="/selection">Подбор</a></li>
					<li<?php if ($active_menu == 'stations') { ?> class="activ"<?php } ?>><a href="/page-stations">Сервис</a></li>
					<li<?php if ($active_menu == 'contacts') { ?> class="activ"<?php } ?>><a href="/page-contacts">Контакты</a></li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>