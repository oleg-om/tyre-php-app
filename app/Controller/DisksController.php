<?php
class DisksController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array();
	
	public $prod=array('в наличии'=>1,'под заказ'=>0);
	
	public $filter_fields = array('Product.id' => 'int', 'Product.brand_id' => 'int', 'Product.model_id' => 'int', 'Product.sku' => 'text', 'Product.supplier_id' => 'int');
	public $model = 'Product';
	public $submenu = 'products';
	public $conditions = array('Product.category_id' => 2);
	public function _list() {
		parent::_list();
		$this->loadModel('Supplier');
		$this->set('suppliers', $this->Supplier->find('list', array('fields' => array('Supplier.id', 'Supplier.title'), 'order' => array('Supplier.title' => 'asc'))));
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 2))));
		if (isset($this->request->data['Product']['brand_id'])) {
			$this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_all_items')));
		}
		$this->set('all_models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'order' => array('BrandModel.title' => 'asc'), 'conditions' => array('BrandModel.category_id' => 2))));
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 2))));
		if (isset($this->request->data['Product']['brand_id'])) {
			$this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_any_items')));
		}
		return $title;
	}
	public function admin_apply() {
		$filter = $this->redirectFields($this->model, null);
		$this->loadModel($this->model);
		if (!empty($this->request->data) && isset($this->request->data[$this->model])) {
			foreach ($this->request->data[$this->model] as $id => $item) {
				if (isset($item['price'])) {
					$save_data = array(
						'price' => $item['price'],
						'stock_count' => $item['stock_count']
					);
					$this->{$this->model}->id = $id;
					$this->{$this->model}->save($save_data, false);
				}
			}
			$this->info($this->t('message_data_saved'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function admin_stockon($id = 0) {
		$this->_stock($id, 1);
	}
	public function admin_stockoff($id = 0) {
		$this->_stock($id, 0);
	}
	private function _stock($id, $state) {
		Configure::write('debug', 2);
		$this->layout = 'switcher';
		$this->set('id', $id);
		$this->set('url', '/admin/' . Inflector::underscore($this->name) . '/');
		$this->set('icon', 'stock');
		$this->set('url_enabled', 'stockon');
		$this->set('url_disabled', 'stockoff');
		$this->set('title_enabled', $this->t('title_stockon'));
		$this->set('title_disabled', $this->t('title_stockoff'));
		$this->set('prefix', 'stock');
		$this->loadModel($this->model);
		$this->{$this->model}->id = $id;
		if ($this->{$this->model}->saveField('in_stock', $state, false)) {
			$this->set('status', $state);
		}
		else {
			$this->set('status', abs($state - 1));
		}
		$this->render(false);
	}
	public function admin_clear() {
		$this->loadModel($this->model);
		$this->{$this->model}->deleteAll($this->conditions, true, true);
		$this->{$this->model}->query('UPDATE brands SET products_count=0,active_products_count=0 WHERE category_id=2');
		$this->{$this->model}->query('UPDATE brand_models SET products_count=0,active_products_count=0 WHERE category_id=2');
		$this->info($this->t('message_data_cleared'));
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$this->redirect($url);
	}
	
	
	function sett_var($var){
		$this->loadModel('Settings');
		$sett = $this->Settings->find('all', array(
			'fields' => array('Settings.variable','Settings.value'),
			'conditions' => array(
				'or' =>  array(
					array('Settings.variable' => $var),
				)
			)
		));
		//print_r($sett[]);
		return $sett[0]['Settings']['value'];
		
	}

	
	
	
	
	

	
	
	
		public function ttt2() {
	/*	
    [width] => 173
    [height] => 225
    [length] => 260
    [ah_from] => 90
    [ah_to] => 120
    [current] => 1075
    [f1] => L+
    [f2] => Euro
*/
	
		
	$th1=$this->CarBrand->query("SELECT * FROM car_brands WHERE title='".$key1."'");
	$th2=$this->CarModel->query("SELECT * FROM car_models WHERE brand_id='".$th1[0]['car_brands']['id']."' AND title='".$key2."'");
	$th3=$this->CarModification->query("SELECT * FROM car_modifications WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$th2[0]['car_models']['id']."' AND title='".$key4."'");
	$th4=$this->Car->query("SELECT * FROM cars WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$th2[0]['car_models']['id']."' AND modification_id='".$th3[0]['car_modifications']['id']."' AND year='".$key3."'");
	
	
	
	if(empty($th1)||empty($th2)||empty($th3)||empty($th4)):
	
		//$page = file_get_contents('http://luxshina.ua/cars/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key1))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key2))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key3))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key4))).'/');

		$page = file_get_contents('http://luxshina.ua/cars/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key1))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key2))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key3))).'/');
		

		$out=array();
		preg_match_all('|<li class="cars-modifiers__item">[^<]*<a[^>]+>(.*)</a>[^<]*</li>|U',$page,$out);
		if($out[1]):
			echo "***";
				$key4 = str_replace(" ","",mb_strtolower($key4));
				$key4 = str_replace(",","",mb_strtolower($key4));
				$key4 = str_replace(".","",mb_strtolower($key4));
				
				foreach ($out[1] as $o):
					$o = str_replace(" ","",mb_strtolower($o));
					$o = str_replace(",","",mb_strtolower($o));
					$o = str_replace(".","",mb_strtolower($o));
					echo"<br> --- ".$o."----".$key4;
				endforeach;
				
			echo "***";
		endif;
		
		
		
			if(empty($th1)):
				echo"<br><br><b>".$key1." -  в базе нет, возможно будет добавлено</b>";
			else:
				echo"<br><br>".$key1." - уже есть";
			endif;
			if(empty($th2)):
				echo"<br><b>".$key2." - в базе нет, возможно будет добавлено</b>";
			else:
				echo"<br>".$key2." - уже есть";
			endif;
			if(empty($th3)):
				echo"<br><b>".$key4." - в базе нет, возможно будет добавлено</b>";
			else:
				echo"<br>".$key4." - уже есть";
			endif;
		
			if(empty($th4)):
				echo"<br><b>".$key3." -  в базе нет, возможно будет добавлено</b>";
			else:
				echo"<br>".$key3." - уже есть";
			endif;
		
			echo'<br><br><b>Сайт:</b>http://luxshina.ua/cars/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key1))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key2))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key3))).'/'.str_replace('.','-',str_replace(" ","-",mb_strtolower($key4))).'/';		
		
		
		
		if(!empty($page)):
		
			
			
			echo "***";
			//print_r($page);
			echo "***";
			exit();
		else:
			//echo "<br>Такой странници нет!!!";
		endif;

		
		
		
		//echo'<br><br><b>Сайт:</b>http://www.r20.com.ua/index.php?search=1&auto=&brand_auto='.str_replace(" ","+",$key1).'&model_auto='.str_replace(" ","+",$key2).'&year_auto='.str_replace(" ","+",$key3).'&mod_auto='.str_replace(" ","+",$key4).'&auto=';
		//$page = file_get_contents('http://www.r20.com.ua/index.php?search=1&auto=&brand_auto='.str_replace(" ","+",$key1).'&model_auto='.str_replace(" ","+",$key2).'&year_auto='.str_replace(" ","+",$key3).'&mod_auto='.str_replace(" ","+",$key4).'&auto=');
	
		//$out=array();
		//preg_match_all('|<h1 class="page-not-found__header">404. Страница не найдена</h1>|',$page,$out);
		
		
		
		
	endif;	
	
	
	
	
	
	
	
	/*	
	echo"<br>1 --- ".$key1;
	echo"<br>1 --- ".$key2;
	echo"<br>1 --- ".$key3;
	echo"<br>1 --- ".$key4;
	*/
	/*
	
	echo'<br><b>Сайт:</b>http://akkumulyator.kh.ua/passanger/'.str_replace(" ","+",$key1).'/'.str_replace(" ","+",$key2).'/'.str_replace(" ","+",$key4).'/'.str_replace(" ","+",$key3).'/';
	//$page = file_get_contents('http://akkumulyator.kh.ua/passanger/'.str_replace(" ","+",$key1).'/'.str_replace(" ","+",$key2).'/'.str_replace(" ","+",$key4).'/'.str_replace(" ","+",$key3).'/');
	$page = file_get_contents('http://akkumulyator.kh.ua/passanger/'.$key1.'/'.$key2.'/'.$key4.'/'.$key3.'/');

	preg_match_all('|<p class="bigfut">(Ошибка)</p>|',$page,$out);
	//print_r($out);
	
	if (empty($out)):
		//print_r($page);
		echo"<br>------";
		exit();
	endif;
	
	*/
	
	
	
	
		
		//preg_match_all("|<h4 class=\'shin_title\'>(.*)</h4><div class=\'option\'>(.*)<ul>(.*)</ul></div>[<div class=\'option\'>(.*)<ul>(.*)</ul></div>]*[<div class=\'option\'>(.*)<ul>(.*)</ul></div>]*(.*)<h4 class=\'disk_title\'>(.*)</h4>[<div class=\'option\'>(.*)<ul>(.*)</ul></div>]*[<div class=\'option\'>(.*)<ul>(.*)</ul></div>]*[.*<div class=\'option\'>(.*)<ul>(.*)</ul></div>]*|U",$page,$out, PREG_SET_ORDER);
		//preg_match_all('|<div class="left_block"><h4[^>]+>(.*?)</h4>[<div class=\'option\'><div[^>]+>(.*?)</div>(.*?)</div>]+</div>|',$page,$out);
		//print_r($out);
		
		/*
		$out2 = array();
		preg_match_all('|<div class=\'left_block\'>(.*)</div><div class=\'right_block\'>|',$page,$out);
		preg_match_all("|<div class=\'option\'><div class=\'option_title\'>(.*)?</div>(.*)?</div>|U",$page,$out2);
		preg_match_all("|<div class=\'right_block\'>(.*)</div></div></div>|U",$page,$out3);
		*/
		
		
		//print_r($out[0][0]);
		
		
		
		/*
		$out1 = array();
		
		for($i=0;$i<count($out2[0]);$i++):
			$out2[2][$i] = str_ireplace("<div class='option_c'>",'',$out2[2][$i]);
			
			if(!empty($out2[2][$i])):
				$stor='';
				if(strstr($out[0][0],$out2[2][$i])):
					//echo "<br>Левый -- ".iconv('windows-1251',"utf-8",$out2[1][$i])."".$out2[2][$i]."";
					$stor='left';
					//$out_= 
				elseif(strstr($out3[0][0],$out2[2][$i])):
					$stor='right';
					//echo "<br>Правый -- ".iconv('windows-1251',"utf-8",$out2[1][$i])."".$out2[2][$i]."";
					//$out_=
				endif;
				
				if(strstr(iconv('windows-1251',"utf-8",$out2[1][$i]),'Общие параметры дисков')):
					if($stor=='left'):
						$out4[0]=$out2[2][$i];
					elseif($stor=='right'):
						$out4[3]=$out2[2][$i];
					endif;	
				elseif(strstr(iconv('windows-1251',"utf-8",$out2[1][$i]),'заводская комплектация')):
					if($stor=='left'):
						$out4[1]=$out2[2][$i];
					elseif($stor=='right'):
						$out4[4]=$out2[2][$i];
					endif;	
				elseif(strstr(iconv('windows-1251',"utf-8",$out2[1][$i]),'варианты замены')):
					if($stor=='left'):
						$out4[2]=$out2[2][$i];
					elseif($stor=='right'):
						$out4[5]=$out2[2][$i];
					endif;	
				endif;
			endif;
		endfor;
		*/
		
		/*
		if(!empty($out4)):
			//print_r($out4);
			$out3 = array();
			foreach($out4 as $key => $o):
				$out2 = array();
				preg_match_all("|<a[^>]+>(.*)</a>|U",$o,$out2, PREG_SET_ORDER);
				
				if(!empty($out2)):
				
					foreach($out2 as $o2):
						$out3[$key][]=$o2[1];
					endforeach;
				elseif(!empty($o)&&strstr($o,'PCD')):
					$o2 = explode(";",iconv('windows-1251',"utf-8",$o));
					$out3[$key] = array();
					foreach($o2 as $o):
						$out3[$key][] = explode(":",$o);
					endforeach;
					//print_r($out3[$key]);
				endif;
			endforeach;
		endif;	
		*/
		
		
		
		/*
		preg_match_all("|<div class=\'option_c\'>(.*)</div>|U",iconv('windows-1251',"utf-8",$out[0][8]),$o);
		$o2 = explode(";",$o[1][0]);
		$out3[4] = array();
		foreach($o2 as $key => $o):
			$out3[4][] = explode(":",$o);
		endforeach;
			
				
				
				//echo "------";
				//print_r($out2);
				//echo "------";
			endforeach;
		endif;
		*/
		/*
		echo "-------------";
		print_r($out3);
		echo "-------------";
		*/
		
	//	preg_match_all("|<div class="option_c">(.*)</div>[<div class=\'option\'>(.*)<ul>(.*)</ul></div>]*|U",$page,$out, PREG_SET_ORDER);
	
		//print_r(iconv("utf-8",'windows-1251',$out2[0]));
		//print_r(iconv('windows-1251',"utf-8",$out[0][0]));
		
		//if(!empty($out)):
			//echo "<br>1-----";
		/*
			if(empty($out[0][8])):
				preg_match_all("|<div class=\'option_c\'>(.*)</div>.*<div class=\'option\'>.*<ul>(.*)</ul></div>|U",$page,$out2, PREG_SET_ORDER);
				//print_r($out2[0][0]);
				
				$out[0][8]=$out2[0][0];
				$out[0][9]=$out2[0][2];
				
				//echo "<br>1-----";
				//print_r($out[0][5]);
				//echo "<br>2-----";
				
				
			endif;
		*/
			/*foreach($out2[0] as $o):
			
		/*echo "<br><br> 1----- ";
		print_r(iconv('windows-1251',"utf-8",$o));
		echo "<br> 2----- ";
		print_r(iconv('windows-1251',"utf-8",$out[0][0]));
		echo "<br> 3----- ";
			*/
				//print_r(iconv('windows-1251',"utf-8",$o));
				//if (strstr(iconv("utf-8",'windows-1251','заводская комплектация'),$o)):
				
				/*
				if(strstr($o,$out[0][0])):
						print_r(iconv('windows-1251',"utf-8",$o));
				endif;* /
				
			endforeach;*/
			/*
			$out1[]=$out[0][3];
			$out1[]=$out[0][5];
			$out1[]=$out[0][9];
			$out1[]=$out[0][11];
			*/
			
			
		/*else:
			//echo "<br>-----";
			$out=array();
			preg_match_all("|<h4 class=\'shin_title\'>(.*)</h4><div class=\'option\'>(.*)[<ul>(.*)</ul>]*[<div class=\'option_c\'>(.*)</div>]*</div>(.*)<h4 class=\'disk_title\'>(.*)</h4><div class=\'option\'>(.*)[<ul>(.*)</ul>]*[<div class=\'option_c\'>(.*)</div>]*</div>|U",$page,$out, PREG_SET_ORDER);
			$out1[]=$out[0][3];
			$out1[]=array();
			$out1[]=$out[0][7];
			$out1[]=array();
			$out[0][8]=$out[0][6];
			//print_r($out1);*/
	//	endif;
		
		//print_r($out1);
		/*
		$j=-1;
		foreach($out1 as $o):
			$out2 = array();
			preg_match_all("|<a[^>]+>(.*)</a>|U",$o,$out2, PREG_SET_ORDER);
			
			//print_r($out2);
			
			$j++;
			$out3[$j]=array();
			if(!empty($out2)):
				foreach($out2 as $o2):
					$out3[$j][]=$o2[1];
				endforeach;
			elseif(empty($out2)&&!empty($o)&&strstr('PCD',$o)):
				$out3[$j][] = $o;
			endif;
		endforeach;
		*/
		
		
			/*								
		preg_match_all("|<div class=\'option_c\'>(.*)</div>|U",iconv('windows-1251',"utf-8",$out[0][8]),$o);
		$o2 = explode(";",$o[1][0]);
		$out3[4] = array();
		foreach($o2 as $key => $o):
			$out3[4][] = explode(":",$o);
		endforeach;
			*/								

			
			
		/*	
		if((empty($th1)||empty($th2)||empty($th3)||empty($th4))&&(!empty($out3[1])||!empty($out3[2])||!empty($out3[3])||!empty($out3[4])||!empty($out3[5]))):
				
			echo"<br><br><u><b>Параметры шин</b></u>";
			
			echo"<br><u>заводская комплектация:</u>";
			echo"<ul style='margin:0px;'>";
			$str1='';
			foreach($out3[1] as $o):
				echo"<li>".$o."</li>";
				$str1.=$o;
				if(end($out3[1])!=$o[0])	$str1.="|";
			endforeach;
			echo"</ul>";
												
			//print_r($out3[1]);
			
			echo"<u>варианты замены:</u>";
			$str2='';
			if(!empty($out3[2])):
			echo"<ul style='margin:0px;'>";
			foreach($out3[2] as $o):
				echo"<li>".$o."</li>";
				$str2.=$o;
				if(end($out3[2])!=$o)
				$str2.="|";
			endforeach;
			echo"</ul>";
			else:
				echo" Записи нет";
			endif;
			
		
			echo"<br><u><b>Параметры дисков</b></u>";
			echo"<br><u>Общие параметры дисков:</u>";
											
			foreach($out3[3] as $o):
				if(!empty($o[0])&&($o[1]))
					echo"<li><b>".$o[0].":</b>".$o[1]."</li>";
				endforeach;
												
				//print_r($out3[4]);
				echo"<br><u>заводская комплектация:</u>";
				echo"<ul style='margin:0px;'>";
				$str3='';
				foreach($out3[4] as $o):
												echo"<li>".$o."</li>";
												$str3.=$o;
												if(end($out3[4])!=$o)
												$str3.="|";
												
											endforeach;
											echo"</ul>";
											echo"<u>варианты замены:</u>";
											
											if(!empty($out3[5])):
											echo"<ul style='margin:0px;'>";
											$str4='';
											foreach($out3[5] as $o):
												echo"<li>".$o."</li>";
												$str4.=$o;
												if(end($out3[5])!=$o)
												$str4.="|";
												
											endforeach;
											echo"</ul>";
											else:
											echo"Записи нет";
											endif;
		
		
											
											
													
										
		
		if(empty($th4)):
			//$this->Car->query("INSERT INTO cars (`brand_id`, `model_id`, `modification_id`, `is_active`, `year`, `pcd`, `diameter`, `nut`, `factory_tyres`, `replace_tyres`, `factory_disks`, `replace_disks`) VALUES ('".$th1[0]['car_brands']['id']."', '".$th2[0]['car_models']['id']."', '".$th3[0]['car_modifications']['id']."', '1','".$key3."','".$out3[4][0][1]."','".$out3[4][1][1]."','".$out3[4][2][0].": ".$out3[4][2][1]."','".$str1."','".$str2."','".$str3."','".$str4."')");
			echo "<br><b>INSERT INTO cars (`brand_id`, `model_id`, `modification_id`, `is_active`, `year`, `pcd`, `diameter`, `nut`, `factory_tyres`, `replace_tyres`, `factory_disks`, `replace_disks`) VALUES ('".$th1[0]['car_brands']['id']."', '".$th2[0]['car_models']['id']."', '".$th3[0]['car_modifications']['id']."', '1','".$key3."','".trim($out3[3][0][1])."','".trim($out3[3][1][1])."','".trim($out3[3][2][1])."','".$str1."','".$str2."','".$str3."','".$str4."')</b>";
			echo "<br><br><b>Проверить:</b> http://shina.cc/selection/view?brand_id=".$th1[0]['car_brands']['id']."&model_id=".$th2[0]['car_models']['id']."&year=".$key3."&mod=".$th3[0]['car_modifications']['id']."<br><br>";
		endif;

		endif;	
		echo "<hr>";
			*/
	}

	
	public function F1ttt2_() {
		
		$th1=$this->CarBrand->query("SELECT * FROM car_brands ORDER BY title asc");
		
			$_SESSION['mas']=array();
			$i=0;
			$m['ваз']='vaz';
			$m['газ']='gaz';
			$m['тагаз']='tagaz';
			$m['уаз']='uaz'; 

			foreach($th1 as $t):$i++;
				$str=str_replace(" ","-",mb_strtolower($t['car_brands']['title']));
				$str=str_replace('.','-',$str);
				$str=str_replace(',','-',$str);
				
				$out=array();
				//echo"<br><br><br>--- ".$str;
				if(!empty($m[$str])) $str=$m[$str];
				echo"<br>".$i." --- ".$str;
				
			
				$page = file_get_contents('http://luxshina.ua/cars/'.$str.'/');
				preg_match_all('|<li class="cars-models__item">[^<]*<a[^>]+>(.*)</a>[^<]*</li>|U',$page,$out);
				if($out[1]):
					foreach ($out[1] as $str2):
						$str2 = str_replace(" ","-",mb_strtolower($str2));
						$str2 = str_replace(",","-",mb_strtolower($str2));
						$str2 = str_replace(".","-",mb_strtolower($str2));
					//	echo"<br><br> * ".$str2;
						
						$page = file_get_contents('http://luxshina.ua/cars/'.$str.'/'.$str2.'/');
						preg_match_all('|<li class="cars-years__item">[^<]*<a[^>]+>(.*)</a>[^<]*</li>|U',$page,$out2);
						
						if($out2[1]):
							foreach ($out2[1] as $str3):
								$str3 = str_replace(" ","-",mb_strtolower($str3));
								$str3 = str_replace(",","-",mb_strtolower($str3));
								$str3 = str_replace(".","-",mb_strtolower($str3));
								//echo"<br> - ".$str3;
								$_SESSION['mas'][$str][$str2][$str3]=1;
							endforeach;
						endif;
					endforeach;
				endif;
			
			endforeach;			
			
				
		}
	
		public function F2ttt2_() {

			$i=0;
//			print_r($_SESSION['mas']);
			
			foreach ($_SESSION['mas'] as $str => $v1):
			//echo"<br>--- ".$str;
				foreach ($v1 as $str2 => $v2):
					//echo"<br>* ".$str2;
					foreach ($v2 as $str3 => $v3):
						if($i>=9500&&$i<10000):
							//echo"<br> ------".$i;
							$page = file_get_contents('http://luxshina.ua/cars/'.$str.'/'.$str2.'/'.$str3.'/');
							//echo'<br>http://luxshina.ua/cars/'.$str.'/'.$str2.'/'.$str3.'/';
							
							preg_match_all('|<li class="cars-modifiers__item">[^<]*<a[^>]+>(.*)</a>[^<]*</li>|U',$page,$out3);
							if($out3[1]):
								//print_r($out3[1]);
								$_SESSION['mas'][$str][$str2][$str3]=array();
								foreach ($out3[1] as $str4):
									$str4 = str_replace(" ","-",mb_strtolower($str4));
									$str4 = str_replace(",","-",mb_strtolower($str4));
									$str4 = str_replace(".","-",mb_strtolower($str4));
									//$_SESSION['mas'][$str][$str2][$str3][$str4]=1;
									$_SESSION['mas'][$str][$str2][$str3][$str4]=1;
									
									//echo"<br> --> ".$str4;
								endforeach;
							endif;
						endif;
						$i++;
						
					endforeach;
					
				endforeach;
			endforeach;
		}
			
	
		
		
	public function Func3_(){
		$i=1;
		
		//print_r($_SESSION['mas2']);
		//exit();
		$_SESSION['mas2']=array();?>
		
		<table width="100%" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td valign="top" align="center"><b>#</b></td>
			<td valign="top" align="center"><b>Марка</b></td>
			<td valign="top" align="center"><b>Модель</b></td>
			<td valign="top" align="center"><b>Год выпуска</b></td>
			<td valign="top" align="center"><b>Объем двигателя</b></td>
			<td valign="top" align="center"><b>Характеристика</b></td>
		</tr>
		
		<?php $i=1;foreach ($_SESSION['mas'] as $key1 => $v1):
				foreach ($v1 as $key2 => $v2):
					foreach ($v2 as $key3 => $v3):
						foreach ($v3 as $key4 => $v1):$i++;if($i>=20000&&$i<25000):
							$page = file_get_contents('http://luxshina.ua/cars/'.$key1.'/'.$key2.'/'.$key3.'/'.$key4);
							preg_match_all('|<dl[^>]*>.*<dt[^>]*>(.*)</dt>.*<dd[^>]*>(.*)<ul[^>]*>(.*)</ul>.*</dd>.*</dl>|U',$page,$out,PREG_PATTERN_ORDER);
							
							$factory_tyres="";
							$replace_tyres="";
							$factory_disks="";
							$replace_disks="";
							$j=0;$z=0;
							$otchet= "";
							foreach($out[1] as $key => $o):
								$pcd='';
								$diameter='';
								$nut='';
								if(!empty($o)&&strstr($o,'Шины')):
									$j=1;
								endif;
								if(!empty($o)&&strstr($o,'Диски')):
									$j=2;
								endif;
								if(!empty($o)&&strstr($o,'заводская')&&strstr($o,'комплектация')):
									$z=1;
								endif;
								if(!empty($o)&&strstr($o,'замены')&&!empty($o)&&strstr($o,'варианты')):
									$z=2;
								endif;
								preg_match_all('|<li[^>]*>.*<a[^>]*>(.*)</a>.*</li>|U',$out[3][$key],$out1,PREG_PATTERN_ORDER);
								$tyr_disk='';
								foreach($out1[1] as $o2):
									$tyr_disk.=trim(strip_tags($o2));
									if(end($out1[1])!=$o2) $tyr_disk.="|";
								endforeach;
								$per='';
								if($j==1):
									$otchet.= ";<b>Шины</b>-";
									$per='_tyres';
								elseif($j==2):
									$otchet.= ";<b>Диски</b>-";
									$per='_disks';
								endif;
								if($z==1):
									$per='factory'.$per;
									$otchet.= "<b>Заводская комплектация</b>";
								elseif($z==2):
									$per='replace'.$per;
									$otchet.= "<b>Варианты замены</b>";
								endif;
									$otchet.= ";".$tyr_disk;
									${$per}=$tyr_disk;
								endforeach;
									preg_match_all('|<ul class=\"car-tire-disk__info-addition-list\">.*</ul>|U',$page,$out,PREG_PATTERN_ORDER);
									
								if($out1[0][0]):
									preg_match_all('|<li[^>]*>(.*)</li>|U',$out[0][0],$out1,PREG_PATTERN_ORDER);
									$otchet.=";<b>Диски</b>-<b>Общие характеристики:</b>";
									foreach($out1[1] as $o):
										$o1=explode(":",$o);
										if(strstr($o1[0],'PCD')):
											$pcd=$o1[1];
										elseif(strstr($o1[0],'DIA')):
											$diameter=$o1[1];
										elseif(strstr($o1[0],'Крепеж')):
											$nut=$o1[1];
										endif;
										$otchet.=";".$o1[0].":".trim(strip_tags($o1[1]));
									endforeach;
								endif;?>
						<tr>
							<td valign="top" align="center"><?php echo$i;?></td>
							<td valign="top" align="center"><?php echo$key1;?></td>
							<td valign="top" align="center"><?php echo$key2;?></td>
							<td valign="top" align="center"><?php echo$key3;?></td>
							<td valign="top" align="center"><?php echo$key4;?></td>
							<td valign="top" align="left"><?php echo$otchet;//echo$key4;?></td>
						</tr>
		<?php 
						endif;endforeach;	
					endforeach;	
				endforeach;	
		endforeach;
		
		
		
		 /*foreach ($_SESSION['mas'] as $key1 => $v1):
				$th1=$this->CarBrand->query("SELECT * FROM car_brands WHERE title='".$key1."'");
				$th2=$this->CarModel->query("SELECT * FROM car_models WHERE brand_id='".$th1[0]['car_brands']['id']."'");
				foreach ($th2 as $v2_):
					$th3=$this->CarModification->query("SELECT * FROM car_modifications WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$v2_['car_models']['id']."'");
					foreach ($th3 as $v3_):
						$th4=$this->Car->query("SELECT * FROM cars WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$v2_['car_models']['id']."' AND modification_id='".$v3_['car_modifications']['id']."'");
						foreach ($th4 as $v4_):?>
						<tr>
							<td valign="top" align="center"><?php echo$th1[0]['car_brands']['title'];?></td>
							<td valign="top" align="center"><?php echo$v2_['car_models']['title'];?></td>
							<td valign="top" align="center"><?php echo$v4_['cars']['year'];?></td>
							<td valign="top" align="center"><?php echo$v3_['car_modifications']['title'];?></td>
						</tr>
						
						<?php endforeach;
					endforeach;
				endforeach;
			endforeach;*/
			exit();
		?>
		</table>
		
		<?php foreach ($_SESSION['mas'] as $key1 => $v1):
			//if(!empty($m[$key1])) $key1=$m[$key1];
			
			$th1=$this->CarBrand->query("SELECT * FROM car_brands WHERE title='".$key1."'");
			//print_r($th1);
		//	echo"<br><br>1---".$key1;?>
				<?php foreach ($v1 as $key2 => $v2):?>
				<?php //echo$key2;?>
				
				
				<?php /*$str1 = str_replace("-","",mb_strtolower($key2));
				$th2=$this->CarModel->query("SELECT * FROM car_models WHERE brand_id='".$th1[0]['car_brands']['id']."'");
				//print_r($th2);
				
				foreach ($th2 as $v2_):
					
					$str2 = str_replace(" ","",mb_strtolower($v2_['car_models']['title']));
					$str2 = str_replace(",","",$str2);
					$str2 = str_replace(".","",$str2);
					
					//print_r($v2_['car_models']['title']);
					if($str1==$str2):
						$th3=$this->CarModification->query("SELECT * FROM car_modifications WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$v2_['car_models']['id']."'");
						foreach ($th3 as $v3_):
							//echo "<br> ----- ";
							//print_r($v3_['car_modifications']['title']);
							$str3 = str_replace(" ","",mb_strtolower($v3_['car_modifications']['title']));
							$str3 = str_replace(",","",$str3);
							$str3 = str_replace(".","",$str3);
							//echo "<br> ----- ".$str3;
							//echo "<br>222 --- ".$th1[0]['car_brands']['title'];
							//print_r($v2);*/
							foreach ($v2 as $key3 => $v3):
								//echo"<br>3---";
								//echo"<br>3---".$key3;
								foreach ($v3 as $key4 => $v4):
									//echo"<br>4---".$key4;
									?>
									<tr>
										<td valign="top" align="center"><?php echo$key1;?></td>
										<td valign="top" align="center"><?php echo$key2;?></td>
										<td valign="top" align="center"><?php echo$key3;?></td>
										<td valign="top" align="center"><?php echo$key4;?></td>
									</tr>
									<?php 
								/*	
								if(empty($_SESSION['mas2'][$key1][$key2][$key3][$key4])):
									//print_r($_SESSION['mas2']);
									//echo "<br>4 ----- ";
									$str4 = str_replace("-","",mb_strtolower($key4));
									
									if($str3==$str4):
										//echo "<br><br> 2----- ".$str4;
										$th4=$this->Car->query("SELECT * FROM cars WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$v2_['car_models']['id']."' AND modification_id='".$v3_['car_modifications']['id']."'");
										//print_r($th4);
										$str6 = str_replace("-","",mb_strtolower($key3));
										
										//echo "<br> --- ".$str6;
										foreach ($th4 as $v4_):
											$str5 = str_replace(" ","",mb_strtolower($v4_['cars']['year']));
											$str5 = str_replace(",","",$str5);
											$str5 = str_replace(".","",$str5);
											
											if($str5==$str6):
												if((empty($v4_['cars']['pcd'])||empty($v4_['cars']['diameter'])||empty($v4_['cars']['nut'])||empty($v4_['cars']['factory_tyres'])||empty($v4_['cars']['replace_tyres'])||empty($v4_['cars']['factory_disks'])||empty($v4_['cars']['replace_disks']))):
													if($i<=1):
													//echo "<br> ----- model_id:".$v2_['car_models']['id'];
													/****** Выборка данных ******** /
													$otchet= '<br>'.$i.'--------------------------';
													$otchet.= "<br><u><b>Категория</b></u><br>Производитель: ".$th1[0]['car_brands']['title'];
													$otchet.= "<br>Модель: ".$v2_['car_models']['title'];
													$otchet.= "<br>Модификация: ".$v3_['car_modifications']['title'];
													$otchet.= "<br>Год выпуска: ".$v4_['cars']['year']."<br>";
													$otchet.= '<br><u><b>Сайты</b></u><br>http://luxshina.ua/cars/'.$key1.'/'.$key2.'/'.$key3.'/'.$key4;
													$otchet.= '<br>http://kerchshina.com/selection/view?brand_id='.$th1[0]['car_brands']['id'].'&model_id='.$v2_['car_models']['id'].'&year='.$key3.'&mod='.$v3_['car_modifications']['id'];
													$page = file_get_contents('http://luxshina.ua/cars/'.$key1.'/'.$key2.'/'.$key3.'/'.$key4);
													preg_match_all('|<dl[^>]*>.*<dt[^>]*>(.*)</dt>.*<dd[^>]*>(.*)<ul[^>]*>(.*)</ul>.*</dd>.*</dl>|U',$page,$out,PREG_PATTERN_ORDER);
													$factory_tyres="";
													$replace_tyres="";
													$factory_disks="";
													$replace_disks="";
													$j=0;$z=0;
													$otchet.= "<br><br><u><b>Данные на сайте luxshina.ua:</b></u>";
													foreach($out[1] as $key => $o):
														$pcd='';
														$diameter='';
														$nut='';
														if(!empty($o)&&strstr($o,'Шины')):
															//echo "<br><b>Шины</b>";
															$j=1;
														endif;
														if(!empty($o)&&strstr($o,'Диски')):
															//echo "<br><b>Диски</b>";
															$j=2;
														endif;
														
														if(!empty($o)&&strstr($o,'заводская')&&strstr($o,'комплектация')):
															//echo "<br><b>Заводская комплектация</b>";
															$z=1;
														endif;
														
														if(!empty($o)&&strstr($o,'замены')&&!empty($o)&&strstr($o,'варианты')):
															//echo "<br><b>Варианты замены</b>";
															$z=2;
														endif;
														
														preg_match_all('|<li[^>]*>.*<a[^>]*>(.*)</a>.*</li>|U',$out[3][$key],$out1,PREG_PATTERN_ORDER);
														
														$tyr_disk='';
														foreach($out1[1] as $o2):
															$tyr_disk.=trim(strip_tags($o2));
															if(end($out1[1])!=$o2) $tyr_disk.="|";
														endforeach;
														$per='';
														if($j==1):
															$otchet.= "<br><b>Шины</b>-";
															$per='_tyres';
														elseif($j==2):
															$otchet.= "<br><b>Диски</b>-";
															$per='_disks';
														endif;
														if($z==1):
															$per='factory'.$per;
															$otchet.= "<b>Заводская комплектация</b>";
														elseif($z==2):
															$per='replace'.$per;
															$otchet.= "<b>Варианты замены</b>";
														endif;
														$otchet.= "<br>".$tyr_disk;
														${$per}=$tyr_disk;
													endforeach;
													preg_match_all('|<ul class=\"car-tire-disk__info-addition-list\">.*</ul>|U',$page,$out,PREG_PATTERN_ORDER);
													if($out1[0][0]):
														preg_match_all('|<li[^>]*>(.*)</li>|U',$out[0][0],$out1,PREG_PATTERN_ORDER);
														$otchet.="<br><b>Диски</b>-<b>Общие характеристики:</b>";
														foreach($out1[1] as $o):
															$o1=explode(":",$o);
															//echo "<br>".trim(strip_tags($o1[0])).":".trim(strip_tags($o1[1]));
															if(strstr($o1[0],'PCD')):
																$pcd=$o1[1];
															elseif(strstr($o1[0],'DIA')):
																$diameter=$o1[1];
															elseif(strstr($o1[0],'Крепеж')):
																$nut=$o1[1];
															endif;
															$otchet.="<br>".$o1[0].":".trim(strip_tags($o1[1]));
														endforeach;
													endif;
													/****** Выборка данных ******** /
													$Sql='';
													$sql='';
													//echo "<br> ----- ";
													if(!empty($factory_tyres)&&empty($v4_['cars']['factory_tyres'])):
														$Sql.=($sql2="UPDATE `cars` SET `factory_tyres`='".$factory_tyres."' WHERE `id`='".$v4_['cars']['id']."';");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														$Sql.="<br>";
													endif;	
													
													if(!empty($replace_tyres)&&empty($v4_['cars']['replace_tyres'])):
														$Sql.=($sql2="UPDATE `cars` SET `replace_tyres`='".$replace_tyres."' WHERE `id`='".$v4_['cars']['id']."';");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														$Sql.="<br>";
													endif;	
													
													if(!empty($factory_disks)&&empty($v4_['cars']['factory_disks'])):
														$Sql.=($sql2="UPDATE `cars` SET `factory_disks`='".$factory_disks."' WHERE `id`='".$v4_['cars']['id']."';");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														$Sql.="<br>";
													endif;

													if(!empty($replace_disks)&&empty($v4_['cars']['replace_disks'])):
														$Sql.=($sql2="UPDATE `cars` SET `replace_disks`='".$replace_disks."' WHERE `id`='".$v4_['cars']['id']."';");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														$Sql.="<br>";
													endif;	
													
													if(!empty($pcd)&&empty($v4_['cars']['pcd'])):
														$Sql.=($sql2="UPDATE `cars` SET `pcd`='".$pcd."' WHERE `id`='".$v4_['cars']['id']."';");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														$Sql.="<br>";
													endif;

													if(!empty($diameter)&&empty($v4_['cars']['diameter'])):
														//echo "<br> 3----- ";
														$Sql.=($sql2="UPDATE `cars` SET `diameter`='".$diameter."' WHERE `id`='".$v4_['cars']['id']."';");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														//echo "<br> 4----- ";
														$Sql.="<br>";
													endif;

													if(!empty($nut)&&empty($v4_['cars']['diameter'])):
														$Sql.=($sql2="UPDATE `cars` SET `nut`='".$nut."' WHERE `id`='".$v4_['cars']['id']."'");
														//$this->Car->query($Sql);
														$sql.=$sql2;
														$Sql.="<br>";
													endif;
														
													if(!empty($Sql)):
														//echo"<br>5555----".$sql."-----5555<br>";
														$this->Car->query($sql);
														echo $otchet."";
														echo"<br><br><u><b>Добавлены на сайт:</b></u><br>".$Sql."--------------------------<br>";
														$i++;
													endif;
												endif;
											elseif($i<=5):
												$_SESSION['mas2'][$key1][$key2][$key3][$key4]=1;
											endif;
											endif;
										endforeach;
										//exit();
									endif;
								
								endif;
								endforeach;
							endforeach;*/
						endforeach;
					//endif;
				endforeach;
				/*
				echo "<br><br> ----- ";
				print_r($th2);
				echo "<br> ----- ";
				*/
			endforeach;?>
		<?php endforeach;?>
		</table>
	<?php }
		
	
	
	public function ttt() {
		//include('per1.php');
		
		$this->loadModel("CarBrand");
		$this->loadModel("CarModel");
		$this->loadModel("CarModification");
		$this->loadModel("Car");
		
		echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo'<html lang="ru" xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"><title>Центр администрирования</title></head><body>';

		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td valign="top" align="center"><b>#</b></td>
			<td valign="top" align="center"><b>Марка</b></td>
			<td valign="top" align="center"><b>Модель</b></td>
			<td valign="top" align="center"><b>Год выпуска</b></td>
			<td valign="top" align="center"><b>Объем двигателя</b></td>
			<td valign="top" align="center"><b>Характеристика</b></td>
		</tr>
		
		<?php 
		$th1=$this->CarBrand->query("SELECT * FROM car_brands");
		$i=1;
		foreach ($th1 as $val1):
			$th2=$this->CarModel->query("SELECT * FROM car_models WHERE brand_id='".$val1['car_brands']['id']."'");
			foreach($th2 as $val2):
				$th3=$this->CarModification->query("SELECT * FROM car_modifications WHERE brand_id='".$val1['car_brands']['id']."' AND model_id='".$val2['car_models']['id']."'");
				foreach($th3 as $val3):
					$th4=$this->Car->query("SELECT * FROM cars WHERE brand_id='".$val1['car_brands']['id']."' AND model_id='".$val2['car_models']['id']."' AND modification_id='".$val3['car_modifications']['id']."'");
					foreach($th4 as $val4):?>
						<tr>
							<td valign="top" align="center"><?php echo$i++;?></td>
							<td valign="top" align="center"><?php echo$val1['car_brands']['title'];?></td>
							<td valign="top" align="center"><?php echo$val2['car_models']['title']; ?></td>
							<td valign="top" align="center"><?php echo$val4['cars']['year'];?></td>
							<td valign="top" align="center"><?php echo$val3['car_modifications']['title'];//echo$val4['car']['title'];?><?php //echo iconv('windows-1251','utf-8',$val4['arr4']); //echo$val4['arr4'];//echo$key4;?></td>
							<td valign="top" align="left">
								<?php if(!empty($val4['cars']['width'])&&!empty($val4['cars']['height'])&&!empty($val4['cars']['length'])):?>
								<b>Размер:</b>	<?php echo$val4['cars']['length'];?>x<?php echo$val4['cars']['width'];?>x<?php echo$val4['cars']['height'];?>; 
								<?php endif;
									 if(!empty($val4['cars']['ah_from'])&&!empty($val4['cars']['ah_to'])):?>
								<b>Емкость:</b>	от <?php echo$val4['cars']['ah_from'];?> Ач до <?php echo$val4['cars']['ah_to'];?> Ач;
								<?php endif;?>
								<?php if(!empty($val4['cars']['current'])):?>
								<b>Пусковой ток:</b> до <?php echo$val4['cars']['current'];?> А;
								<?php endif;?>
								<?php if(!empty($val4['cars']['f1'])):?>
								<b>Полярность:</b> <?php echo$val4['cars']['f1'];?>;
								<?php endif;?>
								<?php if(!empty($val4['cars']['f2'])):?>
								<b>Тип клемм:</b> <?php echo$val4['cars']['f2'];?>;
								<?php endif;?>

								
							
							<?php //print_r($val4)  //echo$str;?></td>
						</tr>
		
						
			<?php endforeach;
				endforeach;
			endforeach;
		endforeach;?>
		</table>
		
		
		<?php //print_r($th1);
		
		exit();
		
		//$fileName='array2.txt';
		//$fileName2='array3.txt';
		
		/*
		$th1=$this->CarBrand->query("SELECT * FROM car_brands WHERE title='".$key1."'");
	$th2=$this->CarModel->query("SELECT * FROM car_models WHERE brand_id='".$th1[0]['car_brands']['id']."' AND title='".$key2."'");
	$th3=$this->CarModification->query("SELECT * FROM car_modifications WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$th2[0]['car_models']['id']."' AND title='".$key4."'");
	$th4=$this->Car->query("SELECT * FROM cars WHERE brand_id='".$th1[0]['car_brands']['id']."' AND model_id='".$th2[0]['car_models']['id']."' AND modification_id='".$th3[0]['car_modifications']['id']."' AND year='".$key3."'");
	*/
		
	//	if(!($A = $this->CarBrand->find('first',array('conditions' => array('title' => $key1))))):
//		if(!($B = $this->CarModel->find('first',array('conditions' => array('title' => $key2,'brand_id' => $A['CarBrand']['id']))))):
//			 $C = $this->CarModification->find('first',array('conditions' => array('title' => $key4,'brand_id' => $A['CarBrand']['id'],'model_id' => $B['CarModel']['id']))))):	
		//   $D = $this->Car->find('first',array('conditions' => array('year' => $key3,'brand_id' => $A['CarBrand']['id'], 'model_id' => $B['CarModel']['id'], 'modification_id' => $C['CarModification']['id']))))):
		
		
		
		
		
		
		
		
		
		
		
		
		/**** извлекаем данные в массив ******/
		$file = fopen($fileName, 'r'); // открываем файл
		$str = "";
		while (($buffer = fgets($file, 128)) !== false) {
        	$str .= $buffer;
    	}
    	$array = unserialize($str); // преобразовываем строку в массив
    	/**** извлекаем данные в массив ******/
    	
    	//print_r($array);
    	//exit();
	
    	/**** извлекаем данные в массив ****** /
		$file = fopen($fileName2, 'r'); // открываем файл
		$str = "";
		while (($buffer = fgets($file, 128)) !== false) {
        	$str .= $buffer;
    	}
    	$array3 = unserialize($str); // преобразовываем строку в массив
    	//$array2 = array(); 
 	 	//$_SESSION['mas']=$array3;
    	/**** извлекаем данные в массив ******/
		
    	//$array2 = $array;
    	
    	//print_r($_SESSION['mas']);
    	//exit();
    	
    	/*
    	// ----- поиск - 1 элемент
		$page = file_get_contents('http://www.koleso-russia.ru/batteries/');
		preg_match_all('|<div class=\"sl-wrap\">(.*)<\/div><noindex>|U',$page,$out,PREG_SET_ORDER);
		$page=$out[0][0];
		$out=array();
		preg_match_all('|<a[^>]*href=\"(.*)[/]*\"[^>]*>(.*)</a>|U',$page,$out,PREG_SET_ORDER);
		foreach ($out as $val3):
		*/
    	
    	?>

    	<table width="100%" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td valign="top" align="center"><b>#</b></td>
			<td valign="top" align="center"><b>Марка</b></td>
			<td valign="top" align="center"><b>Модель</b></td>
			<td valign="top" align="center"><b>Год выпуска</b></td>
			<td valign="top" align="center"><b>Объем двигателя</b></td>
			<td valign="top" align="center"><b>Характеристика</b></td>
		</tr>
    	
    	
    	<?php 
    	$i=0;$t_n=122926;$t_k=123000;
    	ksort($array);
		foreach ($array as $key1=>$val1):if($i<$t_k): 
			//print_r($val1);
			//echo"<br>---".$key1;
			/*//----- поиск - 2 элемент
			$page = file_get_contents('http://www.koleso-russia.ru/batteries/'.$key1);
			preg_match_all('|<div class=\"sl-wrap\">(.*)<\/div><noindex>|U',$page,$out,PREG_SET_ORDER);
			$page=$out[0][0];
			$out=array();
			preg_match_all('|<a[^>]*href=\"(.*)[/]*\"[^>]*>(.*)</a>|U',$page,$out,PREG_SET_ORDER);
			foreach ($out as $val3):*/
			foreach ($val1 as $key2=>$val2):if($i<$t_k)://$i++;if($i>=3500&&$i<3600): 
				//echo"---".$key2;
				//$array2[$key1][$val3[1]]=array('arr1'=>$key1,'arr2'=>$val3[2]);
				/*$page = file_get_contents('http://www.koleso-russia.ru/batteries/'.$key1.'/'.$key2);
				preg_match_all('|<div class=\"sl-wrap\">(.*)<\/div><noindex>|U',$page,$out,PREG_SET_ORDER);
				$page=$out[0][0];
				$out=array();
				preg_match_all('|<a[^>]*href=\"(.*)[/]*\"[^>]*>(.*)</a>|U',$page,$out,PREG_SET_ORDER);
				foreach ($out as $val3):*/
				foreach ($val2 as $key3=>$val3):if($i<$t_k):
					foreach ($val3 as $key4=>$val4):$i++;if($i>=$t_n&&$i<$t_k):
						$key4=str_replace(" ","_",$key4);
						$key4=str_replace(".","_",$key4);
						
						//echo 'http://www.koleso-russia.ru/batteries/'.$key1.'/'.$key2.'/'.$key3.'/'.$key4;
						$page = file_get_contents('http://www.koleso-russia.ru/batteries/'.$key1.'/'.$key2.'/'.$key3.'/'.$key4);
						preg_match_all('|<td class=\"params\">([^d]+)d>|',$page,$out,PREG_SET_ORDER);
						
						$str=str_replace("</t","",$out[0][1]);
						$str=str_replace("<br/>",";",$str);
						$str=iconv('windows-1251','utf-8',$str);
						$str=preg_replace("/(Полярность|Пусковой ток|Минимальная ёмкость|Максимальная ёмкость|Размеры)/","<b>$1</b>",$str);
						//|Пусковой ток|Минимальная ёмкость|Максимальная ёмкость|Размеры
						
						
						?>
						
						<tr>
							<td valign="top" align="center"><?php echo$i;?></td>
							<td valign="top" align="center"><?php echo$val4['arr1'];//echo$key1;?></td>
							<td valign="top" align="center"><?php echo$val4['arr2']; //echo$key2;?></td>
							<td valign="top" align="center"><?php echo iconv('windows-1251','utf-8',$val4['arr3']); //echo$key3;?></td>
							<td valign="top" align="center"><?php echo iconv('windows-1251','utf-8',$val4['arr4']); //echo$val4['arr4'];//echo$key4;?></td>
							<td valign="top" align="left"><?php echo$str;?></td>
						</tr>
						
						
						<?php
						
						//$array2[$key1][$key2][$key3][$key4]=array('arr1'=>$key1,'arr2'=>$key2,'arr3'=>$key3,'arr4'=>$key4,'text'=>$str);
						
						//echo"<br>----<br>";
						//print_r($str);
						//echo"<br>----<br>";
						
						
						/*
						$page = file_get_contents('http://www.koleso-russia.ru/batteries/'.$key1.'/'.$key2.'/'.$key3);
						preg_match_all('|<div class=\"sl-wrap\">(.*)<\/div><noindex>|U',$page,$out,PREG_SET_ORDER);
						$page=$out[0][0];
						$out=array();
						preg_match_all('|<a[^>]*href=\"(.*)[/]*\"[^>]*>(.*)</a>|U',$page,$out,PREG_SET_ORDER);
						//echo "----".count($out);
						//exit();
						foreach ($out as $val4):
							//print_r($val4);
							$array2[$key1][$key2][$key3][$val4[1]]=array('arr1'=>$key1,'arr2'=>$key2,'arr3'=>$key3,'arr4'=>$val4[2]);
						endforeach;
						*/
						//echo "<br>------".count($array2[$key1][$key2][$key3]);
						//$array2[$key1][$key2][$val3[1]]=array('arr1'=>$key1,'arr2'=>$key2,'arr3'=>$val3[2]);
					endif;endforeach;
				endif;endforeach;
			//endif;
			endif;endforeach;
			//print_r();
			//$array2[$val3[1]]=array('arr1'=>$val3[2]);
		endif;endforeach;
?>
	
</table>

	<?php	
		exit();
		
		
		$fileName='array.txt';
		/**** извлекаем данные в массив ******/
		$file = fopen($fileName, 'r'); // открываем файл
		$str = "";
		while (($buffer = fgets($file, 128)) !== false) {
        	$str .= $buffer;
    	}
    	$array = unserialize($str); // преобразовываем строку в массив
    	$_SESSION['mas']=$array;
    	/**** извлекаем данные в массив ******/
    	$this->Func3_();
    	/**** сохраняем данные в массив ****** /
    	$array = serialize($array);
		$file = fopen ($fileName,"w");
		fputs($file, $array); // записываем в него строку
    	fclose($file); // закрываем файл
    	/**** сохраняем данные в массив ******/
		$m['vaz']='ваз';
		$m['gaz']='газ';
		$m['tagaz']='тагаз';
		$m['uaz']='уаз';
		ksort($_SESSION['mas']);
		
		
		//https://www.koleso-russia.ru/batteries/		
		
		exit();
			
		
		
		
		//$this->ttt2();
		
		foreach ($Arr as $key1=> $val1):
			//$B_=array();
		
			if(!($A = $this->CarBrand->find('first',array('conditions' => array('title' => $key1))))):
				//echo "<br><br>1 --- ".$key1;
			else:
				//echo "<br> --- ".$key1;
				foreach($val1 as $key2=> $val2):
				//foreach($A_ as $key2):
				
					if(!($B = $this->CarModel->find('first',array('conditions' => array('title' => $key2,'brand_id' => $A['CarBrand']['id']))))):
						//echo "<br>2 --- ".$key2;
					else:
						//echo "<br> --- ".$key2;
						//foreach($val2 as $key3=> $val3):
							foreach($B_ as $key3 => $val3):
								foreach($C_ as $key4 => $val4):
							//foreach($val3 as $key4=> $val4):
								//if(!($C = $this->CarModification->find('first',array('conditions' => array('title' => $key4,'brand_id' => $A['CarBrand']['id'],'model_id' => $B['CarModel']['id']))))):
									//echo "<br>4 --- ".$key4;
							//	else:
									//echo "<br> --- ".$key1." - ".$key2." - ".$key3." - ".$key4;
									/*if(($D = $this->Car->find('first',array('conditions' => array('year' => $key3,'brand_id' => $A['CarBrand']['id'], 'model_id' => $B['CarModel']['id'], 'modification_id' => $C['CarModification']['id']))))):
									/*
										if($i<100):$i++;
											//$this->ttt2($key1,$key2,$key3,$key4);
										endif;	
									* /
										//echo "<br><b>3 --- ".$key3."</b>";
									else:
										echo "<br><b>3 --- ".$key1." --- ".$key2." --- ".$key3." --- ".$key4."</b>";
									endif;*/
								
									if($i<10):$i++;
										$this->ttt2($key1,$key2,$key3,$key4);
									endif;	
								
							//	endif;
							endforeach;
						endforeach;
					endif;
				endforeach;
			endif;
		
		endforeach;
		
		echo'</body></html>';
		exit();

//echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
//echo'<html lang="ru" xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml"><head><title>Центр администрирования</title></head><body>';
/*
foreach($Arr as $key1=> $val1):
	//echo"<br><br>--- ".$key1;
	foreach($val1 as $key2=> $val2):
		//echo"<br>--- ".$key2;
		foreach($val2 as $key3=> $val3):
			//echo"<br>--- ".$key3;
			$page = file_get_contents('http://www.r20.com.ua/load_auto.php?field=year&data={"brand":"'.str_replace(" ","+",$key1).'","model":"'.str_replace(" ","+",$key2).'","year":"'.str_replace(" ","+",$key3).'"}');
			preg_match_all("|<[^>]+>(.*)<[^>]+>|U",$page,$out4, PREG_SET_ORDER);
			foreach($out4 as $o4):
				if($o4['1']!='\u0412\u044b\u0431\u0440\u0430\u0442\u044c'):
					//echo"<br>--- ".$o4['1'];
					$A["'".$key1."'"]["'".$key2."'"]["'".$key3."'"]["'".$o4['1']."'"]=1;
				endif;
			endforeach;
		
		endforeach;
	endforeach;
endforeach;
*/
//echo'</body></html>';

//$Arr = str_replace("]","",str_replace("[","",$Arr));
//$Arr = str_replace("\n","",$Arr);
//$Arr = str_replace(" ) '","),'",$Arr);

//$Arr = str_replace("]","",str_replace("[","",$Arr));
//$Arr = str_replace("\n","",$Arr);
//$Arr = str_replace(" ) '","),'",$Arr);
/*
preg_match_all("|\=\"(.*)\"|U",$M,$out, PREG_SET_ORDER);		

foreach($out as $o):
	$out2 = array();
	$page = file_get_contents('http://www.r20.com.ua/load_auto.php?field=brand&data={"brand":"'.str_replace(" ","+",$o['1']).'"}');
	preg_match_all("|<[^>]+>(.*)<[^>]+>|U",$page,$out2, PREG_SET_ORDER);
	
	if(!empty($out2)):
		foreach($out2 as $o2):
			if($o2['1']!='\u0412\u044b\u0431\u0440\u0430\u0442\u044c'):
				//http://www.r20.com.ua/load_auto.php?field=model&data={"brand":"Lada","model":"1111+Oka"}
				$page = file_get_contents('http://www.r20.com.ua/load_auto.php?field=model&data={"brand":"'.str_replace(" ","+",$o['1']).'","model":"'.str_replace(" ","+",$o2['1']).'"}');
				preg_match_all("|<[^>]+>(.*)<[^>]+>|U",$page,$out3, PREG_SET_ORDER);
					//echo"<br><br> -------<br>";
					//print_r($out3);
					foreach($out3 as $o3):
						if($o3['1']!='\u0412\u044b\u0431\u0440\u0430\u0442\u044c'):
						/*
							$page = file_get_contents('http://www.r20.com.ua/load_auto.php?field=year&data={"brand":"'.str_replace(" ","+",$o['1']).'","model":"'.str_replace(" ","+",$o2['1']).'","year":"'.str_replace(" ","+",$o3['1']).'"}');
							preg_match_all("|<[^>]+>(.*)<[^>]+>|U",$page,$out4, PREG_SET_ORDER);
							foreach($out3 as $o4):
								if($o4['1']!='\u0412\u044b\u0431\u0440\u0430\u0442\u044c'):
									//$A["'".$o['1']."'"]["'".$o2['1']."'"]["'".$o3['1']."'"]["'".$o4['1']."'"]=1;
								endif;
							endforeach;
						* /	
							$A["'".$o['1']."'"]["'".$o2['1']."'"]["'".$o3['1']."'"]=1;
							
						endif;
					endforeach;
				//$A["'".$o['1']."'"]["'".$o2['1']."'"]=1;
			endif;
		endforeach;
	endif;
	//print_r($out2);
	
	//$A["'".$o['1']."'"]=$out2;
endforeach;

*/




//print_r($A);
//'http://rezina.biz.ua/?pname=ajaxGetModels&car=Acura'
//$page = file_get_contents('http://rezina.biz.ua/?pname=ajaxGetModels&car=Acura');
//$page = file_get_contents('http://www.r20.com.ua/load_auto.php?field=brand&data=%7B%22brand%22%3A%22Acura%22%7D');
//$page = file_get_contents('http://www.r20.com.ua/load_auto.php?field=brand&data={"brand":"Acura"}');

//print_r($A);


//header("Access-Control-Allow-Origin:*");

/*?>

<script src="/js/jquery.min.js" type="text/javascript"></script>
<script>
 $(document).ready(function() {
  	
  	$.ajax({
            type: 'GET',
            data: "pname=ajaxGetModels&car=Acura",
            url: "http://www.rezina.biz.ua",
            dataType: 'json',
            cache: false,
           
            contentType: 'application/json; charset=utf-8',
            success: function(text){
  				console.log(text);
  			}
        });
  	
  	
 });
</script>

<?php */

/*
[
{"name":"CL","id":"CL"},
{"name":"EL","id":"EL"},
{"name":"Integra","id":"Integra"},
{"name":"MDX","id":"MDX"},
{"name":"NSX","id":"NSX"},
{"name":"RDX","id":"RDX"},
{"name":"RL","id":"RL"},
{"name":"RSX","id":"RSX"},
{"name":"TL","id":"TL"},
{"name":"TLX","id":"TLX"},
{"name":"TSX","id":"TSX"},
{"name":"ZDX","id":"ZDX"}
]
*/		//echo"------";
/*
		$M='<option value="Acura">Acura</option>
<option value="Alfa Romeo">Alfa Romeo</option>
<option value="Aston Martin">Aston Martin</option>
<option value="Audi">Audi</option>
<option value="Bentley">Bentley</option>
<option value="BMW">BMW</option>
<option value="Brilliance">Brilliance</option>
<option value="Buick">Buick</option>
<option value="BYD">BYD</option>
<option value="Cadillac">Cadillac</option>
<option value="Changan">Changan</option>
<option value="Chery">Chery</option>
<option value="Chevrolet">Chevrolet</option>
<option value="Chrysler">Chrysler</option>
<option value="Citroen">Citroen</option>
<option value="Dadi">Dadi</option>
<option value="Daewoo">Daewoo</option>
<option value="Daihatsu">Daihatsu</option>
<option value="Datsun">Datsun</option>
<option value="Derways">Derways</option>
<option value="Dodge">Dodge</option>
<option value="Emgrand">Emgrand</option>
<option value="FAW">FAW</option>
<option value="Ferrari">Ferrari</option>
<option value="Fiat">Fiat</option>
<option value="Ford">Ford</option>
<option value="Geely">Geely</option>
<option value="GMC">GMC</option>
<option value="Great Wall">Great Wall</option>
<option value="Haima">Haima</option>
<option value="Honda">Honda</option>
<option value="Hummer">Hummer</option>
<option value="Hyundai">Hyundai</option>
<option value="Infiniti">Infiniti</option>
<option value="Isuzu">Isuzu</option>
<option value="Iveco">Iveco</option>
<option value="Jaguar">Jaguar</option>
<option value="Jeep">Jeep</option>
<option value="Jiangling">Jiangling</option>
<option value="JMC">JMC</option>
<option value="Kia">Kia</option>
<option value="Lada">Lada</option>
<option value="Lamborghini">Lamborghini</option>
<option value="Lancia">Lancia</option>
<option value="Land Rover">Land Rover</option>
<option value="Landwind">Landwind</option>
<option value="Lexus">Lexus</option>
<option value="Lifan">Lifan</option>
<option value="Lincoln">Lincoln</option>
<option value="Lotus">Lotus</option>
<option value="Maserati">Maserati</option>
<option value="Maybach">Maybach</option>
<option value="Mazda">Mazda</option>
<option value="Mercedes">Mercedes</option>
<option value="Mercury">Mercury</option>
<option value="MG">MG</option>
<option value="Mini">Mini</option>
<option value="Mitsubishi">Mitsubishi</option>
<option value="Mosler">Mosler</option>
<option value="Nissan">Nissan</option>
<option value="Oldsmobile">Oldsmobile</option>
<option value="Opel">Opel</option>
<option value="Panoz">Panoz</option>
<option value="Peugeot">Peugeot</option>
<option value="Plymouth">Plymouth</option>
<option value="Pontiac">Pontiac</option>
<option value="Porsche">Porsche</option>
<option value="Ram">Ram</option>
<option value="Renault">Renault</option>
<option value="Rolls Royce">Rolls Royce</option>
<option value="Rover">Rover</option>
<option value="Saab">Saab</option>
<option value="Saleen">Saleen</option>
<option value="Saturn">Saturn</option>
<option value="Scion">Scion</option>
<option value="Seat">Seat</option>
<option value="Skoda">Skoda</option>
<option value="Smart">Smart</option>
<option value="Ssang Yong">Ssang Yong</option>
<option value="Subaru">Subaru</option>
<option value="Suzuki">Suzuki</option>
<option value="Tagaz">Tagaz</option>
<option value="Toyota">Toyota</option>
<option value="Volkswagen">Volkswagen</option>
<option value="Volvo">Volvo</option>
<option value="Xin Kai">Xin Kai</option>
<option value="ZAZ">ZAZ</option>
<option value="ZX">ZX</option>
<option value="ВАЗ">ВАЗ</option>
<option value="ГАЗ">ГАЗ</option>
<option value="ТагАЗ">ТагАЗ</option>
<option value="УАЗ">УАЗ</option>';*/		
	}
	

	
	
	
	
	
	public function index() {
		//echo"111111";
		$this->loadModel('BrandModel');
		$this->loadModel('Product');
		$this->loadModel('Settings');
		
		$this->category_id = 2;
		$limit = 30;
		
		if (isset($this->request->query['limit']) && in_array($this->request->query['limit'], array('10', '20', '30', '50'))) {
			$limit = $this->request->query['limit'];
		}
		$this->paginate['limit'] = $limit;
		$this->set('limit', $limit);

		/*
		if($this->sett_var('SHOW_DISKS_IMG_TOVAR')==1):
		
			//'Product.filename !=' => ''
			$conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		else: 
			$conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		endif;
		*/

		
		$conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		
		$this->request->data['Product'] = $this->request->query;
		$mode = 'block';
		if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
			$mode = $this->request->query['mode'];
		}
		$this->request->data['Product']['mode'] = $mode;
		$this->set('mode', $mode);
		if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
			if (!is_array($this->request->query['brand_id'])) {
				$brand_id = intval($this->request->query['brand_id']);
				if ($brand_id != 0) {
					$this->loadModel('Brand');
					if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
						$this->redirect(array('controller' => 'disks', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $this->request->query));
						return;
					}
				}
			} else {
				$conditions['Product.brand_id'] = $this->request->query['brand_id'];
				if (count($this->request->query['brand_id']) == 1) {
					$this->request->data['Product']['brand_id'] = $this->request->query['brand_id'][0];
				} else {
					unset($this->request->data['Product']['brand_id']);
				}
			}
		}
		
		$product_conditions = $conditions = $this->get_conditions($conditions);
		
		$this->set('filter', array_filter($this->request->query));
		$material_condition = 'cast';
		if (isset($conditions['BrandModel.material'])) {
			$material_condition = $conditions['BrandModel.material'];
			unset($conditions['BrandModel.material']);
		}
		
		//print_r($conditions);
			
		
		$model_ids = $this->Product->find('list', array(
			'fields' => array('Product.model_id'),
			'conditions' => $conditions
        ));
        
       // print_r($conditions);
        
		$product_ids =  implode(", ", array_keys($model_ids));
		if (empty($product_ids)) {$product_ids = 0;}
		
		
		
		
		if (isset($this->request->query['in_stock'])) {
				if ($this->request->query['in_stock'] == 1) {
					$conditions['Product.in_stock'] = 1;
					
				}
				elseif ($this->request->query['in_stock'] == 0) {
					$conditions['Product.in_stock'] = 0;
				}
				else{$conditions['Product.in_stock'] = array(0,1);}
		}
		else {
			/*** select *****/
			$this->loadModel('Settings');
			$s = $this->Settings->find('all', array('conditions' => array('type' => 'radio','variable'=>'PRODUCTINSTOCK2','value'=>1)));
			if(isset($this->prod[$s[0]['Settings']['description']])):
				$this->request->query['in_stock'] = $this->prod[$s[0]['Settings']['description']];
				$conditions['Product.in_stock'] = $this->request->query['in_stock'];
				$product_conditions['Product.in_stock'] = $this->request->query['in_stock'];
			else:
				$this->request->query['in_stock'] = 2;
			endif;
			/*** select *****/
		}
	
		//print_r($conditions);
		
		$this->BrandModel->bindModel(
			array(
				'belongsTo' => array(
					'Brand'
				),
				'hasMany' => array(
					'Product' => array(
						'foreignKey' => 'model_id',
						/*'joins' => array(
							array(
								'table' => 'brand_models',
								'alias' => 'BrandModel',
                        		'conditions' => array('Product.model_id = BrandModel.id')
                        	)
                        ),*/
						'conditions' => ($conditions['Product.filename !=']=''),
						'order'      => 'Product.price ASC'
					)
				)
			),
			false
		);
		
		//print_r($this->BrandModel);
		
		
		/*,'or'=>array(
                        									array('and'=>array(
                        										array('Product.filename'=>'')/*,
                        										array('BrandModel.filename != '=> '')* /
                        									),
                        									array('Product.filename != '=> '')
                        									)
                        								)
                        							)*/
		
		//print_r($conditions);
		
		//print_r($product_conditions);
		
		$this->_filter_disc_params($conditions);
		unset($conditions['Product.price >=']);
		unset($conditions['Product.price <=']);
		
		$prices = $this->Product->find('first', array(
			'fields' => array('MAX(Product.price) AS max', 'MIN(Product.price) AS min'),
			'conditions' => $conditions
        ));
        
		$this->set('price_from', floor($prices[0]['min']));
		$this->set('price_to', ceil($prices[0]['max']));
		if ($mode == 'table') {
			if ($this->sett_var('SHOW_DISKS_IMG')==1)
			$product_conditions['BrandModel.filename !='] = '';
			$this->paginate['conditions'] = $product_conditions;
		}
		else {
			if($this->sett_var('SHOW_DISKS_IMG_TOVAR')==1)
					$model_conditions = array('BrandModel.category_id' => 1,'BrandModel.is_active' => 1, 'BrandModel.category_id' => 2, 'BrandModel.id' => $model_ids,'BrandModel.filename !=' => '');
			else 	$model_conditions = array('BrandModel.category_id' => 1,'BrandModel.is_active' => 1, 'BrandModel.category_id' => 2, 'BrandModel.id' => $model_ids);
			
			
			if (!empty($material_condition)) {
				$model_conditions['BrandModel.material'] = $material_condition;
			}
			
			$this->paginate['conditions'] = $model_conditions;
			//print_r($this->paginate['conditions']);
		}
		
		
		//print_r($this->paginate['conditions']);
		
		
		$sort = 'price_asc';
		if (isset($this->request->query['sort']) && in_array($this->request->query['sort'], array('name', 'price_asc', 'price_desc'))) {
			$sort = $this->request->query['sort'];
		}
		if ($mode == 'table') {
			$sort_orders = array(
				'price_asc' => array('Product.price' => 'ASC'),
				'price_desc' => array('Product.price' => 'DESC'),
				'name' => array('BrandModel.full_title' => 'ASC'),
			);
		}
		else {
			$sort_orders = array(
				'price_asc' => array('BrandModel.low_price' => 'ASC'),
				'price_desc' => array('BrandModel.low_price' => 'DESC'),
				'name' => array('BrandModel.full_title' => 'ASC'),
			);

			/*
			if($this->sett_var('SHOW_DISKS_IMG_TOVAR')==1):
				$this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where 
				`products`.`model_id`=`BrandModel`.`id` AND 
				(`products`.`filename` = "" AND `BrandModel`.`filename` != "" OR
				 `products`.`filename` != "") AND 
				`products`.`id` IN ('.$product_ids.'))';
			else: */
			
			$this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where `products`.`model_id`=`BrandModel`.`id`  AND `products`.`id` IN ('.$product_ids.'))';
				
			//endif;
		}
		$this->paginate['order'] = $sort_orders[$sort];

		$this->BrandModel->virtualFields['full_title'] = 'CONCAT(Brand.title,\' \',BrandModel.title)';

		
		if ($mode == 'table') {
			$this->Product->bindModel(
				array(
					'belongsTo' => array(
						'BrandModel' => array(
							'foreignKey' => 'model_id'
						),
						'Brand'
					)
				),
				false
			);
			$models = $this->paginate('Product');
		}
		else {
			$models = $this->paginate('BrandModel');
			//print_r($models);
		}

		
		//print_r($models);
		
		if (isset($this->request->data['Product']['brand_id']) && !empty($this->request->data['Product']['brand_id'])) {
			$brand_models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
			$this->set('brand_models', $brand_models);
		}
		
		/**** Убираем 0 элемент ****/
		foreach ($models as $key => $m):
			if($m['Product'][0]['price'] == 0):
				unset($models[$key]);
			endif;
		endforeach;
		/**** Убираем 0 элемент ****/
			
		$this->set('models', $models);

		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Диски'
		);
		$meta_title = 'Купить автомобильные диски, легкосплавные диски Керчь, Феодосия магазин дисков Авто Дом ';
		$meta_keywords = 'Купить, автомобильные диски, легкосплавные диски, Керчь, магазин дисков Авто Дом, Феодосия';
		$meta_description = 'Магазин дисков Авто Дом предлагает купить автомобильные диски, легкосплавные диски в Керчи, Феодосии по самым низким ценам у нас всегда самый большой выбор.';
		$this->set('breadcrumbs', $breadcrumbs);
		$this->setMeta('title', $meta_title);
		$this->setMeta('keywords', $meta_keywords);
		$this->setMeta('description', $meta_description);
		$this->set('active_menu', 'disks');
		$this->set('sort', $sort);
		$this->set('show_left_filter', true);
		$this->set('additional_js', array('lightbox', 'slider', 'functions'));
		$this->set('additional_css', array('lightbox', 'jquery-ui-1.9.2.custom.min'));
	}
	
	
	
	
	public function brand($slug) {
//		echo"******";
		
		$this->category_id = 2;
		$mode = 'block';
		if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
			$mode = $this->request->query['mode'];
		}
		$this->set('mode', $mode);
		$sort = 'price_asc';
		if (isset($this->request->query['sort']) && in_array($this->request->query['sort'], array('name', 'price_asc', 'price_desc'))) {
			$sort = $this->request->query['sort'];
		}
		if ($mode == 'table') {
			$sort_orders = array(
				'price_asc' => array('Product.price' => 'ASC'),
				'price_desc' => array('Product.price' => 'DESC'),
				'name' => array('BrandModel.full_title' => 'ASC'),
			);
		}
		else {
			$sort_orders = array(
				'price_asc' => array('BrandModel.low_price' => 'ASC'),
				'price_desc' => array('BrandModel.low_price' => 'DESC'),
				'name' => array('BrandModel.full_title' => 'ASC'),
			);
		}
	
		$this->loadModel('Brand');
		if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.is_active' => 1, 'Brand.category_id' => 2, 'Brand.slug' => $slug)))) {
			if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
				$brand_id = intval($this->request->query['brand_id']);
				if ($brand['Brand']['id'] != $brand_id) {
					if ($brand_id == 0) {
						$filter = $this->request->query;
						unset($filter['brand_id']);
						unset($filter['model_id']);
						$this->redirect(array('controller' => 'disks', 'action' => 'index', '?' => $filter));
						return;
					}
					elseif ($new_brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
						$this->redirect(array('controller' => 'disks', 'action' => 'brand', 'slug' => $new_brand['Brand']['slug'], '?' => $this->request->query));
						return;
					}
				}
			}
			$this->_filter_disc_params();
			$conditions = array('Product.is_active' => 1, 'Product.brand_id' => $brand['Brand']['id'], 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
			$this->loadModel('BrandModel');
			$limit = 30;
			if (isset($this->request->query['limit']) && in_array($this->request->query['limit'], array('10', '20', '30', '50'))) {
				$limit = $this->request->query['limit'];
			}
			$this->paginate['limit'] = $limit;
			$this->set('limit', $limit);
			
			
			if ($this->sett_var('SHOW_DISKS_IMG')==1)
					$models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1,'BrandModel.filename !=' => ''), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
			else 	$models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
			

			$model_id = null;
			if (isset($this->request->query['model_id'])) {
				$model_id = intval($this->request->query['model_id']);
				if (!isset($models[$model_id])) {
					$model_id = null;
				}
			}
			
			if (!empty($model_id)) {
				$conditions['Product.model_id'] = $model_id;
				$this->set('model_id', $model_id);
			}
			if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
				$conditions['Product.size1'] = $this->request->query['size1'];
			}
			if (isset($this->request->query['hub']) && !empty($this->request->query['hub'])) {
				$conditions['Product.hub'] = $this->request->query['hub'];
			}
			if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
				$values = array($this->request->query['size2']);
				if (substr_count($this->request->query['size2'], '.') > 0) {
					$values[] = str_replace('.', ',', $this->request->query['size2']);
				}
				foreach ($values as $value) {
					$conditions['or'][] = 'Product.size2 LIKE "' . $value . '%"';
					if (substr_count($value, 'x') == 1) {
						$parts = explode('x', $value);
						$conditions['or'][] = 'Product.size2 LIKE "' . $parts[0] . 'x%/' . $parts[1] . '"';
					}
				}
			}
			
			
			
			
		
			if (isset($this->request->query['in_stock'])) {
				//echo"-----------".$this->request->query['in_stock'];
				//$conditions['Product.in_stock'] = $this->request->query['in_stock'];

				if ($this->request->query['in_stock'] == 1) {
					$conditions['Product.in_stock'] = 1;
				}
				elseif ($this->request->query['in_stock'] == 0) {
					$conditions['Product.in_stock'] = 0;
				}
				else{$conditions['Product.in_stock'] = array(0,1);}
			}	
			else {
				
				/*** select *****/
				$this->loadModel('Settings');
				$s = $this->Settings->find('all', array('conditions' => array('type' => 'radio','variable'=>'PRODUCTINSTOCK2','value'=>1)));
				if(isset($this->prod[$s[0]['Settings']['description']])):
					$this->request->query['in_stock'] = $this->prod[$s[0]['Settings']['description']];
					$conditions['Product.in_stock'] = $this->request->query['in_stock'];
				else:
					$this->request->query['in_stock'] = 2;
				endif;
				/*** select *****/

			}
		
			
			
			
			if (!isset($this->request->query['in_stock4'])) {
				$this->request->query['in_stock4'] = 0;
			}
			if (isset($this->request->query['in_stock4']) && $this->request->query['in_stock4']) {
				$conditions['Product.stock_count >= '] = 4;
			}
			if (isset($this->request->query['et_from']) && !empty($this->request->query['et_from'])) {
				$et = floatval(str_replace(',', '.', $this->request->query['et_from']));
				if ($et > 0) {
					$conditions['Product.et >='] = $et;
				}
			}
			if (isset($this->request->query['et_to']) && !empty($this->request->query['et_to'])) {
				$et = floatval(str_replace(',', '.', $this->request->query['et_to']));
				if ($et > 0) {
					$conditions['Product.et <='] = $et;
				}
			}
			if (isset($this->request->query['price_from']) && !empty($this->request->query['price_from'])) {
				$conditions['Product.price >'] = intval($this->request->query['price_from']);
			}
			if (isset($this->request->query['price_to']) && !empty($this->request->query['price_to'])) {
				$conditions['Product.price <='] = intval($this->request->query['price_to']);
			}
			$product_conditions = $conditions;
			
			//$product_conditions['Product.filename !='] = '';
			
			$model_ids = $this->Product->find('list', array(
				'fields' => array('Product.model_id'),
				'conditions' => $product_conditions
			));
			
			$product_ids =  implode(", ", array_keys($model_ids));
			if (empty($product_ids)) {$product_ids = 0;}
			$this->BrandModel->bindModel(
				array(
					'belongsTo' => array(
						'Brand'
					),
					'hasMany' => array(
						'Product' => array(
							'foreignKey' => 'model_id',
							'conditions' => $conditions,
							'order'      => 'Product.price ASC'
						)
					)
				),
				false
			);
		
			unset($conditions['Product.price >=']);
			unset($conditions['Product.price <=']);
			
			
		//	print_r($conditions);
			
			$prices = $this->Product->find('first', array(
				'fields' => array('MAX(Product.price) AS max', 'MIN(Product.price) AS min'),
				'conditions' => $conditions
			));
			$this->set('price_from', floor($prices[0]['min']));
			$this->set('price_to', ceil($prices[0]['max']));
			$this->_filter_disc_params($conditions);
			$this->request->data['Product'] = $this->request->query;
			$this->request->data['Product']['mode'] = $mode;
			$this->request->data['Product']['brand_id'] = $brand['Brand']['id'];
			$this->set('models', $models);
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => array('controller' => 'disks', 'action' => 'index'),
				'title' => 'Диски'
			);
			$meta_title = !empty($brand['Brand']['meta_title']) ? $brand['Brand']['meta_title'] : $brand['Brand']['title'];
			$meta_keywords = $brand['Brand']['meta_keywords'];
			$meta_description = $brand['Brand']['meta_description'];
			

			$render = 'index';
			if (!empty($model_id)) {
				if ($model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $model_id)))) {
					$breadcrumbs[] = array(
						'url' => array('controller' => 'disks', 'action' => 'brand', 'slug' => $slug),
						'title' => $brand['Brand']['title']
					);
					$breadcrumbs[] = array(
						'url' => null,
						'title' => $model['BrandModel']['title']
					);
					$this->setLastModels($model);
					$meta_title = (!empty($model['BrandModel']['meta_title']) ? $model['BrandModel']['meta_title'] : 'Автомобильный диск ' . $model['Brand']['title'] . ' ' . $model['BrandModel']['title']);
					$meta_keywords = $model['BrandModel']['meta_keywords'];
					$meta_description = $model['BrandModel']['meta_description'];
					$this->set('model', $model);
					$this->set('show_left_menu', false);
					$render = 'model';
				}
			}
			else {
				$breadcrumbs[] = array(
					'url' => null,
					'title' => $brand['Brand']['title']
				);
				
				//print_r($conditions);
				
				if (count($conditions) == 4) {
					if ($this->sett_var('SHOW_DISKS_IMG')==1)
							$model_conditions = array('BrandModel.category_id' => 2,'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.filename !=' => '');
					else 	$model_conditions = array('BrandModel.category_id' => 2,'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id']);
				}
				else {
					if ($this->sett_var('SHOW_DISKS_IMG')==1)
							$model_conditions = array('BrandModel.category_id' => 2,'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.id' => $model_ids, 'BrandModel.filename !=' => '');
					else 	$model_conditions = array('BrandModel.category_id' => 2,'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.id' => $model_ids);
				}
				
				$this->paginate['order'] = $sort_orders[$sort];
				$this->BrandModel->virtualFields['full_title'] = 'CONCAT(Brand.title,\' \',BrandModel.title)';
				if ($mode == 'table') {
					$this->Product->bindModel(
						array(
							'belongsTo' => array(
								'BrandModel' => array(
									'foreignKey' => 'model_id'
								),
								'Brand'
							)
						),
						false
					);
					
					if ($this->sett_var('SHOW_DISKS_IMG')==1)
						$product_conditions['BrandModel.filename !='] = '';
						//$product_conditions['Product.filename !='] = '';
					$this->paginate['conditions'] = $product_conditions;
					$models = $this->paginate('Product'); 
				}
				else {
					$this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where `products`.`model_id`=`BrandModel`.`id` AND `products`.`id` IN ('.$product_ids.'))';
					$this->paginate['conditions'] = $model_conditions;
					
					//print_r($model_conditions);
					
					$models = $this->paginate('BrandModel'); 
				}
				$brand_models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
				
				//print_r($models);
				
				$this->set('brand_models', $brand_models);
				$this->set('models', $models);
				$this->set('show_left_filter', true);
				//print_r($models);
				//echo"999999";
			}
			
			
			
			
			//$meta_title = 'Купить автомобильные диски, легкосплавные диски Керчь, Феодосия магазин дисков Авто Дом ';
			//$meta_keywords = 'Купить, автомобильные диски, легкосплавные диски, Керчь, магазин дисков Авто Дом, Феодосия';
			//$meta_description = 'Магазин дисков Авто Дом предлагает купить автомобильные диски, легкосплавные диски в Керчи, Феодосии по самым низким ценам у нас всегда самый большой выбор.';
			$this->set('breadcrumbs', $breadcrumbs);
			$this->set('filter', array_filter($this->request->query));
			$this->set('brand_id', $brand['Brand']['id']);
			$this->setMeta('title', $meta_title);
			$this->setMeta('keywords', $meta_keywords);
			$this->setMeta('description', $meta_description);
			$this->set('brand', $brand);
			$this->set('sort', $sort);
			$this->set('active_menu', 'disks');
			$this->set('additional_js', array('lightbox', 'slider', 'functions'));
			$this->set('additional_css', array('lightbox', 'jquery-ui-1.9.2.custom.min'));
			$this->render($render);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function view($slug, $id) {
		$this->category_id = 2;
		$this->loadModel('Brand');
		if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.is_active' => 1, 'Brand.category_id' => 2, 'Brand.slug' => $slug)))) {
			$this->loadModel('Product');
			$this->Product->bindModel(
				array(
					'belongsTo' => array(
						'BrandModel' => array(
							'foreignKey' => 'model_id'
						)
					)
				),
				false
			);
			if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.brand_id' => $brand['Brand']['id'], 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {
				$this->loadModel('BrandModel');


				$conditions = array('Product.is_active' => 1, 'Product.brand_id' => $brand['Brand']['id'], 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
				if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
					$conditions['Product.size1'] = $this->request->query['size1'];
				}
				if (isset($this->request->query['hub']) && !empty($this->request->query['hub'])) {
					$conditions['Product.hub'] = $this->request->query['hub'];
				}
				if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
					$values = array($this->request->query['size2']);
					if (substr_count($this->request->query['size2'], '.') > 0) {
						$values[] = str_replace('.', ',', $this->request->query['size2']);
					}
					foreach ($values as $value) {
						$conditions['or'][] = 'Product.size2 LIKE "' . $value . '%"';
						if (substr_count($value, 'x') == 1) {
							$parts = explode('x', $value);
							$conditions['or'][] = 'Product.size2 LIKE "' . $parts[0] . 'x%/' . $parts[1] . '"';
						}
					}
				}
				if (isset($this->request->query['in_stock'])) {
					if ($this->request->query['in_stock'] == 1) {
						$conditions['Product.in_stock'] = 1;
						$has_params = true;
					}
					elseif ($this->request->query['in_stock'] == 0) {
						$conditions['Product.in_stock'] = 0;
						$has_params = true;
					}
				}
				else {
					$this->request->query['in_stock'] = 1;
					$conditions['Product.in_stock'] = 1;
					//$has_params = true;
				}
				if (isset($this->request->query['et_from']) && !empty($this->request->query['et_from'])) {
					$et = floatval(str_replace(',', '.', $this->request->query['et_from']));
					if ($et > 0) {
						$conditions['Product.et >='] = $et;
					}
				}
				if (isset($this->request->query['et_to']) && !empty($this->request->query['et_to'])) {
					$et = floatval(str_replace(',', '.', $this->request->query['et_to']));
					if ($et > 0) {
						$conditions['Product.et <='] = $et;
					}
				}
				$this->_filter_disc_params($conditions);
				$this->request->data['Product'] = $this->request->query;

				$models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
				$breadcrumbs = array();
				$breadcrumbs[] = array(
					'url' => array('controller' => 'disks', 'action' => 'index'),
					'title' => 'Диски'
				);
				$breadcrumbs[] = array(
					'url' => array('controller' => 'disks', 'action' => 'brand', 'slug' => $slug),
					'title' => $brand['Brand']['title']
				);
				$breadcrumbs[] = array(
					'url' => array('controller' => 'disks', 'action' => 'brand', 'slug' => $slug, '?' => array('model_id' => $product['Product']['model_id'])),
					'title' => $product['BrandModel']['title']
				);
				$breadcrumbs[] = array(
					'url' => null,
					'title' => $product['Product']['sku']
				);
				
				$this->loadModel('BrandModel');
				$this->BrandModel->bindModel(
					array(
						'belongsTo' => array(
							'Brand'
						),
						'hasMany' => array(
							'Product' => array(
								'foreignKey' => 'model_id',
								'conditions' => array('Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0),
								'order'      => 'Product.price ASC'
							)
						)
					),
					false
				);
				$model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $product['BrandModel']['id'])));
				$this->setLastModels($model);

				$this->set('filter', array_filter($this->request->query));
				$this->set('all_materials', $this->BrandModel->materials);
				$this->set('breadcrumbs', $breadcrumbs);
				$this->set('additional_js', array('lightbox', 'functions'));
				$this->set('additional_css', array('lightbox'));
				$this->set('models', $models);
				$this->set('brand_id', $brand['Brand']['id']);
				$this->set('model_id', $product['Product']['model_id']);
				$this->setMeta('title', $product['Product']['sku']);
				$this->setMeta('keywords', $product['BrandModel']['meta_keywords']);
				$this->setMeta('description', $product['BrandModel']['meta_description']);
				$this->set('brand', $brand);
				$this->set('product', $product);
				$this->set('active_menu', 'disks');
				$this->set('show_left_menu', false);
			}
			else {
				$this->response->statusCode(404);
				$this->response->send();
				$this->render(false);
				return;
			}
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	private function get_conditions($conditions) {
		if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
			$conditions['Product.size1'] = $this->request->query['size1'];
		}
		if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
			$values = array($this->request->query['size2']);
			if (substr_count($this->request->query['size2'], '.') > 0) {
				$values[] = str_replace('.', ',', $this->request->query['size2']);
			}
			foreach ($values as $value) {
				$conditions['or'][] = 'Product.size2 LIKE "' . $value . '%"';
				if (substr_count($value, 'x') == 1) {
					$parts = explode('x', $value);
					$conditions['or'][] = 'Product.size2 LIKE "' . $parts[0] . 'x%/' . $parts[1] . '"';
				}
			}
		}
		if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
			$conditions['Product.size3'] = $this->request->query['size3'];
		}
		if (isset($this->request->query['in_stock'])) {
			if ($this->request->query['in_stock'] == 1) {
				$conditions['Product.in_stock'] = 1;
			}
			elseif ($this->request->query['in_stock'] == 0) {
				$conditions['Product.in_stock'] = 0;
			}
		}
		else {
			$this->request->query['in_stock'] = 1;
			$conditions['Product.in_stock'] = 1;
		}
		if (isset($this->request->query['in_stock4']) && $this->request->query['in_stock4']) {
			$conditions['Product.stock_count >= '] = 4;
		}

		if (isset($this->request->query['material']) && !empty($this->request->query['material'])) {
			$conditions['BrandModel.material'] = $this->request->query['material'];
		}
		if (isset($this->request->query['hub']) && !empty($this->request->query['hub'])) {
			$conditions['Product.hub'] = $this->request->query['hub'];
		}

		if (isset($this->request->query['et_from']) && !empty($this->request->query['et_from'])) {
			$et = floatval(str_replace(',', '.', $this->request->query['et_from']));
			if ($et > 0) {
				$conditions['Product.et >='] = $et;
			}
		}
		if (isset($this->request->query['et_to']) && !empty($this->request->query['et_to'])) {
			$et = floatval(str_replace(',', '.', $this->request->query['et_to']));
			if ($et > 0) {
				$conditions['Product.et <='] = $et;
			}
		}
		if (isset($this->request->query['price_from']) && !empty($this->request->query['price_from'])) {
			$conditions['Product.price >='] = intval($this->request->query['price_from']);
		}
		if (isset($this->request->query['price_to']) && !empty($this->request->query['price_to'])) {
			$conditions['Product.price <='] = intval($this->request->query['price_to']);
		}
		return $conditions;
	}
	public function set_filter() {
		Configure::write('debug', 0);
		$conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		$conditions = $this->get_conditions($conditions);
		if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
				$brand_id = intval($this->request->query['brand_id']);
				if ($brand_id != 0) {
					$conditions['Product.brand_id'] = $this->request->query['brand_id'];
				}
		}
		
		$result = $this->_filter_disc_params($conditions);
		echo json_encode($result);
		$this->layout = false;
		$this->render(false);

	}
	
	
	
	
	public function popular() {
		$this->loadModel('Page');
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'disks')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$this->set('page', $page);
		}
		$this->category_id = 2;
		$this->_filter_disc_params();
		$this->loadModel('Product');
		$this->loadModel('BrandModel');
		
		
		$this->loadModel('Settings');
	
		
		/*** настройки на вывод товара ****/
		$conditions = array(
				'belongsTo' => array(
					'Brand'
				),
				'hasMany' => array(
					'Product' => array(
						'foreignKey' => 'model_id'
						/*,'conditions' => array('Product.in_stock'=>0)*/
					)
				)
		);
		//$prod['в наличии']=1;
		//$prod['под заказ']=0;
		/*** настройки на вывод товара ****/
		/*** select *****/
//		$this->loadModel('Settings');
		$select = $this->Settings->find('all', array('conditions' => array('type' => 'radio')));
		foreach($select as $val):
			$select2[$val['Settings']['variable']][$val['Settings']['description']]=$val['Settings']['value'];
			if($val['Settings']['variable']=='PRODUCTINSTOCK'&&$val['Settings']['value']==1&&!empty($this->prod[$val['Settings']['description']])):
				$conditions['hasMany']['Product']['conditions']=array('Product.in_stock'=>$this->prod[$val['Settings']['description']]);
			endif;
		endforeach;
		$this->set('select', $select2);
		/*** select *****/
		/*** Выборка *****/
		$this->BrandModel->bindModel($conditions,false);
		$new = $this->BrandModel->find('all', array('limit' => 3, 'conditions' => array('BrandModel.new' => 1, 'BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0')));
		$popular = $this->BrandModel->find('all', array('limit' => 3, 'conditions' => array('BrandModel.popular' => 1, 'BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0')));
		/*** Выборка *****/
		
		$this->set('active_menu', 'disks');
		$this->set('show_left_menu', true);
		$this->set('new', $new);
		$this->set('popular', $popular);
	}
}