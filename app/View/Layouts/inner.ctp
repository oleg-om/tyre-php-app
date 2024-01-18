<!DOCTYPE html>
<html lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title><?php echo h($meta_title); ?></title>
<?php
echo $this->Html->meta('keywords', $meta_keywords);
echo $this->Html->meta('description', $meta_description);
?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<?php
	$css = array('main-style.v1', 'main-style-media.v1');
	if (isset($additional_css)) {
		$css = array_merge($css, $additional_css);
	}
	echo $this->Html->css($css);
	$js = array('jquery.min', 'selectboxes.v1');
	if (isset($additional_js)) {
		$js = array_merge($js, $additional_js);
	}
	echo $this->Html->script($js);
?>
<meta content="telephone=no" name="format-detection" />
</head> 
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T2BRRZ3N"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
if (!isset($show_left_menu)) {
	$show_left_menu = true;
}
if (!isset($show_right_menu)) {
	$show_right_menu = false;
}
?>
<?php echo $this->element('header'); ?>
<?php echo $this->element('breadcrumbs'); ?>
<div class="wrap">
	<?php
		echo $this->element('filter');

	?>
	<div class="content<?php echo $show_left_menu ? '' : ' no-left'; ?><?php echo $show_right_menu ? '' : ' no-right'; ?>">
		<?php
			if ($show_left_menu) {
				echo $this->element('left_menu');
			}
		?>
		<div class="center-content"><?php echo $content_for_layout; ?></div>
        <?php
        if ($show_right_menu) {
            echo $this->element('right');
        }
        ?>
		<div class="clear"></div>
	</div>
	<div id="footer">
		<?php echo date('Y'); ?> &copy Кerchshina.com — шинный центр г. Керчь
	</div>
</div>
<?php
	echo $this->element('sql_dump');
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2BRRZ3N');</script>
<!-- End Google Tag Manager -->
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(95593459, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/95593459" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>