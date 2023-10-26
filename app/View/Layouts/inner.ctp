<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title><?php echo h($meta_title); ?></title>
<?php
echo $this->Html->meta('keywords', $meta_keywords);
echo $this->Html->meta('description', $meta_description);
?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<?php
	$css = array('main-v3');
	if (isset($additional_css)) {
		$css = array_merge($css, $additional_css);
	}
	echo $this->Html->css($css);
	$js = array('jquery.min', 'selectboxes');
	if (isset($additional_js)) {
		$js = array_merge($js, $additional_js);
	}
	echo $this->Html->script($js);
?>
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<meta content="telephone=no" name="format-detection" />
</head> 
<body>
<?php
if (!isset($show_left_menu)) {
	$show_left_menu = true;
}
if (!isset($show_right_menu)) {
	$show_right_menu = true;
}
?>
<?php echo $this->element('header'); ?>
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

		<div class="clear"></div>
	</div>
	<div id="footer">
		<?php echo date('Y'); ?> &copy Кerchshina.com — шинный центр г. Керчь
	</div>
</div>
<?php
	echo $this->element('sql_dump');
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34557894-1']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter28781221 = new Ya.Metrika({
                    id:28781221,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                }

);
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); }

;
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        }

 else { f(); }

    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/28781221" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t57.15;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet-->
</body>
</html>