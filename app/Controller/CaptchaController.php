<?php
class CaptchaController extends Controller {
	var $name = 'Captcha';	
	var $uses = array();
	var $helpers = array();
	function index($key_name = '') {
		Configure::write('debug', 0);
		$this->layout = false;
		list($key,) = explode('.', $key_name);
		$code = '';
		$c_num_gensign = 4;
		$c_image_type = 'PNG';
		$c_width = 196;
		$c_height = 27;
		$c_font_size = intval($c_height / (($c_height/$c_width) * 20));
		$c_num_sign = intval(($c_width * $c_height) / 300);
		$path_fonts = APP . 'Controller' . DS . 'fonts' . DS;
		$letters = 'abcdefghjkmnpqrstuvwxyz23456789';
		for ($i = 0; $i < $c_num_gensign; $i ++) {
			$letter = $letters[mt_rand(0, strlen($letters) - 1)];
			$code .= $letter;
		}
		$this->Session->write('Captcha.code.' . $key, $code);
		$figures = array('50', '70', '90', '110');
		$src = imagecreatetruecolor($c_width, $c_height);
		$bg = imagecolorallocate($src, 255, 255, 255);
		imagefill($src, 0, 0, $bg);
		imagecolortransparent($src, $bg);
		$fonts = array();
		$dh = opendir($path_fonts);
		while ($file = readdir($dh)) {
			if ($file != '.' && $file != '..') {
				if (strtolower(strrchr($file, '.')) == '.ttf') $fonts[] = $path_fonts . $file;
			}
		}
		closedir($dh);
		if (sizeof($fonts) > 0) {
			for ($i = 0; $i < $c_num_sign; $i ++) {
				$h = 1;
				$color = imagecolorallocatealpha($src, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255), 90);
				$font = $fonts[mt_rand(0, sizeof($fonts) - 1)];
				$letter = $letters[mt_rand(0, strlen($letters) - 1)];
				$size = mt_rand($c_font_size - 2, $c_font_size + 2);
				$angle = mt_rand(0, 60);
				if ($h == mt_rand(1, 2)) $angle = mt_rand(300, 360);
				$r1 = $c_width - $c_width * 0.1;
				$r2 = $c_width * 0.1;
				imagettftext($src, $size, $angle, mt_rand(min($r1, $r2), max($r1, $r2)), mt_rand($c_height * 0.2, $c_height), $color, $font, $letter);
			}
			for ($i = 0; $i < $c_num_gensign; $i ++) {
				$h = 1;
				$color = imagecolorallocatealpha($src, $figures[mt_rand(0, sizeof($figures) - 1)], $figures[mt_rand(0, sizeof($figures) - 1)], $figures[mt_rand(0, sizeof($figures) - 1)], mt_rand(0, 10));
				$font = $fonts[mt_rand(0, sizeof($fonts) - 1)];
				$letter = $code[$i];
				$size = mt_rand($c_font_size * 2.1 - 1, $c_font_size * 2.1 + 1);
				$x = (empty($x)) ? $c_width * 0.08 : $x + ($c_width * 0.8) / $c_num_gensign + mt_rand(0, $c_width * 0.01);
				$y = ($h == mt_rand(1, 2)) ? (($c_height * 3.45) / 4) + mt_rand(0, $c_height * 0.02) : (($c_height * 3.45) / 4) - mt_rand(0, $c_height * 0.02);
				$angle = mt_rand(5, 20);
				if ($h == mt_rand(0, 5)) $letter = strtoupper($letter);
				if ($h == mt_rand(1, 2)) $angle = mt_rand(340, 355);
				imagettftext($src, $size, $angle, $x, $y, $color, $font, $letter);
			}
		}
		else {
			for($x=0;$x<$c_width;$x++) {
				for($i=0;$i<($c_height*$c_width)/1000;$i++) {
					$color = imagecolorallocatealpha($src, $figures[mt_rand(0, sizeof($figures)-1)], $figures[mt_rand(0, sizeof($figures)-1)], $figures[mt_rand(0, sizeof($figures)-1)], mt_rand(10, 30));
					imagesetpixel($src, mt_rand(0, $c_width), mt_rand(0, $c_height), $color);
				}
			}
			unset($x, $y);
			for($i=0;$i<$c_num_gensign;$i++){
				$h = 1;
				$color = imagecolorallocatealpha($src, $figures[mt_rand(0, sizeof($figures)-1)], $figures[mt_rand(0, sizeof($figures)-1)], $figures[mt_rand(0, sizeof($figures)-1)], mt_rand(10, 30));
				$letter = $code[$i];
				$x = (empty($x)) ? $c_width*0.08 : $x + ($c_width*0.8)/$c_num_gensign+mt_rand(0, $c_width*0.01);
				$y = ($h == mt_rand(1, 2)) ? (($c_height*1)/4) + mt_rand(0, $c_height*0.1) : (($c_height*1)/4) - mt_rand(0, $c_height*0.1);
				if ($h == mt_rand(0, 10)) $letter = strtoupper($letter);
				imagestring($src, 5, $x, $y, $letter, $color);
			}
		}
		header('Cache-Control: private, max-age=0, pre-check=10800');
		if ($c_image_type == 'PNG') {
			header('Content-type: image/png');
			imagepng($src);
		}
		elseif($c_image_type == 'JPEG') {
			header("Content-type: image/jpeg");
			imagejpeg($src);
		}
		else {
			header("Content-type: image/gif");
			imagegif($src);
		}
		imagedestroy($src);
		$this->render(false);
	}
}
?>