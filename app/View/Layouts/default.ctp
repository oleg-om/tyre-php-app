<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

//$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php //echo $this->Html->charset(); ?>
	<title>Page not found
		<?php /*/echo $cakeDescription ?>:
		<?php //echo $title_for_layout; */?>
	</title>
	<?php
		//echo $this->Html->meta('icon');
		//echo $this->Html->css('cake.generic');
		//echo $this->fetch('meta');
		//echo $this->fetch('css');
		//echo $this->fetch('script');
	?>
<style>
	
body {
    color: #000;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    margin: 0;
    padding: 0;
}
	

#header {
    min-height: 140px;
    padding-bottom: 10px;
    position: relative;
}
#header {
    float: left;
    padding-bottom: 15px;
    padding-top: 15px;
    width: 100%;
}

#header .logo {
    padding-top: 0;
}
#header .logo {
    float: left;
}

#header .logo a {
    background-image: url("/img/kerchshina.png");
    background-repeat: no-repeat;
    display: block;
    float: left;
    height: 114px;
    margin-top: 2px;
    width: 281px;
}
a {
    color: #0066ff;
}


.errorBox {
    float: left;
    width: 100%;
}	
.error404 {
    background-color: #c8edff;
    color: #333333;
    float: left;
    font-size: 16px;
    font-weight: bold;
    padding: 5px 10px;
}



.errorBox h2 {
    float: left;
    font-size: 26px;
    font-weight: normal;
    margin: 0;
    padding: 10px 0 0;
    width: 100%;
}
.errorText {
    float: left;
    font-size: 16px;
    padding-top: 10px;
    width: 100%;
}



.conteiner {
    position: relative;
    width: 728px;
    margin: auto;
    width: 1230px;
}

.errorText a {
    font-size: 16px;
}
a {
    color: #0066ff;
}

#header .logo span {
    font-size: 11px;
    line-height: 15px;
    padding-top: 28px;
    width: 210px;
}
#header .logo span {
    color: #666666;
    display: block;
    float: left;
    font-size: 13px;
    line-height: 19px;
    padding-left: 15px;
    padding-top: 24px;
    width: 240px;
}

</style>	
</head>
<body>

<div class="conteiner">
	<div id="header">
		<div class="logo">
			<a href="/"></a>
		</div>
	</div>


	<div class="errorBox">
		<div class="error404">Ошибка 404</div>
		<h2>Страница не найдена</h2>
		<div class="errorText">Адрес страницы некоректный, либо такой страницы не существует<br><br><br>
			<a href="/">Вернуться на главную</a>
		</div>
	</div>
</div>


<?php /*
	<div id="container">
		<div id="header">
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">

			<?php //echo $this->Session->flash(); ?>

			<?php // echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php //echo $this->Html->link($this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),'http://www.cakephp.org/',array('target' => '_blank', 'escape' => false));?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	*/?>
</body>
</html>
