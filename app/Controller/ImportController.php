<?php
class ImportController extends AppController {
	public $uses = array();
	public $model = 'Import';
	public $submenu = 'products';
	public $section = 'import';
	
	public $product_materials = array(
							'BFP',
							'сильвер с крышками под винт',
							'MATT BlACK FULL POLISHED',
							'MATT GUN METAL POLISHED',
							'DIAM BLACK POLISHED LIP',
							'RAINBOW BLACK POLISHED',
							'DULL BRONZED POLISHED',
							'GLOSSY BLACK POLISHED',
							'Gloss Black Polished',
							'SILVER POLISHED LIP',
							'Ultraleggera grafit',
							'DIAM BLACK POLISHED',
							'DULL BLACK POLISHED',
							'Silver Polished Lip',
							'ANTHRACITE POLISHED',
							'Matte Dark Gunmetal',
							'matt black polished',
							'Anthracite Polished',
							'BLACK LIP POLISHED',
							'MATT GREY POLISHED',
							'HYPER ANTHRACITE',
							'алмаз блэк-аурум',
							'металл бриллиант',
							'Silver Polished',
							'SILVER POLISHED',
							'(R-L)BE-P-(R)Z',
							'DULL BL FLOW.F',
							'(RL)B10-(R)Z/M',
							'CHOME+BLK.INS.',
							'алмаз платинум',
							'MATT GUN METAL',
							'BLACK+CHR.INS.',
							'BLACK POLISHED',
							'алмаз аргентум',
							'hsinoxfinoxlip',
							'silvpfinoxlip',
							'binoxfinoxlip',
							'DIAMOND BLACK',
							'DARK POLISHED',
							'дарк платинум',
							'ice superdark',
							'Dark Gunmetal',
							'алмаз сильвер',
							'HAND POLISHED',
							'silvmfinoxlip',
							'дарк платинум',
							'блэк платинум',
							'mtbpfinoxlip',
							'DULL BRONZED',
							'BLACK+CHROME',
							'Hyper Bright',
							'SP (VW LOGO)',
							'icesuperdark',
							'Hyper Silver',
							'(RL)B-LP-X/M',
							'SILVER SHINE',
							'hyper bright',
							'HYPER SILVER',
							'GLOSSY BLACK',
							'алмаз черный',
							'алмаз графит',
							'(RL)W10-(R)Z',
							'SUPER SILVER',
							'rlb10rzm fly',
							'алмаз чёрный',
							'blw10bz fly',
							'cawlwpb fly',
							'Нео-классик',
							'HYPER BLACK',
							'MATT Silver',
							'SilvMfinoxl',
							'MtBBluLBluC',
							'Matte Black',
							'SilvMFInoxL',
							'hyper black',
							'Gloss Black',
							'алмаз брасс',
							'SilvPFInoxL',
							'BLACK+CHROM',
							'ML/MUC/MC/R',
							'(RL)BLK-X/M',
							'DARK SILVER',
							'метал.брил.',
							'(R)B-LP-Z/M',
							'CHROME LOOK',
							'hbpfinoxlip',
							'mtsinoxlip',
							'bmfinoxlip',
							'mtbinoxlip',
							'ANTHRACITE',
							'MtBpfinoxl',
							'B/PF+BLACK',
							'red mirror',
							'HS светлый',
							'TM(Carbon)',
							'(RL)BP-X/M',
							'MtBPFInoxL',
							'chr/silver',
							'matt black',
							'DULL BLACK',
							'SILVER POL',
							'алмаз вайт',
							'блэк аурум',
							'(Rs)B6-Z/M',
							'IMP-CB-D/P',
							'неоклассик',
							'W-OBK-F/P',
							'HS/CW-D/P',
							'M.GUN MET',
							'(RL)BLK-M',
							'BLACK+RED',
							'BSL+WHITE',
							'B/PF+BLUE',
							'(R)W-LP-Z',
							'HSInoxF/L',
							'(RL)B-P/M',
							'B6-(W)Z/M',
							'EM-P-ZY/M',
							'алмаз мэт',
							'блэк джек',
							'chr. look',
							'SILVER/FM',
							'ice black',
							'HBPFInoxL',
							'(R)B6-Z/M',
							'MtBMTSilv',
							'HBpfinoxl',
							'GBFP(CHP)',
							'Алмаз мэт',
							'mat black',
							'W-LP-(B)Z',
							'bpinoxlip',
							'hsinoxlip',
							'hbinoxlip',
							'silvmfsl',
							'Mtbinoxf',
							'HSinoxfl',
							'MtBinoxL',
							'Mtsinoxl',
							'BMfinoxl',
							'TITANIUM',
							'MtBCHINS',
							'BSL+GOLD',
							'B/RL/RLS',
							'BSCL LUX',
							'CB/RL/UC',
							'HS/WL/UC',
							'D.BL.POL',
							'Gunmetal',
							'BSL+BLUE',
							'BLACK/FM',
							'MtBPBluL',
							'бл.плат.',
							'MtBInoxL',
							'черн.лак',
							'Matt BMF',
							'HB6-(R)Z',
							'GOLD CRV',
							'titanium',
							'mlmucmcr',
							'binoxlip',
							'CB/RL/RC',
							'BMFInoxL',
							'MtBInoxF',
							'graphite',
							'HS/ML/ME',
							'BInoxF/L',
							'HS/RL/UC',
							'CB/WL/UC',
							'CB/ML/ME',
							'MtSInoxL',
							'BK-JRD/P',
							'cawlwpb',
							'DDN-F/P',
							'SDS-F/P',
							'HPT-IRD',
							'HPT-IRD',
							'HPT-D/P',
							'DB/CW-P',
							'MtBPRLS',
							'MtBPblu',
							'WPL FLY',
							'MOB Lux',
							'MtBPBlu',
							'MСMO RB',
							'Mercury',
							'G/RL/UC',
							'Y/RL/UC',
							'Y/WL/UC',
							'HS Inox',
							'W/RL/UC',
							'W/BL/UC',
							'RL/MC/G',
							'CA-W-PB',
							'HSInoxL',
							'(R)W6-Z',
							'B/RL/UC',
							'MOCB/RL',
							'G/ML/ME',
							'B/ML/ME',
							'hsinoxf',
							'(RL)W-X',
							'HBInoxF',
							'BPInoxL',
							'HBInoxL',
							'(RL)BPX',
							'(RL)WPX',
							'B/RL/RE',
							'BSL+RED',
							'AC2/PHB',
							'GBRCPRL',
							'сильвер',
							'бинарио',
							'HSinoxl',
							'HBinoxl',
							'Либерия',
							'Хай вэй',
							'Сильвер',
							'HBInoxf',
							'HSinoxf',
							'BPInoxl',
							'BInoxfl',
							'HPT-IBL',
							'SPT-D/P',
							'BK/CW-P',
							'SPT-D/P',
							'Хай вей',
							'алмчерн',
							'алмвайт',
							'Тармак',
							'Аляска',
							'MBM/LB',
							'MCB/RL',
							'IMP CB',
							'MBM RL',
							'SPT ST',
							'селена',
							'DarkGM',
							'BPBluL',
							'MBMFRL',
							'silver',
							'BInoxl',
							'CMBKF1',
							'BMF/RL',
							'GM-F/P',
							'mirror',
							'S Inox',
							'B Inox',
							'cbwluc',
							'hsrluc',
							'mocbrl',
							'W Inox',
							'MOW/RL',
							'HCHROM',
							'(R)B-P',
							'(R)W-P',
							'BHCH-P',
							'W-LP-Z',
							'hswluc',
							'cbrluc',
							'BML+ML',
							'CHROME',
							'BInoxF',
							'HSInox',
							'графит',
							'SILVER',
							'HB/SSR',
							'brlrls',
							'deluxe',
							'Silver',
							'MOW/BL',
							'GBFPRL',
							'CK-P/M',
							'MTATRL',
							'MCIGM2',
							'XMIAGR',
							'Chrome',
							'черный',
							'MtBPRL',
							'CA-W-P',
							'BInoxL',
							'MGoldL',
							'DFMGM2',
							'XFMGM2',
							'WPBluL',
							'WBCPBL',
							'(W)Z/M',
							'BK-F/P',
							'DB-F/P',
							'HS-D/P',
							'DB/LRD',
							'IMP-CB',
							'CBG/ST',
							'силвер',
							'блплат',
							'BKPRS',
							'BKRSI',
							'GMBSI',
							'GMRSI',
							'MBFRS',
							'MBRSI',
							'WFRSI',
							'RSP/M',
							'gblul',
							'DB/ST',
							'MUTBS',
							'JRMBS',
							'UBBKF',
							'TSilv',
							'White',
							'RSILV',
							'BHCHP',
							'BM-CS',
							'HB-CS',
							'MWO/Y',
							'BMCRL',
							'BK-FP',
							'WHITE',
							'BPBlu',
							'BETBS',
							'Black',
							'JRGMF',
							'MB/RL',
							'CB/RL',
							'MG/ML',
							'CB/Ri',
							'CB/ML',
							'mowbl',
							'rlmcg',
							'HS/RL',
							'yrluc',
							'wbluc',
							'brluc',
							'CB/WL',
							'HB/RL',
							'BK+MF',
							'CHROM',
							'GreyM',
							'BLACK',
							'FB/PL',
							'BK+MS',
							'MLOHS',
							'CB/YL',
							'HS/ML',
							'grluc',
							'ywluc',
							'B-P/M',
							'IRMBK',
							'JRMBK',
							'MtBSF',
							'HS6-Z',
							'GMX/T',
							'белый',
							'e6rzm',
							'e6wzm',
							'b6rzm',
							'cawpb',
							'MtBPL',
							'MtBPR',
							'URMBK',
							'IBMBK',
							'BK/MF',
							'FB/MF',
							'mowrl',
							'wrluc',
							'венге',
							'GM/MF',
							'GBSFP',
							'GMLPU',
							'satin',
							'HB/PL',
							'SSDAP',
							'BE/PW',
							'граф.',
							'SB/MF',
							'XMIHG',
							'FMGM3',
							'BH-CH',
							'MtAtP',
							'BRAGF',
							'HPBCL',
							'U3TBS',
							'Mtbsf',
							'CBKF1',
							'CHPB1',
							'XMIHB',
							'MtBRL',
							'HB6-Z',
							'PHBSL',
							'SILV.',
							'PHSSL',
							'FB/PF',
							'white',
							'FMGM2',
							'MIHBD',
							'HS/PL',
							'XFMBK',
							'cawpb',
							'HB/SL',
							'HS-LP',
							'XMIBK',
							'MBMF',
							'BKPL',
							'MBYS',
							'MatB',
							'MUKF',
							'JRBK',
							'STUB',
							'MTBS',
							'IRMW',
							'UTBS',
							'MGBM',
							'B/RL',
							'HSML',
							'STHB',
							'mtgp',
							'MGMF',
							'FBMF',
							'GMMF',
							'MIBM',
							'BKMF',
							'MTAT',
							'ауди',
							'HBLP',
							'ML/B',
							'MBKV',
							'B/Ri',
							'B/Wi',
							'W/RL',
							'BKVR',
							'CBK1',
							'CBPU',
							'B/YL',
							'TMBK',
							'MBKF',
							'CHP1',
							'G/ML',
							'MLHB',
							'chr.',
							'B/PL',
							'BF/R',
							'BE-P',
							'RSPM',
							'W4BH',
							'B/FM',
							'S+PF',
							'B+CL',
							'B/PF',
							'PHBM',
							'B/ML',
							'MLHS',
							'B/LP',
							'BPRL',
							'GMLP',
							'HSLP',
							'G/RL',
							'W/BL',
							'silv',
							'BLSP',
							'GPGL',
							'MtBP',
							'граф',
							'WPRL',
							'mlog',
							'Inox',
							'gold',
							'HPBL',
							'PWCL',
							'BKCL',
							'CBBL',
							'hsrl',
							'cbrl',
							'mlcb',
							'mohs',
							'mgml',
							'mbrl',
							'HBCL',
							'DBCL',
							'EM/M',
							'MtGP',
							'MIGS',
							'MIBK',
							'DGMF',
							'HB-B',
							'MBTR',
							'GBLP',
							'OHCH',
							'BMFL',
							'GBFP',
							'BE-R',
							'HS-P',
							'MIHB',
							'BP/M',
							'W-LP',
							'W6-Z',
							'GOLD',
							'HB-P',
							'FMBK',
							'BHCH',
							'GM/P',
							'SM/P',
							'SL/S',
							'FGMF',
							'DB-P',
							'MBF',
							'FSF',
							'MDG',
							'BEP',
							'MLW',
							'MSB',
							'BLP',
							'HSB',
							'GPL',
							'POL',
							'MDB',
							'BRL',
							'LHB',
							'MIB',
							'BPL',
							'GMJ',
							'CBK',
							'Fgm',
							'Fmg',
							'glp',
							'ARB',
							'MBK',
							'MBS',
							'SSD',
							'HPT',
							'PWL',
							'MWF',
							'AWB',
							'AUB',
							'CBl',
							'chc',
							'CHR',
							'MCB',
							'CBG',
							'MMB',
							'cbl',
							'AZR',
							'AZU',
							'BWi',
							'Mcg',
							'U4B',
							'BMW',
							'HS1',
							'B1A',
							'FMS',
							'HCH',
							'BPX',
							'MIS',
							'GFM',
							'SSL',
							'S/P',
							'BSP',
							'BSL',
							'S/J',
							'GM4',
							'H/S',
							'BMF',
							'HBD',
							'HSP',
							'BPR',
							'MGR',
							'MtB',
							'GPF',
							'MBB',
							'GMP',
							'CHP',
							'BML',
							'DBF',
							'WBL',
							'SPA',
							'SMF',
							'SPX',
							'GRY',
							'BLK',
							'MGM',
							'MLM',
							'BKF',
							'МBK',
							'MHS',
							'RCL',
							'BKL',
							'GMF',
							'MLB',
							'GLP',
							'GBP',
							'ShB',
							'HPL',
							'HPB',
							'MLG',
							'mcg',
							'wbl',
							'MHB',
							'DBM',
							'PHB',
							'GSP',
							'PHS',
							'SIL',
							'DGM',
							'grl',
							'мэт',
							'crv',
							'MLS',
							'cbk',
							'mly',
							'mcb',
							'W-X',
							'SLP',
							'U3B',
							'MUB',
							'В1Х',
							'MUV',
							'Мэт',
							'AGF',
							'Айс',
							'WRS',
							'BKF',
							'GMF',
							'WB',
							'WR',
							'CB',
							'HP',
							'CG',
							'WL',
							'CH',
							'MY',
							'НS',
							'WP',
							'GL',
							'BK',
							'S1',
							'DB',
							'SL',
							'MR',
							'MA',
							'PW',
							'UB',
							'S2',
							'KF',
							'RE',
							'GM',
							'VW',
							'WF',
							'TS',
							'MW',
							'SM',
							'MG',
							'SD',
							'E6',
							'EP',
							'RW',
							'BF',
							'вd',
							'HB',
							'SF',
							'HS',
							'GR',
							'SP',
							'BP',
							'BE',
							'MS',
							'MB',
							'BU',
							'TM',
							'B4',
							'GP',
							'BM',
							'RC',
							'KP',
							'B1',
							'BB',
							'S4',
							'FS',
							'GB',
							'LS',
							'CS',
							'FW',
							'BD',
							'TB',
							'ER',
							'G',
							'S',
							'W',
							'H',
							'B',
							'Y',
							'A',
						);
	
	
	public function admin_import() {
		//echo "22222";
		//exit();
		$this->layout = 'admin';
		$this->loadModel('Import');
		$this->loadModel('Currency');
		
		//echo"11111";
		//print_r($this->request->data);
		if (!empty($this->request->data)) {
			//echo"2222";
			//exit();
			$this->Import->set($this->request->data);
			if ($this->Import->validates()) {
				app::import('Vendor', 'Spreadsheet_Excel_Reader', array('file' => 'phpExcelReader' . DS . 'Excel' . DS . 'reader.php'));
				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('UTF-8');
				if ($data->read(TMP . $this->Import->tmp_file)) {
					$this->Currency->id = $this->request->data['Import']['currency_id'];
					$rate = 1;
					if ($currency = $this->Currency->read()) {
						$rate = $currency['Currency']['rate'];
					}
					unlink(TMP . $this->Import->tmp_file);
					$total_rows = 0;
					$skipped_rows = 0;
					$updated_products = 0;
					$created_products = 0;
					$created_brands = 0;
					$created_models = 0;
					$not_updated_products = 0;
					$nothing_update_products = 0;
					$not_created_products = 0;
					$error_lines = array();
					$need_to_create_brands = array();
					$this->loadModel('Brand');
					$this->loadModel('BrandModel');
					$this->loadModel('Product');
					$this->loadModel('ModelSynonym');
					$this->loadModel('BrandSynonym');
					$in_stock = $this->request->data['Import']['in_stock'];
					$only_prices = $this->request->data['Import']['only_prices'];
					$ignore_prices = $this->request->data['Import']['ignore_prices'];
					$only_suppliers = $this->request->data['Import']['only_suppliers'];
					$supplier_id = abs(intval($this->request->data['Import']['supplier_id']));
					$recount_brands = array();
					$recount_models = array();
					
					switch ($this->request->data['Import']['type']) {
						case 1:
							$category_id = 3;
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}
							//debug($data->sheets[0]['cells']);
							for ($i = 7; $i <= $data->sheets[0]['numRows']; $i++) {
								if (isset($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$brand_id = null;
									$model_id = null;
									$brand_name = trim($data->sheets[0]['cells'][$i][1]);
									$model_name = trim($data->sheets[0]['cells'][$i][2]);
									$brand = $this->_clean_text($brand_name);
									$model = $this->_clean_text($model_name, false);
									$ah = trim($data->sheets[0]['cells'][$i][3]);
									$current = trim($data->sheets[0]['cells'][$i][4]);
									$size = trim($data->sheets[0]['cells'][$i][5]);
									$f1 = '';
									if (isset($data->sheets[0]['cells'][$i][6])) {
										$f1 = trim($data->sheets[0]['cells'][$i][6]);
									}
									$f2 = trim($data->sheets[0]['cells'][$i][7]);
									$price = floatval(trim($data->sheets[0]['cells'][$i][8])) / $rate;
									$stock_count = intval(trim($data->sheets[0]['cells'][$i][9]));
									$size = str_replace('х', 'x', $size);
									if (substr_count($size, 'x') == 2) {
										list($width, $length, $height) = explode('x', $size);
										if (isset($brands[$brand])) {
											$brand_id = $brands[$brand];
											if (isset($models[$brand_id][$model])) {
												$model_id = $models[$brand_id][$model];
											}
											else {
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name,
													'slug' => $this->_transliterate($model_name)
												);
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)) {
													$created_models ++;
													$model_id = $this->BrandModel->id;
													$models[$brand_id][$model] = $model_id;
												}
											}
										}
										else {
											if (isset($need_to_create_brands[$brand_name])) {
												$need_to_create_brands[$brand_name][] = $i;
											}
											else {
												$need_to_create_brands[$brand_name] = array($i);
											}
											/*
											$slug = $this->_transliterate($brand_name);
											$check_slug = $slug;
											$j = 2;
											while (isset($brand_slugs[$check_slug])) {
												$check_slug = $slug . $j;
												$j ++;
											}
											$brand_slugs[$check_slug] = 1;
											$slug = $check_slug;
											$save_data = array(
												'is_active' => 1,
												'category_id' => $category_id,
												'title' => $brand_name,
												'slug' => $slug,
												'meta_title' => $brand_name
											);
											$this->Brand->create();
											if ($this->Brand->save($save_data)) {
												$created_brands ++;
												$brand_id = $this->Brand->id;
												$recount_brands[] = $brand_id;
												$brands[$brand] = $brand_id;
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name
												);
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)) {
													$created_models ++;
													$model_id = $this->BrandModel->id;
													$recount_models[] = $model_id;
													$models[$brand_id][$model] = $model_id;
												}
											}
											*/
										}
										if (!empty($brand_id) && !empty($model_id)) {
											if (!in_array($brand_id, $recount_brands)) {
												$recount_brands[] = $brand_id;
											}
											if (!in_array($model_id, $recount_models)) {
												$recount_models[] = $model_id;
											}
											$conditions = array(
												'Product.brand_id' => $brand_id,
												'Product.model_id' => $model_id,
												'Product.category_id' => $category_id,
												'Product.ah' => $ah,
												'Product.current' => $current,
												'Product.width' => $width,
												'Product.length' => $length,
												'Product.height' => $height,
												'Product.f1' => $f1,
												'Product.f2' => $f2
											);
											if ($only_prices) {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
													if ($price != $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->saveField('price', $price)) {
																$this->Product->saveField('supplier_id', $supplier_id);
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
											}
											else {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
													$save_data = array();
													if ($price <= $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$save_data['price'] = $price;
															$save_data['supplier_id'] = $supplier_id;
															if ($stock_count != $product['Product']['stock_count']) {
																$save_data['stock_count'] = $stock_count;
															}
															if ($in_stock != $product['Product']['in_stock']) {
																$save_data['in_stock'] = $in_stock;
															}
															if (!empty($save_data)) {
																$this->Product->id = $product['Product']['id'];
																if ($this->Product->save($save_data, false)) {
																	$updated_products ++;
																}
																else {
																	$not_updated_products ++;
																	debug($this->Product->validationErrors);
																}
															}
															else {
																$nothing_update_products ++;
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$save_data = array(
														'is_active' => 1,
														'supplier_id' => $supplier_id,
														'brand_id' => $brand_id,
														'model_id' => $model_id,
														'category_id' => $category_id,
														'ah' => $ah,
														'current' => $current,
														'width' => $width,
														'length' => $length,
														'height' => $height,
														'f1' => $f1,
														'f2' => $f2,
														'price' => $price,
														'stock_count' => $stock_count,
														'in_stock' => $in_stock
													);

                                                    if ($in_stock != 1 && $stock_count != $product['Product']['count_out_of_stock']) {
                                                        $save_data['count_out_of_stock'] = $stock_count;
                                                    }

													$this->Product->create();
													if ($this->Product->save($save_data)) {

														$created_products ++;
													}
													else {
														$not_created_products ++;
														debug($this->Product->validationErrors);
													}
												}
											}
										}
									}
								}
								else {
									$skipped_rows ++;
								}
							}
							break;
						case 2:
							$category_id = 2;
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}
							for ($i = 6; $i <= $data->sheets[0]['numRows']; $i++) {
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$brand_id = null;
									$model_id = null;

									$data->sheets[0]['cells'][$i][2] = str_replace(array('J', 'j'), '', $data->sheets[0]['cells'][$i][2]);
									$data->sheets[0]['cells'][$i][2] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][2]);
									$data->sheets[0]['cells'][$i][4] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][4]);
									$size = trim($data->sheets[0]['cells'][$i][1]);
									$size3 = trim($data->sheets[0]['cells'][$i][2]);
									$et = str_replace('ET', '', trim($data->sheets[0]['cells'][$i][3]));
									$hub = trim($data->sheets[0]['cells'][$i][4]);
									$size = str_replace(',', '.', $size);
									$size3 = str_replace(',', '.', $size3);
									$et = str_replace(',', '.', $et);
									$hub = str_replace(',', '.', $hub);
									$brand_name = trim($data->sheets[0]['cells'][$i][5]);
									$model_name = trim($data->sheets[0]['cells'][$i][6]);
									$brand = $this->_clean_text($brand_name);
									$model = $this->_clean_text($model_name, false);
									$color = trim($data->sheets[0]['cells'][$i][7]);
									$price = floatval(trim($data->sheets[0]['cells'][$i][8])) / $rate;
									$stock_count = intval(trim($data->sheets[0]['cells'][$i][9]));
									list($size1, $size2) = explode(' ', preg_replace('/ +/', ' ', $size));
									if (isset($brands[$brand])) {
										$brand_id = $brands[$brand];
										if (isset($models[$brand_id][$model])) {
											$model_id = $models[$brand_id][$model];
										}
										else {
											$save_data = array(
												'is_active' => 1,
												'brand_id' => $brand_id,
												'category_id' => $category_id,
												'title' => $model_name,
												'meta_title' => $model_name,
												'slug' => $this->_transliterate($model_name)
											);
											$this->BrandModel->create();
											if ($this->BrandModel->save($save_data)) {
												$created_models ++;
												$model_id = $this->BrandModel->id;
												$recount_models[] = $model_id;
												$models[$brand_id][$model] = $model_id;
											}
										}
									}
									else {
										if (isset($need_to_create_brands[$brand_name])) {
											$need_to_create_brands[$brand_name][] = $i;
										}
										else {
											$need_to_create_brands[$brand_name] = array($i);
										}
										/*
										$slug = $this->_transliterate($brand_name);
										$check_slug = $slug;
										$j = 2;
										while (isset($brand_slugs[$check_slug])) {
											$check_slug = $slug . $j;
											$j ++;
										}
										$brand_slugs[$check_slug] = 1;
										$slug = $check_slug;
										$save_data = array(
											'is_active' => 1,
											'category_id' => $category_id,
											'title' => $brand_name,
											'slug' => $slug,
											'meta_title' => $brand_name
										);
										$this->Brand->create();
										if ($this->Brand->save($save_data)) {
											$created_brands ++;
											$brand_id = $this->Brand->id;
											$recount_brands[] = $brand_id;
											$brands[$brand] = $brand_id;
											$save_data = array(
												'is_active' => 1,
												'brand_id' => $brand_id,
												'category_id' => $category_id,
												'title' => $model_name,
												'meta_title' => $model_name
											);
											$this->BrandModel->create();
											if ($this->BrandModel->save($save_data)) {
												$created_models ++;
												$model_id = $this->BrandModel->id;
												$recount_models[] = $model_id;
												$models[$brand_id][$model] = $model_id;
											}
										}
										*/
									}
									if (!empty($brand_id) && !empty($model_id)) {
										if (!in_array($brand_id, $recount_brands)) {
											$recount_brands[] = $brand_id;
										}
										if (!in_array($model_id, $recount_models)) {
											$recount_models[] = $model_id;
										}
										$conditions = array(
											'Product.brand_id' => $brand_id,
											'Product.model_id' => $model_id,
											'Product.category_id' => $category_id,
											'Product.size1' => $size1,
											'Product.size2' => $size2,
											'Product.size3' => $size3,
											'Product.et' => $et,
											'Product.hub' => $hub
										);
										if (!empty($color)) {
											$conditions['Product.color'] = $color;
										}
										if ($only_prices) {
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price')))) {
												if ($price != $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$this->Product->id = $product['Product']['id'];
														if ($this->Product->saveField('price', $price)) {
															$this->Product->saveField('supplier_id', $supplier_id);
															$updated_products ++;
														}
														else {
															$not_updated_products ++;
															debug($this->Product->validationErrors);
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
										}
										else {
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
												$save_data = array();
												if ($price <= $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$save_data['price'] = $price;
														$save_data['supplier_id'] = $supplier_id;
														if ($stock_count != $product['Product']['stock_count']) {
															$save_data['stock_count'] = $stock_count;
														}
														if ($in_stock != $product['Product']['in_stock']) {
															$save_data['in_stock'] = $in_stock;
														}
														if (!empty($save_data)) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->save($save_data, false)) {
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
											else {
												$sku = $brand_name . ' ' . $model_name . ' ' . $size3 . 'x' . $size1 . ' ' . $size2 . ' ET ' . $et . ' Dia ' . $hub;
												if (!empty($color)) {
													$sku .= ' (' . $color . ')';
												}
												$save_data = array(
													'is_active' => 1,
													'supplier_id' => $supplier_id,
													'brand_id' => $brand_id,
													'model_id' => $model_id,
													'category_id' => $category_id,
													'size1' => $size1,
													'size2' => $size2,
													'size3' => $size3,
													'et' => $et,
													'hub' => $hub,
													'color' => $color,
													'sku' => $sku,
													'price' => $price,
													'in_stock' => $in_stock,
													'stock_count' => $stock_count
												);
												$this->Product->create();
												if ($this->Product->save($save_data)) {
													$created_products ++;
												}
												else {
													$not_created_products ++;
													debug($this->Product->validationErrors);
												}
											}
										}
									}
								}
								else {
									$skipped_rows ++;
								}
							}
							break;
						case 3:
							$category_id = 2;
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.filename', 'BrandModel.title')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							$model_photos = array();
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model_photos[$item['BrandModel']['id']] = !empty($item['BrandModel']['filename']);
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}

							for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$brand_id = null;
									$model_id = null;
									$data->sheets[0]['cells'][$i][4] = str_replace(array('J', 'j'), '', $data->sheets[0]['cells'][$i][4]);
									$data->sheets[0]['cells'][$i][4] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][4]);
									$data->sheets[0]['cells'][$i][8] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][8]);
									$brand_name = trim($data->sheets[0]['cells'][$i][1]);
									$model_name = trim($data->sheets[0]['cells'][$i][2]);
									$brand = $this->_clean_text($brand_name);
									$model = $this->_clean_text($model_name, false);
									$size3 = trim($data->sheets[0]['cells'][$i][4]);
									$size1 = trim($data->sheets[0]['cells'][$i][5]);
									$size2 = $data->sheets[0]['cells'][$i][12] . 'x' . $data->sheets[0]['cells'][$i][6];
									$color = isset($data->sheets[0]['cells'][$i][10]) ? trim($data->sheets[0]['cells'][$i][10]) : '';
									$material = isset($data->sheets[0]['cells'][$i][11]) ? trim($data->sheets[0]['cells'][$i][11]) : '';
									$et = trim($data->sheets[0]['cells'][$i][8]);
									$hub = trim($data->sheets[0]['cells'][$i][9]);
									$size1 = str_replace(',', '.', $size1);
									$size2 = str_replace(',', '.', $size2);
									$size3 = str_replace(',', '.', $size3);
									$et = str_replace(',', '.', $et);
									$hub = str_replace(',', '.', $hub);
									$price = floatval(trim($data->sheets[0]['cells'][$i][15])) / $rate;
									$stock_count = intval(trim($data->sheets[0]['cells'][$i][14]));
									if (isset($brands[$brand])) {
										$brand_id = $brands[$brand];
										if (isset($models[$brand_id][$model])) {
											$model_id = $models[$brand_id][$model];
										}
										else {
											$save_data = array(
												'is_active' => 1,
												'brand_id' => $brand_id,
												'category_id' => $category_id,
												'title' => $model_name,
												'meta_title' => $model_name,
												'slug' => $this->_transliterate($model_name)
											);
											$this->BrandModel->create();
											if ($this->BrandModel->save($save_data)) {
												$created_models ++;
												$model_id = $this->BrandModel->id;
												$recount_models[] = $model_id;
												$model_photos[$model_id] = false;
												$models[$brand_id][$model] = $model_id;
											}
										}
									}
									else {
										if (isset($need_to_create_brands[$brand_name])) {
											$need_to_create_brands[$brand_name][] = $i;
										}
										else {
											$need_to_create_brands[$brand_name] = array($i);
										}
										/*
										$slug = $this->_transliterate($brand_name);
										$check_slug = $slug;
										$j = 2;
										while (isset($brand_slugs[$check_slug])) {
											$check_slug = $slug . $j;
											$j ++;
										}
										$brand_slugs[$check_slug] = 1;
										$slug = $check_slug;
										$save_data = array(
											'is_active' => 1,
											'category_id' => $category_id,
											'title' => $brand_name,
											'slug' => $slug,
											'meta_title' => $brand_name
										);
										$this->Brand->create();
										if ($this->Brand->save($save_data)) {
											$created_brands ++;
											$brand_id = $this->Brand->id;
											$recount_brands[] = $brand_id;
											$brands[$brand] = $brand_id;
											$save_data = array(
												'is_active' => 1,
												'brand_id' => $brand_id,
												'category_id' => $category_id,
												'title' => $model_name,
												'meta_title' => $model_name
											);
											$this->BrandModel->create();
											if ($this->BrandModel->save($save_data)) {
												$created_models ++;
												$model_id = $this->BrandModel->id;
												$recount_models[] = $model_id;
												$model_photos[$model_id] = false;
												$models[$brand_id][$model] = $model_id;
											}
										}
										*/
									}
									if (!empty($brand_id) && !empty($model_id)) {
										if (!in_array($brand_id, $recount_brands)) {
											$recount_brands[] = $brand_id;
										}
										if (!in_array($model_id, $recount_models)) {
											$recount_models[] = $model_id;
										}
										if (!empty($material)) {
											$model_material = null;
											$m = mb_strtolower(trim($material));
											if ($m == 'стальные' || $m == 'стальной') {
												$model_material = 'steel';
											}
											elseif ($m == 'литые' || $m == 'литой') {
												$model_material = 'cast';
											}
											elseif ($m == 'кованные' || $m == 'кованный') {
												$model_material = 'forged';
											}
											if (!empty($model_material)) {
												$this->BrandModel->id = $model_id;
												$this->BrandModel->saveField('material', $model_material);
											}
										}
										if (!$model_photos[$model_id] && !empty($data->sheets[0]['cells'][$i][22])) {
											$filename = str_replace('/', DS, $data->sheets[0]['cells'][$i][22]);
											if (is_file(ROOT . DS . $filename)) {
												$save_data = array();
												$save_data['file']['tmp_name'] = ROOT . DS . $filename;
												$save_data['file']['name'] = '1.jpg';
												$save_data['file']['type'] = 'image/jpeg';
												$this->BrandModel->id = $model_id;
												if ($this->BrandModel->save($save_data, false)) {
													$model_photos[$model_id] = true;
												}
												$this->BrandModel->tmp_file = null;
											}
										}
										$conditions = array(
											'Product.brand_id' => $brand_id,
											'Product.model_id' => $model_id,
											'Product.category_id' => $category_id,
											'Product.size1' => $size1,
											'Product.size2' => $size2,
											'Product.size3' => $size3,
											'Product.et' => $et,
											'Product.hub' => $hub
										);
										if (!empty($color)) {
											$conditions['Product.color'] = $color;
										}
										if (!empty($material)) {
											$conditions['Product.material'] = $material;
										}
										if ($only_prices) {
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
												if ($price != $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$this->Product->id = $product['Product']['id'];
														if ($this->Product->saveField('price', $price)) {
															$this->Product->saveField('supplier_id', $supplier_id);
															$updated_products ++;
														}
														else {
															$not_updated_products ++;
															debug($this->Product->validationErrors);
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
										}
										else {
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
												$save_data = array();
												if ($price <= $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$save_data['price'] = $price;
														$save_data['supplier_id'] = $supplier_id;
														if ($stock_count != $product['Product']['stock_count']) {
															$save_data['stock_count'] = $stock_count;
														}
														if ($in_stock != $product['Product']['in_stock']) {
															$save_data['in_stock'] = $in_stock;
														}
														if (!empty($save_data)) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->save($save_data, false)) {
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
											else {
												$sku = $brand_name . ' ' . $model_name . ' ' . $size3 . 'x' . $size1 . ' ' . $size2 . ' ET ' . $et . ' Dia ' . $hub;
												if (!empty($color)) {
													$sku .= ' (' . $color . ')';
												}
												$save_data = array(
													'is_active' => 1,
													'supplier_id' => $supplier_id,
													'brand_id' => $brand_id,
													'model_id' => $model_id,
													'category_id' => $category_id,
													'size1' => $size1,
													'size2' => $size2,
													'size3' => $size3,
													'et' => $et,
													'hub' => $hub,
													'color' => $color,
													'material' => $material,
													'sku' => $sku,
													'price' => $price,
													'stock_count' => $stock_count,
													'in_stock' => $in_stock
												);
												$this->Product->create();
												if ($this->Product->save($save_data)) {
													$created_products ++;
												}
												else {
													$not_created_products ++;
													debug($this->Product->validationErrors);
												}
											}
										}
									}
								}
								else {
									$skipped_rows ++;
								}
							}
							break;
						case 4:
							$category_id = 1;
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title'), 'order' => array('LENGTH(BrandModel.title)' => 'desc')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}
							//debug($data->sheets[0]['cells']);exit();
							for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$brand_id = null;
									$model_id = null;
									$brand_name = trim($data->sheets[0]['cells'][$i][2]);
									$title = trim($data->sheets[0]['cells'][$i][3]);
									$brand = $this->_clean_text($brand_name);
									$size = trim($data->sheets[0]['cells'][$i][1]);
									$axis_text = mb_strtolower(trim($data->sheets[0]['cells'][$i][8]));
									$auto = 'cars';
									$axis = '';
									if (substr_count($axis_text, 'руль+прицеп')) {
										$auto = 'trucks';
										$axis = 'универсальная';
									}
									elseif (substr_count($axis_text, 'прицеп+руль')) {
										$auto = 'trucks';
										$axis = 'универсальная';
									}
									elseif (substr_count($axis_text, 'тяга+руль')) {
										$auto = 'trucks';
										$axis = 'универсальная';
									}
									elseif (substr_count($axis_text, 'руль+тяга')) {
										$auto = 'trucks';
										$axis = 'универсальная';
									}
									elseif (substr_count($axis_text, 'прицеп')) {
										$auto = 'trucks';
										$axis = 'прицеп';
									}
									elseif (substr_count($axis_text, 'тяга')) {
										$auto = 'trucks';
										$axis = 'тяга';
									}
									elseif (substr_count($axis_text, 'руль')) {
										$auto = 'trucks';
										$axis = 'руль';
									}
									elseif (substr_count($axis_text, 'универсальная')) {
										$auto = 'trucks';
										$axis = 'универсальная';
									}
									if (isset($data->sheets[0]['cells'][$i][7])) {
										$type = mb_strtolower(trim($data->sheets[0]['cells'][$i][7]));
										if ($type == 'г') {
											$auto = 'trucks';
										}
										elseif ($type == 'лг') {
											$auto = 'light_trucks';
										}
										elseif ($type == 'сх') {
											$auto = 'agricultural';
										}
										elseif ($type == 'мото') {
											$auto = 'moto';
										}
										elseif ($type == 'джип') {
											$auto = 'cars';
										}
                                        elseif ($type == 'спецтранспорт') {
                                            $auto = 'special';
                                        }
									}
									$stud = 0;
									if (isset($data->sheets[0]['cells'][$i][8])) {
										$stud_text = mb_strtolower(trim($data->sheets[0]['cells'][$i][8]));
										if ($stud_text == 'шип' || $stud_text == 'ш') {
											$stud = 1;
										}
										elseif ($stud_text == 'подшип' || $stud_text == 'пш') {
											$stud = 0;
										}
										else {
											$stud = 0;
										}
									}
									$last_space = mb_strrpos($title, ' ');
									if ($last_space === false) {
										$error_lines[] = $i;
										$skipped_rows ++;
										continue;
									}
									$f = mb_substr($title, $last_space + 1);
									if (mb_strlen($f) < 3) {
										$error_lines[] = $i;
										$skipped_rows ++;
										continue;
									}
									$f1 = mb_substr($f, 0, -1);
									$f2 = mb_substr($f, -1);
									$model_name = trim(str_replace($f, '', $title));
									$model = $this->_clean_text($model_name, false);
									$delimiter = null;
									if (substr_count($size, '/') == 1) {
										$size = str_replace('R', '/', $size);
									}
									elseif (substr_count($size, '-') == 1) {
										$size = str_replace('R', '-', $size);
									}
									if (substr_count($size, '/') == 2) {
										$delimiter = '/';
									}
									elseif (substr_count($size, '-') == 2) {
										$delimiter = '-';
									}
									else {
										$size = str_replace(' ', '', $size);
										if (substr_count($size, 'R') == 1) {
											list($size1, $size3) = explode('R', $size);
											$size1 = intval($size1);
											$size = implode('/', array($size1, '', $size3));
											$delimiter = '/';
										}
										elseif (substr_count($size, '/') == 1) {
											list($size1, $size3) = explode('/', $size);
											$size1 = intval($size1);
											$size = implode('/', array($size1, '', $size3));
											$delimiter = '/';
										}
									}
									if (!empty($delimiter)) {
										list($size1, $size2, $size3) = explode($delimiter, $size);
										$price = floatval(trim($data->sheets[0]['cells'][$i][5])) / $rate;
										$stock_count = intval(trim($data->sheets[0]['cells'][$i][6]));
										$season = 'summer';
										$season_text = mb_strtolower($data->sheets[0]['cells'][$i][4]);
										if (!empty($season_text)) {
											if ($season_text == 'в') {
												$season = 'all';
											}
											elseif ($season_text == 'з') {
												$season = 'winter';
											}
											elseif ($season_text == 'л') {
												$season = 'summer';
											}
										}
										if (isset($brands[$brand])) {
											$brand_id = $brands[$brand];
											if (isset($models[$brand_id][$model])) {
												$model_id = $models[$brand_id][$model];
											}
											else {
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name,
													'slug' => $this->_transliterate($model_name)
												);
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)) {
													$created_models ++;
													$model_id = $this->BrandModel->id;
													$recount_models[] = $model_id;
													$model_photos[$model_id] = false;
													$models[$brand_id][$model] = $model_id;
												}
											}
										}
										else {
											if (isset($need_to_create_brands[$brand_name])) {
												$need_to_create_brands[$brand_name][] = $i;
											}
											else {
												$need_to_create_brands[$brand_name] = array($i);
											}
											/*
											$slug = $this->_transliterate($brand_name);
											$check_slug = $slug;
											$j = 2;
											while (isset($brand_slugs[$check_slug])) {
												$check_slug = $slug . $j;
												$j ++;
											}
											$brand_slugs[$check_slug] = 1;
											$slug = $check_slug;
											$save_data = array(
												'is_active' => 1,
												'category_id' => $category_id,
												'title' => $brand_name,
												'slug' => $slug,
												'meta_title' => $brand_name
											);
											$this->Brand->create();
											if ($this->Brand->save($save_data)) {
												$created_brands ++;
												$brand_id = $this->Brand->id;
												$recount_brands[] = $brand_id;
												$brands[$brand] = $brand_id;
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name
												);
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)) {
													$created_models ++;
													$model_id = $this->BrandModel->id;
													$recount_models[] = $model_id;
													$models[$brand_id][$model] = $model_id;
												}
											}
											*/
										}
										if (!empty($brand_id) && !empty($model_id)) {
											if (!in_array($brand_id, $recount_brands)) {
												$recount_brands[] = $brand_id;
											}
											if (!in_array($model_id, $recount_models)) {
												$recount_models[] = $model_id;
											}
											$conditions = array(
												'Product.brand_id' => $brand_id,
												'Product.model_id' => $model_id,
												'Product.category_id' => $category_id,
												'Product.size1' => $size1,
												'Product.size2' => $size2,
												'Product.size3' => $size3,
												'Product.f1' => $f1,
												'Product.f2' => $f2
											);
											if ($stud !== null) {
												$conditions['Product.stud'] = $stud;
											}
											if ($only_prices) {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
													if ($price != $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->saveField('price', $price)) {
																$this->Product->saveField('supplier_id', $supplier_id);
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
											}
											else {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.stud', 'Product.season', 'Product.axis', 'Product.auto', 'Product.supplier_id')))) {
													$save_data = array();
													if ($price < $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$save_data['price'] = $price;
															$save_data['supplier_id'] = $supplier_id;
															if ($stock_count != $product['Product']['stock_count']) {
																$save_data['stock_count'] = $stock_count;
															}
															if ($in_stock != $product['Product']['in_stock']) {
																$save_data['in_stock'] = $in_stock;
															}
															if ($season != $product['Product']['season']) {
																$save_data['season'] = $season;
															}
															if ($auto != $product['Product']['auto']) {
																$save_data['auto'] = $auto;
															}
															if ($axis != $product['Product']['axis']) {
																$save_data['axis'] = $axis;
															}
															if ($stud !== null && $stud != $product['Product']['stud']) {
																$save_data['stud'] = $stud;
															}
															if (!empty($save_data)) {
																$this->Product->id = $product['Product']['id'];
																if ($this->Product->save($save_data, false)) {
																	$updated_products ++;
																}
																else {
																	$not_updated_products ++;
																	debug($this->Product->validationErrors);
																}
															}
															else {
																$nothing_update_products ++;
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													elseif ($price == $product['Product']['price']) {
														if ($stock_count != $product['Product']['stock_count']) {
															$save_data['stock_count'] = $stock_count;
														}
														if ($in_stock != $product['Product']['in_stock']) {
															$save_data['in_stock'] = $in_stock;
														}
														$save_data['supplier_id'] = $supplier_id;
														if (!empty($save_data)) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->save($save_data, false)) {
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$save_data = array(
														'is_active' => 1,
														'supplier_id' => $supplier_id,
														'brand_id' => $brand_id,
														'model_id' => $model_id,
														'category_id' => $category_id,
														'size1' => $size1,
														'size2' => $size2,
														'size3' => $size3,
														'sku' => $title,
														'f1' => $f1,
														'f2' => $f2,
														'season' => $season,
														'auto' => $auto,
														'axis' => $axis,
														'price' => $price,
														'stock_count' => $stock_count,
														'in_stock' => $in_stock
													);
													if ($stud !== null) {
														$save_data['stud'] = $stud;
													}
													$this->Product->create();
													if ($this->Product->save($save_data)) {
														$created_products ++;
													}
													else {
														$not_created_products ++;
														debug($this->Product->validationErrors);
													}
												}
											}
										}
									}
									else {
										$error_lines[] = $i;
										$skipped_rows ++;
									}
								}
								else {
									$skipped_rows ++;
								}
							}
							break;
						case 5:
							$category_id = 1;
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title'), 'order' => array('LENGTH(BrandModel.title)' => 'desc')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}
							//debug($data->sheets[0]['cells']);exit();
							$season = 'summer';
							for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$brand_id = null;
									$model_id = null;
									$brand_name = trim($data->sheets[0]['cells'][$i][2]);
									$title = trim($data->sheets[0]['cells'][$i][3]);
									$brand = $this->_clean_text($brand_name);
									$size = trim($data->sheets[0]['cells'][$i][1]);
									$stud = 0;

									if (substr_count($title, 'под шип')) {
										$stud = 0;
										$title = str_replace('под шип', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'шип')) {
										$stud = 1;
										$title = str_replace('шип', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									$auto = 'cars';
									$axis = '';
									if (substr_count($title, 'руль+прицеп')) {
										$auto = 'trucks';
										$axis = 'универсальная';
										$title = str_replace('руль+прицеп', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'прицеп+руль')) {
										$auto = 'trucks';
										$axis = 'универсальная';
										$title = str_replace('прицеп+руль', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'тяга+руль')) {
										$auto = 'trucks';
										$axis = 'универсальная';
										$title = str_replace('тяга+руль', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'руль+тяга')) {
										$auto = 'trucks';
										$axis = 'универсальная';
										$title = str_replace('руль+тяга', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'прицеп')) {
										$auto = 'trucks';
										$axis = 'прицеп';
										$title = str_replace('прицеп', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'тяга')) {
										$auto = 'trucks';
										$axis = 'тяга';
										$title = str_replace('тяга', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (substr_count($title, 'руль')) {
										$auto = 'trucks';
										$axis = 'руль';
										$title = str_replace('руль', '', $title);
										$title = trim(str_replace('()', '', $title));
									}
									elseif (isset($data->sheets[0]['cells'][$i][8])) {
										$type = mb_strtolower(trim($data->sheets[0]['cells'][$i][8]));
										if ($type == 'г') {
											$auto = 'trucks';
										}
										elseif ($type == 'лг') {
											$auto = 'light_trucks';
										}
										elseif ($type == 'сх') {
											$auto = 'agricultural';
										}
										elseif ($type == 'мото') {
											$auto = 'moto';
										}
										elseif ($type == 'джип') {
											$auto = 'cars';
										}
									}
									$last_space = mb_strrpos($title, ' ');
									if ($last_space === false) {
										$error_lines[] = $i;
										$skipped_rows ++;
										continue;
									}
									$f = mb_substr($title, $last_space + 1);
									if (mb_strlen($f) < 3) {
										$error_lines[] = $i;
										$skipped_rows ++;
										continue;
									}

									$f1 = mb_substr($f, 0, -1);
									$f2 = mb_substr($f, -1);
									$model_name = trim(str_replace(array($brand_name, $f), '', $title));
									$model = $this->_clean_text($model_name, false);
									$delimiter = null;
									if (substr_count($size, '/') == 1) {
										$size = str_replace('R', '/', $size);
									}
									elseif (substr_count($size, '-') == 1) {
										$size = str_replace('R', '-', $size);
									}
									if (substr_count($size, '/') == 2) {
										$delimiter = '/';
									}
									elseif (substr_count($size, '-') == 2) {
										$delimiter = '-';
									}
									else {
										$size = str_replace(' ', '', $size);
										if (substr_count($size, 'R') == 1) {
											list($size1, $size3) = explode('R', $size);
											$size1 = intval($size1);
											$size = implode('/', array($size1, '', $size3));
											$delimiter = '/';
										}
										elseif (substr_count($size, '/') == 1) {
											list($size1, $size3) = explode('/', $size);
											$size1 = intval($size1);
											$size = implode('/', array($size1, '', $size3));
											$delimiter = '/';
										}
									}
									if (!empty($delimiter)) {
										list($size1, $size2, $size3) = explode($delimiter, $size);
										$price = floatval(trim($data->sheets[0]['cells'][$i][6])) / $rate;
										$stock_count = intval(trim($data->sheets[0]['cells'][$i][7]));


										if (isset($brands[$brand])) {
											$brand_id = $brands[$brand];
											if (isset($models[$brand_id][$model])) {
												$model_id = $models[$brand_id][$model];
											}
											else {
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name,
													'slug' => $this->_transliterate($model_name)
												);
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)) {
													$created_models ++;
													$model_id = $this->BrandModel->id;
													$recount_models[] = $model_id;
													$model_photos[$model_id] = false;
													$models[$brand_id][$model] = $model_id;
												}
											}
										}
										else {
											if (isset($need_to_create_brands[$brand_name])) {
												$need_to_create_brands[$brand_name][] = $i;
											}
											else {
												$need_to_create_brands[$brand_name] = array($i);
											}
											/*
											$slug = $this->_transliterate($brand_name);
											$check_slug = $slug;
											$j = 2;
											while (isset($brand_slugs[$check_slug])) {
												$check_slug = $slug . $j;
												$j ++;
											}
											$brand_slugs[$check_slug] = 1;
											$slug = $check_slug;
											$save_data = array(
												'is_active' => 1,
												'category_id' => $category_id,
												'title' => $brand_name,
												'slug' => $slug,
												'meta_title' => $brand_name
											);
											$this->Brand->create();
											if ($this->Brand->save($save_data)) {
												$created_brands ++;
												$brand_id = $this->Brand->id;
												$recount_brands[] = $brand_id;
												$brands[$brand] = $brand_id;
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name
												);
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)) {
													$created_models ++;
													$model_id = $this->BrandModel->id;
													$recount_models[] = $model_id;
													$models[$brand_id][$model] = $model_id;
												}
											}
											*/
										}
										if (!empty($brand_id) && !empty($model_id)) {
											if (!in_array($brand_id, $recount_brands)) {
												$recount_brands[] = $brand_id;
											}
											if (!in_array($model_id, $recount_models)) {
												$recount_models[] = $model_id;
											}
											$conditions = array(
												'Product.brand_id' => $brand_id,
												'Product.model_id' => $model_id,
												'Product.category_id' => $category_id,
												'Product.size1' => $size1,
												'Product.size2' => $size2,
												'Product.size3' => $size3,
												'Product.f1' => $f1,
												'Product.f2' => $f2
											);
											if ($stud !== null) {
												$conditions['Product.stud'] = $stud;
											}
											if ($only_prices) {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
													if ($price != $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->saveField('price', $price)) {
																$this->Product->saveField('supplier_id', $supplier_id);
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
											}
											else {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.stud', 'Product.season', 'Product.axis', 'Product.auto', 'Product.supplier_id')))) {
													$save_data = array();
													if ($price < $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$save_data['price'] = $price;
															$save_data['supplier_id'] = $supplier_id;
															if ($stock_count != $product['Product']['stock_count']) {
																$save_data['stock_count'] = $stock_count;
															}
															if ($in_stock != $product['Product']['in_stock']) {
																$save_data['in_stock'] = $in_stock;
															}
															if ($season != $product['Product']['season']) {
																$save_data['season'] = $season;
															}
															if ($auto != $product['Product']['auto']) {
																$save_data['auto'] = $auto;
															}
															if ($axis != $product['Product']['axis']) {
																$save_data['axis'] = $axis;
															}
															if ($stud !== null && $stud != $product['Product']['stud']) {
																$save_data['stud'] = $stud;
															}
															if (!empty($save_data)) {
																$this->Product->id = $product['Product']['id'];
																if ($this->Product->save($save_data, false)) {
																	$updated_products ++;
																}
																else {
																	$not_updated_products ++;
																	debug($this->Product->validationErrors);
																}
															}
															else {
																$nothing_update_products ++;
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													elseif ($price == $product['Product']['price']) {
														if ($stock_count != $product['Product']['stock_count']) {
															$save_data['stock_count'] = $stock_count;
														}
														if ($in_stock != $product['Product']['in_stock']) {
															$save_data['in_stock'] = $in_stock;
														}
														$save_data['supplier_id'] = $supplier_id;
														if (!empty($save_data)) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->save($save_data, false)) {
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$save_data = array(
														'is_active' => 1,
														'supplier_id' => $supplier_id,
														'brand_id' => $brand_id,
														'model_id' => $model_id,
														'category_id' => $category_id,
														'size1' => $size1,
														'size2' => $size2,
														'size3' => $size3,
														'sku' => $title,
														'f1' => $f1,
														'f2' => $f2,
														'season' => $season,
														'axis' => $axis,
														'auto' => $auto,
														'price' => $price,
														'stock_count' => $stock_count,
														'in_stock' => $in_stock
													);
													if ($stud !== null) {
														$save_data['stud'] = $stud;
													}
													$this->Product->create();
													if ($this->Product->save($save_data)) {
														$created_products ++;
													}
													else {
														$not_created_products ++;
														debug($this->Product->validationErrors);
													}
												}
											}
										}
									}
									else {
										$error_lines[] = $i;
										$skipped_rows ++;
									}
								}
								else {
									if (isset($data->sheets[0]['cells'][$i][3]) && !empty($data->sheets[0]['cells'][$i][3])) {
										$season_text = mb_strtolower($data->sheets[0]['cells'][$i][3]);
										if (!empty($season_text)) {
											if (substr_count($season_text, 'всесезонка')) {
												$season = 'all';
											}
											elseif (substr_count($season_text, 'зима')) {
												$season = 'winter';
											}
											elseif (substr_count($season_text, 'лето')) {
												$season = 'summer';
											}
										}
									}
									$skipped_rows ++;
								}
							}
							break;						
						case 6:
							$category_id = 1;
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.filename', 'BrandModel.title'), 'order' => array('LENGTH(BrandModel.title)' => 'desc')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							$model_photos = array();
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$model_photos[$item['BrandModel']['id']] = !empty($item['BrandModel']['filename']);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}
							for ($i = 1; $i <= count($data->sheets[0]['cells']); $i++) {
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$brand_id = null;
									$model_id = null;
									$axis = '';
									$auto = 'cars';
									$brand_name = trim($data->sheets[0]['cells'][$i][1]);
									if (isset($data->sheets[0]['cells'][$i][2])) {
										$model_name = trim($data->sheets[0]['cells'][$i][2]);
									}
									else {
										$model_name = '';
									}
									$model_name = trim(str_replace(array('(ведущая)', '(грузовой)', '(наварка ведущая)', '(наварка прицеп)', '(наварка универ)', '(прицепная)', '(рулевая)', '(с/х)', '(универсальная)', '(прицеп)'), '', $model_name));
									$title = trim($data->sheets[0]['cells'][$i][3]);
									$title = trim(str_replace(array(' (ведущая)', ' (грузовой)', ' (наварка ведущая)', ' (наварка прицеп)', ' (наварка универ)', ' (прицепная)', ' (рулевая)', ' (с/х)', ' (универсальная)', '(прицеп)'), '', $title));
									$brand = $this->_clean_text($brand_name);
									$model = $this->_clean_text($model_name, false);
									$season_text = trim($data->sheets[0]['cells'][$i][4]);
									$auto_text = mb_strtolower(trim($data->sheets[0]['cells'][$i][5]));
									$stud = null;
									$season = 'summer';
									switch ($season_text) {
										case 'всесезонная':
											$season = 'all';
											break;
										case 'летняя':
											$season = 'summer';
											break;
										case 'зимняя':
											$season = 'winter';
											break;
									}
									if (in_array($auto_text, array('прицепная', 'рулевая', 'тяга', 'универсальная', 'руль', 'прицеп', 'наварная', 'ведущая', 'руль+тяга', 'тяга+руль', 'наварка ведущая', 'наварка прицеп', 'наварка универ', 'руль/прицеп', 'карьерная'))) {
										switch ($auto_text) {
											case 'прицепная':
												$auto_text = 'прицеп';
												break;
                                            case 'карьерная':
                                                $auto_text = 'карьерная';
                                                break;
											case 'ведущая':
												$auto_text = 'ведущая';
												break;
											case 'руль+тяга':
											case 'тяга+руль':
												$auto_text = 'универсальная';
												break;
                                            case 'руль/прицеп':
                                                $auto_text = 'руль/прицеп';
                                                break;
											case 'наварка ведущая':
											case 'наварка прицеп':
											case 'наварка универ':
												$auto_text = 'наварка';
												break;
										}
										$axis = $auto_text;
										$auto = 'trucks';
									}
									if ($auto_text == 'с/х') {
										$auto = 'agricultural';
									}
                                    elseif ($auto_text == 'сх') {
                                        $auto = 'agricultural';
                                    }
                                    elseif ($auto_text == 'cельхозтехника') {
                                        $auto = 'agricultural';
                                    }
									elseif ($auto_text == 'легкогрузовая') {
										$auto = 'light_trucks';
									}
									elseif ($auto_text == 'грузовой') {
										$auto = 'trucks';
									}
									elseif ($auto_text == 'грузовой') {
										$auto = 'trucks';
									}
                                    elseif ($auto_text == 'грузовая') {
                                        $auto = 'trucks';
                                    }
									elseif ($auto_text == 'мото') {
										$auto = 'moto';
									}
									elseif ($auto_text == 'джип') {
										$auto = 'cars';
									}
									elseif ($auto_text == 'внедорожник') {
										$auto = 'cars';
									}
                                    elseif ($auto_text == 'спецтехника') {
                                        $auto = 'special';
                                    }
                                    elseif ($auto_text == 'спецтранспорт') {
                                        $auto = 'special';
                                    }
                                    elseif ($auto_text == 'индустриальная') {
                                        $auto = 'special';
                                    }
                                    elseif ($auto_text == 'спецтехника(Индустриальная)') {
                                        $auto = 'special';
                                    }
                                    elseif ($auto_text == 'погрузчики') {
                                        $auto = 'loader';
                                    }
                                    elseif ($auto_text == 'погрузчик') {
                                        $auto = 'loader';
                                    }
									$stud = 0;
									if (isset($data->sheets[0]['cells'][$i][12])) {
										$stud_text = trim($data->sheets[0]['cells'][$i][12]);
										if ($stud_text == 'шип') {
											$stud = 1;
										}
										elseif ($stud_text == 'подшип') {
											$stud = 0;
										}
										else {
											$stud = 0;
										}
									}
									$size1 = trim($data->sheets[0]['cells'][$i][6]);
									$size2 = trim($data->sheets[0]['cells'][$i][7]);
									$size3 = trim($data->sheets[0]['cells'][$i][8]);
									$f1 = '';
									$f2 = '';
									if (isset($data->sheets[0]['cells'][$i][9])) {
										$f1 = trim($data->sheets[0]['cells'][$i][9]);
									}
									if (isset($data->sheets[0]['cells'][$i][10])) {
										$f2 = trim($data->sheets[0]['cells'][$i][10]);
									}
									$price = 0;
									$stock_count = 0;
									if (isset($data->sheets[0]['cells'][$i][15])) {
										$price = floatval(trim($data->sheets[0]['cells'][$i][15])) / $rate;
									}
									if (isset($data->sheets[0]['cells'][$i][14])) {
										$stock_count = intval(trim($data->sheets[0]['cells'][$i][14]));
									}

                                    $free_tyremount = 0;
                                    $free_storage = 0;
                                    $warranty = 0;
                                    $xl = 0;
                                    $run_flat = 0;

                                    if (isset($data->sheets[0]['cells'][$i][17])) {
                                        $free_tyremount = 1;
                                    }
                                    if (isset($data->sheets[0]['cells'][$i][18])) {
                                        $free_storage = 1;
                                    }
                                    if (isset($data->sheets[0]['cells'][$i][19])) {
                                        $warranty = 1;
                                    }
                                    if (isset($data->sheets[0]['cells'][$i][20])) {
                                        $xl = 1;
                                    }
                                    if (isset($data->sheets[0]['cells'][$i][21])) {
                                        $run_flat = 1;
                                    }


									if (isset($brands[$brand])) {
										$brand_id = $brands[$brand];
										if (isset($models[$brand_id][$model])) {
											$model_id = $models[$brand_id][$model];
										}
										else {
											$save_data = array(
												'is_active' => 1,
												'brand_id' => $brand_id,
												'category_id' => $category_id,
												'title' => $model_name,
												'meta_title' => $model_name,
												'slug' => $this->_transliterate($model_name)
											);
											$this->BrandModel->create();
											if ($this->BrandModel->save($save_data)) {
												$created_models ++;
												$model_id = $this->BrandModel->id;
												$recount_models[] = $model_id;
												$model_photos[$model_id] = false;
												$models[$brand_id][$model] = $model_id;
											}
										}
									}
									else {
										if (isset($need_to_create_brands[$brand_name])) {
											$need_to_create_brands[$brand_name][] = $i;
										}
										else {
											$need_to_create_brands[$brand_name] = array($i);
										}
										/*
										$slug = $this->_transliterate($brand_name);
										$check_slug = $slug;
										$j = 2;
										while (isset($brand_slugs[$check_slug])) {
											$check_slug = $slug . $j;
											$j ++;
										}
										$brand_slugs[$check_slug] = 1;
										$slug = $check_slug;
										$save_data = array(
											'is_active' => 1,
											'category_id' => $category_id,
											'title' => $brand_name,
											'slug' => $slug,
											'meta_title' => $brand_name
										);
										$this->Brand->create();
										if ($this->Brand->save($save_data)) {
											$created_brands ++;
											$brand_id = $this->Brand->id;
											$recount_brands[] = $brand_id;
											$brands[$brand] = $brand_id;
											$save_data = array(
												'is_active' => 1,
												'brand_id' => $brand_id,
												'category_id' => $category_id,
												'title' => $model_name,
												'meta_title' => $model_name
											);
											$this->BrandModel->create();
											if ($this->BrandModel->save($save_data)) {
												$created_models ++;
												$model_id = $this->BrandModel->id;
												$recount_models[] = $model_id;
												$model_photos[$model_id] = false;
												$models[$brand_id][$model] = $model_id;
											}
										}
										*/
									}
									if (!empty($brand_id) && !empty($model_id)) {
										if (!in_array($brand_id, $recount_brands)) {
											$recount_brands[] = $brand_id;
										}
										if (!in_array($model_id, $recount_models)) {
											$recount_models[] = $model_id;
										}
										if (!$model_photos[$model_id] && !empty($data->sheets[0]['cells'][$i][22])) {
											$filename = str_replace('/', DS, $data->sheets[0]['cells'][$i][22]);
											if (is_file(ROOT . DS . $filename)) {
												$save_data = array();
												$save_data['file']['tmp_name'] = ROOT . DS . $filename;
												$save_data['file']['name'] = '1.jpg';
												$save_data['file']['type'] = 'image/jpeg';
												$this->BrandModel->id = $model_id;
												if ($this->BrandModel->save($save_data, false)) {
													$model_photos[$model_id] = true;
												}
												$this->BrandModel->tmp_file = null;
											}
										}
										$conditions = array(
											'Product.brand_id' => $brand_id,
											'Product.model_id' => $model_id,
											'Product.category_id' => $category_id,
											'Product.size1' => $size1,
											'Product.size2' => $size2,
											'Product.size3' => $size3,
											'Product.f1' => $f1,
											'Product.f2' => $f2
										);
										if ($stud !== null) {
											$conditions['Product.stud'] = $stud;
										}
										if ($only_prices) {
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
												if ($price != $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$this->Product->id = $product['Product']['id'];
														if ($this->Product->saveField('price', $price)) {
															$this->Product->saveField('supplier_id', $supplier_id);
															$updated_products ++;
														}
														else {
															$not_updated_products ++;
															debug($this->Product->validationErrors);
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
										}
										else {
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.stud', 'Product.season', 'Product.axis', 'Product.auto', 'Product.supplier_id')))) {
												$save_data = array();
												if ($price < $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$save_data['price'] = $price;
														$save_data['supplier_id'] = $supplier_id;
														if ($stock_count != $product['Product']['stock_count']) {
															$save_data['stock_count'] = $stock_count;
														}
														if ($in_stock != $product['Product']['in_stock']) {
															$save_data['in_stock'] = $in_stock;
														}
														if ($season != $product['Product']['season']) {
															$save_data['season'] = $season;
														}
														if ($auto != $product['Product']['auto']) {
															$save_data['auto'] = $auto;
														}
														if ($axis != $product['Product']['axis']) {
															$save_data['axis'] = $axis;
														}
														if ($stud !== null && $stud != $product['Product']['stud']) {
															$save_data['stud'] = $stud;
														}
														if (!empty($save_data)) {
															$this->Product->id = $product['Product']['id'];
															if ($this->Product->save($save_data, false)) {
																$updated_products ++;
															}
															else {
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												elseif ($price == $product['Product']['price']) {
													if ($stock_count != $product['Product']['stock_count']) {
														$save_data['stock_count'] = $stock_count;
													}
													if ($in_stock != $product['Product']['in_stock']) {
														$save_data['in_stock'] = $in_stock;
													}
													$save_data['supplier_id'] = $supplier_id;
													if (!empty($save_data)) {
														$this->Product->id = $product['Product']['id'];
														if ($this->Product->save($save_data, false)) {
															$updated_products ++;
														}
														else {
															$not_updated_products ++;
															debug($this->Product->validationErrors);
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
											else {
												$save_data = array(
													'is_active' => 1,
													'supplier_id' => $supplier_id,
													'brand_id' => $brand_id,
													'model_id' => $model_id,
													'category_id' => $category_id,
													'size1' => $size1,
													'size2' => $size2,
													'size3' => $size3,
													'sku' => $title,
													'f1' => $f1,
													'f2' => $f2,
													'season' => $season,
													'axis' => $axis,
													'auto' => $auto,
													'price' => $price,
													'stock_count' => $stock_count,
													'in_stock' => $in_stock,
                                                    'p1' => $free_tyremount,
                                                    'p2' => $free_storage,
                                                    'p3' => $warranty,
                                                    'p4' => $xl,
                                                    'p5' => $run_flat,
												);
												if ($stud !== null) {
													$save_data['stud'] = $stud;
												}
												$this->Product->create();
												if ($this->Product->save($save_data)) {
													$created_products ++;
												}
												else {
													$not_created_products ++;
													debug($this->Product->validationErrors);
												}
											}
										}
									}
								}
								else {
									$skipped_rows ++;
								}
							}
							break;
						case 7:
							$category_id = 4;
							for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
									$total_rows ++;
									$type = trim(mb_strtolower($data->sheets[0]['cells'][$i][1]));
									if ($type == 'автокамера' || $type == 'мотокамера' || $type == 'ободная лента') {
										switch ($type) {
											case 'автокамера':
												$type = 'car_tube';
												break;
											case 'мотокамера':
												$type = 'moto_tube';
												break;
											case 'ободная лента':
												$type = 'flap';
												break;
										}
										if (isset($data->sheets[0]['cells'][$i][2]) && !empty($data->sheets[0]['cells'][$i][2])) {
											$sku = trim($data->sheets[0]['cells'][$i][2]);
											$price = 0;
											$stock_count = 0;
											if (isset($data->sheets[0]['cells'][$i][3])) {
												$stock_count = intval(trim($data->sheets[0]['cells'][$i][3]));
											}
											if (isset($data->sheets[0]['cells'][$i][4])) {
												$price = floatval(trim($data->sheets[0]['cells'][$i][4])) / $rate;
											}
											$conditions = array(
												'Product.type' => $type,
												'Product.sku' => $sku,
												'Product.category_id' => $category_id
											);
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
												if ($price != $product['Product']['price'] || $ignore_prices) {
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
														$this->Product->id = $product['Product']['id'];
														if ($this->Product->saveField('price', $price)) {
															$this->Product->saveField('supplier_id', $supplier_id);
															$updated_products ++;
														}
														else {
															$not_updated_products ++;
															debug($this->Product->validationErrors);
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$nothing_update_products ++;
												}
											}
											else {
												if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
													$save_data = array();
													if ($price <= $product['Product']['price'] || $ignore_prices) {
														if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
															$save_data['price'] = $price;
															$save_data['supplier_id'] = $supplier_id;
															if ($stock_count != $product['Product']['stock_count']) {
																$save_data['stock_count'] = $stock_count;
															}
															if ($in_stock != $product['Product']['in_stock']) {
																$save_data['in_stock'] = $in_stock;
															}
															if (!empty($save_data)) {
																$this->Product->id = $product['Product']['id'];
																if ($this->Product->save($save_data, false)) {
																	$updated_products ++;
																}
																else {
																	$not_updated_products ++;
																	debug($this->Product->validationErrors);
																}
															}
															else {
																$nothing_update_products ++;
															}
														}
														else {
															$nothing_update_products ++;
														}
													}
													else {
														$nothing_update_products ++;
													}
												}
												else {
													$save_data = array(
														'is_active' => 1,
														'supplier_id' => $supplier_id,
														'category_id' => $category_id,
														'type' => $type,
														'sku' => $sku,
														'price' => $price,
														'stock_count' => $stock_count,
														'in_stock' => $in_stock
													);
													$this->Product->create();
													if ($this->Product->save($save_data)) {
														$created_products ++;
													}
													else {
														$not_created_products ++;
														debug($this->Product->validationErrors);
													}
												}
											}
										}
										else {
											$skipped_rows ++;
										}
									}
									else {
										$skipped_rows ++;
									}
								}
								else {
									$skipped_rows ++;
								}
							}
							break;
					case 8:
						/***** диски (собственный прайс) *******/
						
						//echo"111111";
						//print_r($this->product_materials);
						//exit();
						
							$category_id = 2;
						
							$brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							
							foreach ($all_brands as $brand => $id) {
								$brand = $this->_clean_text($brand);
								$brands[$brand] = $id;
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							
							//print_r($model_synonyms);
						//	echo "444444";
							//echo "<br> ------- ".count($all_models);
							//echo "<br> ------- ".count($model_synonyms);
							
							//exit();
							
							
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								foreach ($model_synonyms as $synonym) {
									//print_r("-1-");
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
							}
							
							
							
							
							
							/*
							$this->loadModel('Products');
							
							$color_ = $this->Products->find('list',array(
							'conditions' => array('color !='=>''),
							'fields' => array('color'),
							'group' => array('color'),
							));
							*/
							
							for ($i = 6; $i <= $data->sheets[0]['numRows']; $i++){
								//echo "<br>---".$i;
								if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])){
									$total_rows ++;
									//$conditions = array();
								//	$brand_id = null;
								//	$model_id = null;

									$data->sheets[0]['cells'][$i][2] = str_replace(array('J', 'j'), '', $data->sheets[0]['cells'][$i][2]);
									$data->sheets[0]['cells'][$i][2] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][2]);
									$data->sheets[0]['cells'][$i][4] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][4]);
									$size = trim($data->sheets[0]['cells'][$i][1]);
									$size3 = trim($data->sheets[0]['cells'][$i][2]);
									$et = str_replace('ET', '', trim($data->sheets[0]['cells'][$i][3]));
									$hub = trim($data->sheets[0]['cells'][$i][4]);
									$size = str_replace(',', '.', $size);
									$size3 = str_replace(',', '.', $size3);
									$et = str_replace(',', '.', $et);
									$hub = str_replace(',', '.', $hub);
									$brand_name = trim($data->sheets[0]['cells'][$i][5]);
									$model_name = trim($data->sheets[0]['cells'][$i][6]);
									$brand = $this->_clean_text($brand_name);
									$model = $this->_clean_text($model_name, false);
									$color = trim($data->sheets[0]['cells'][$i][6]);
									$price = floatval(trim($data->sheets[0]['cells'][$i][7])) / $rate;
									$stock_count = intval(trim($data->sheets[0]['cells'][$i][8]));
									
								//	echo "<br><br>model_name:".$model_name;
								//	echo "<br>total_rows:"; print_r($total_rows);
									
									$cl=0;
									foreach($this->product_materials as $val):
										if(strstr($model_name," ".$val)):
											//echo "<br><br>------";	print_r($val);
											//echo "<br>";			print_r($color);
											if(strlen($val) > $cl):
												$cl=strlen($val);
												$color=$val;
												//echo "<br><br>model_name:";		print_r($model_name);
												//$model_name=str_replace(trim($color), "", $model_name);
												//echo "<br>color:";				print_r($color);
												//echo "<br>model_name:";			print_r($model_name);
											endif;
										endif; 
									endforeach;
									
									if($cl==0) $color='';
									$model_name=str_replace(trim($color), "", $model_name);
									
									
									//echo "<br>model1:";		print_r($model);
									$model=str_replace(trim($this->_clean_text($color)), "", $model);
									
													
									list($size1, $size2) = explode(' ', preg_replace('/ +/', ' ', $size));
									//echo"<br><br>00000";
									if(isset($brands[$brand])){
									//	echo"<br>111111";
										$brand_id = $brands[$brand];

										if(isset($models[$brand_id][$this->_clean_text($model,false)])){
									//		echo"<br>2222222";
											$model_id = $models[$brand_id][$this->_clean_text($model,false)];
										//	echo"<br>model:".$model;
										//	echo"<br>model_id:".$model_id;
										//	echo"<br>";
										//	print_r($models[$brand_id]);
											
										   }
										else{
									//		echo"<br>333333";
											$abran = $this->BrandModel->find('list', 
												array(
													'fields' => array('BrandModel.id','BrandModel.title'),
													'conditions' => array('BrandModel.title' => $model_name) 
												));
											if(empty($abran)):
												//echo"<br>-- создаю, новую запись -- ";print_r($save_data);
									//			echo"<br>444444";
												$save_data = array(
													'is_active' => 1,
													'brand_id' => $brand_id,
													'category_id' => $category_id,
													'title' => $model_name,
													'meta_title' => $model_name,
													'slug' => $this->_transliterate($model_name)
												);
												
												$this->BrandModel->create();
												if ($this->BrandModel->save($save_data)){
										//		echo"<br>5555555";
													$created_models ++;
													$model_id = $this->BrandModel->id;
													
										//			echo"<br> model_id: ";print_r($model_id);
										//			echo"<br> model: ";print_r($model);
													
													$recount_models[] = $model_id;
													$models[$brand_id][$model] = $model_id;
												}
												
											endif;
											//print_r($abran);
										}
									}
									else{
									//	echo"<br>66666666";
										if(isset($need_to_create_brands[$brand_name])) {
									//		echo"<br>77777777";
											$need_to_create_brands[$brand_name][] = $i;
										}
										else{
									//		echo"<br>8888888";
											$need_to_create_brands[$brand_name] = array($i);
										}
									}
									
								//	echo"<br>=======".$brand_id;
									//echo"<br>========".$model_id;
									
									if(!empty($brand_id) && !empty($model_id)){
									//	echo"<br>9999999";
										if(!in_array($brand_id, $recount_brands)){
											$recount_brands[] = $brand_id;
									//		echo"<br>10_10_10_10";
									//		echo"<br>---- brand_id: ".$brand_id;
										}
										if(!in_array($model_id, $recount_models)){
									//		echo"<br>11_11_11_11";
									//		echo"<br>---- model_id: ".$model_id;
											$recount_models[] = $model_id;
										}
										$conditions = array(
											'Product.brand_id' => $brand_id,
											'Product.model_id' => $model_id,
											'Product.category_id' => $category_id,
											'Product.size1' => $size1,
											'Product.size2' => $size2,
											'Product.size3' => $size3,
											'Product.et' => $et,
											'Product.hub' => $hub,
											'Product.sku LIKE' => '%'.$model_name.'%'
											
										);
										if (!empty($color)) {
									//		echo"<br>12_12_12_12";
											$conditions['Product.color'] = $color;
										}
										if ($only_prices){
									//		echo"<br>13_13_13_13";
											if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price')))) {
										//		echo"<br>14_14_14_14";
												if ($price != $product['Product']['price'] || $ignore_prices) {
										//			echo"<br>15_15_15_15";
													if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
										//				echo"<br>16_16_16_16";
														$this->Product->id = $product['Product']['id'];
														if($this->Product->saveField('price', $price)){
											//				echo"<br>17_17_17_17";
															$this->Product->saveField('supplier_id', $supplier_id);
															$updated_products ++;
														}
														else{
										//					echo"<br>18_18_18_18";
															$not_updated_products ++;
															debug($this->Product->validationErrors);
														}
													}
													else{
										//				echo"<br>19_19_19_19";
														$nothing_update_products ++;
													}
												}
												else{
									//				echo"<br>20_20_20_20";
													$nothing_update_products ++;
												}
											}
										}
										else{
											//echo"<br>21_21_21_21";
										//	echo"<br>conditions(Product,first):";
										//	print_r($conditions);
											if($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
												//echo"<br>22_22_22_22";
											//	echo"<br>----";
											//	print_r($product);
											//	exit();
												
												
												$save_data = array();
												if($price <= $product['Product']['price'] || $ignore_prices){
											//		echo"<br>23_23_23_23";
													if(!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])){
											//			echo"<br>24_24_24_24";
														$save_data['price'] = $price;
														$save_data['supplier_id'] = $supplier_id;
														if($stock_count != $product['Product']['stock_count']) {
											//				echo"<br>25_25_25_25";
															$save_data['stock_count'] = $stock_count;
														}
														if($in_stock != $product['Product']['in_stock']) {
											//				echo"<br>26_26_26_26";
															$save_data['in_stock'] = $in_stock;
														}
														if(!empty($save_data)){
											//				echo"<br>27_27_27_27";
															$this->Product->id = $product['Product']['id'];
															if($this->Product->save($save_data, false)){
											//					echo"<br>28_28_28_28";
																$updated_products ++;
											//					echo"<br>updated_products: ".$updated_products;
																
															}
															else{
											//					echo"<br>29_29_29_29";
																$not_updated_products ++;
																debug($this->Product->validationErrors);
															}
														}
														else{
											//				echo"<br>30_30_30_30";
															$nothing_update_products ++;
														}
													}
													else{
											//			echo"<br>31_31_31_31";
														$nothing_update_products ++;
													}
												}
												else {
											//		echo"<br>32_32_32_32";
													$nothing_update_products ++;
												}
											}
											else{
										//		echo"<br>33_33_33_33";
												$sku = $brand_name . ' ' . $model_name . ' ' . $size3 . 'x' . $size1 . ' ' . $size2 . ' ET ' . $et . ' Dia ' . $hub;
												/*if (!empty($color)) {
													$sku .= ' (' . $color . ')';
												}*/
												$save_data = array(
													'is_active' => 1,
													'supplier_id' => $supplier_id,
													'brand_id' => $brand_id,
													'model_id' => $model_id,
													'category_id' => $category_id,
													'size1' => $size1,
													'size2' => $size2,
													'size3' => $size3,
													'et' => $et,
													'hub' => $hub,
													'color' => $color,
													'sku' => $sku,
													'price' => $price,
													'in_stock' => $in_stock,
													'stock_count' => $stock_count
												);
												$this->Product->create();
												if($this->Product->save($save_data)) {
													$created_products ++;
										//			echo"<br>34_34_34_34";
										//			echo"<br>created_products: ".$created_products;
										//			echo"<br> ---- save_data: ";
										//			print_r($save_data);
													
													
												}
												else{
										//			echo"<br>35_35_35_35";
													$not_created_products ++;
													debug($this->Product->validationErrors);
												}
												
											}
										}
									}
								}
								else{
							//		echo"<br>36_36_36_36";
									$skipped_rows ++;
								}
							}
						//	exit();
//                        АКБ (расширенный)
                        case 9:
                            $category_id = 3;
                            $brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
                            $all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
                            $all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title', 'BrandModel.extra_filenames')));
                            $model_synonyms = $this->ModelSynonym->find('all');
                            $brand_synonyms = $this->BrandSynonym->find('all');
                            $brands = array();
                            $models = array();
                            $model_extra_filenames = array();
                            foreach ($all_brands as $brand => $id) {
                                $brand = $this->_clean_text($brand);
                                $brands[$brand] = $id;
                                foreach ($brand_synonyms as $synonym) {
                                    if ($synonym['BrandSynonym']['brand_id'] == $id) {
                                        $brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
                                        $brands[$brand] = $id;
                                    }
                                }
                            }
                            foreach ($all_models as $item) {
                                if (!isset($models[$item['BrandModel']['brand_id']])) {
                                    $models[$item['BrandModel']['brand_id']] = array();
                                }
                                $model = $this->_clean_text($item['BrandModel']['title'], false);
                                $models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
                                $model_extra_filenames[$item['BrandModel']['id']] = $item['BrandModel']['extra_filenames'];

                                foreach ($model_synonyms as $synonym) {
                                    if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
                                        $model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
                                        $models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
                                        $model_extra_filenames[$item['BrandModel']['id']] = $item['BrandModel']['extra_filenames'];
                                    }
                                }
                            }
                            //debug($data->sheets[0]['cells']);
                            for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
                                if (isset($data->sheets[0]['cells'][$i][1])) {
                                    $total_rows ++;
                                    $brand_id = null;
                                    $model_id = null;
                                    $auto_text = mb_strtolower(trim($data->sheets[0]['cells'][$i][1]));
                                    $auto = 'cars';

                                    if ($auto_text == 'грузовой') {
                                        $auto = 'trucks';
                                    }
                                    elseif ($auto_text == 'грузовые') {
                                        $auto = 'trucks';
                                    }
                                    elseif ($auto_text == 'мото') {
                                        $auto = 'moto';
                                    }
                                    elseif ($auto_text == 'легковой') {
                                        $auto = 'cars';
                                    }
                                    elseif ($auto_text == 'легковые') {
                                        $auto = 'cars';
                                    }

                                    $brand_name = trim($data->sheets[0]['cells'][$i][2]);
                                    $model_name = trim($data->sheets[0]['cells'][$i][3]);
                                    $brand = $this->_clean_text($brand_name);
                                    $model = $this->_clean_text($model_name, false);
                                    $manufacturing_technology = trim($data->sheets[0]['cells'][$i][4]);

                                    $extra_params = trim($data->sheets[0]['cells'][$i][5]);
                                    // height && start&stop
                                    $p1 = 0;
                                    $start_stop = '';
                                    $f3 = '';
                                    if (!empty($extra_params)) {
                                        $extra_params = mb_strtolower($extra_params);
                                        $manuf_tech = mb_strtolower($manufacturing_technology);

                                        if (strpos($extra_params, 'узкий') !== false) {
                                            $f3 = 'Узкий';
                                        }
                                        if (strpos($extra_params, 'низкий') !== false) {
                                            $f3 = 'Низкий';
                                        }
                                        if (strpos($extra_params, 'efb') !== false) {
                                            $start_stop = 'EFB';
                                            $p1 = 1;
                                        }
                                        if (strpos($extra_params, 'agm') !== false) {
                                            $start_stop = 'AGM';
                                            $p1 = 1;
                                        }
                                        if (strpos($manuf_tech, 'agm') !== false) {
                                            $start_stop = 'AGM';
                                            $p1 = 1;
                                        }
                                    }

                                    $warranty = trim($data->sheets[0]['cells'][$i][6]);
                                    $country = trim($data->sheets[0]['cells'][$i][7]);
                                    $length = trim($data->sheets[0]['cells'][$i][8]);
                                    $width = trim($data->sheets[0]['cells'][$i][9]);
                                    $height = trim($data->sheets[0]['cells'][$i][10]);
                                    $size = $length.'x'.$width.'x'.$height;
                                    $ah = trim($data->sheets[0]['cells'][$i][11]);
                                    $current = trim($data->sheets[0]['cells'][$i][12]);
                                    $f1 = '';
                                    if (isset($data->sheets[0]['cells'][$i][13])) {
                                        $f1 = trim($data->sheets[0]['cells'][$i][13]);
                                    }
                                    $f2 = trim($data->sheets[0]['cells'][$i][15]);
                                    $price = floatval(trim($data->sheets[0]['cells'][$i][16])) / $rate;
                                    $price_with_exchange = floatval(trim($data->sheets[0]['cells'][$i][17])) / $rate;

                                    $autodom_count = trim($data->sheets[0]['cells'][$i][18]);
                                    // $tiptop_count = trim($data->sheets[0]['cells'][$i][17]);
                                    $bam_count = trim($data->sheets[0]['cells'][$i][19]);
                                    // $atp_count = trim($data->sheets[0]['cells'][$i][19]);
                                    // $taksopark_count = trim($data->sheets[0]['cells'][$i][19]);
                                    $vianorshop_count = trim($data->sheets[0]['cells'][$i][20]);
                                    $hundai_count = trim($data->sheets[0]['cells'][$i][21]);
                                    $tavrida_count = trim($data->sheets[0]['cells'][$i][22]);
                                    $gruz_count = trim($data->sheets[0]['cells'][$i][23]);

                                    if (empty($autodom_count)) {
                                        $autodom_count = 0;
                                    }
                                    if (empty($tiptop_count)) {
                                        $tiptop_count = 0;
                                    }
                                    if (empty($bam_count)) {
                                        $bam_count = 0;
                                    }
                                    if (empty($atp_count)) {
                                        $atp_count = 0;
                                    }
                                    if (empty($taksopark_count)) {
                                        $taksopark_count = 0;
                                    }
                                    if (empty($vianorshop_count)) {
                                        $vianorshop_count = 0;
                                    }
                                    if (empty($hundai_count)) {
                                        $hundai_count = 0;
                                    }
                                    if (empty($tavrida_count)) {
                                        $tavrida_count = 0;
                                    }
                                    if (empty($gruz_count)) {
                                        $gruz_count = 0;
                                    }

                                    $stock_count = intval($autodom_count) + intval($tiptop_count) + intval($bam_count) + intval($atp_count) + intval($taksopark_count) + intval($vianorshop_count) + intval($hundai_count) + intval($tavrida_count) + intval($gruz_count);

                                    // $stock_places = $autodom_count.'|'.$tiptop_count.'|'.$bam_count.'|'.$atp_count.'|'.$taksopark_count.'|'.$vianorshop_count.'|'.$hundai_count.'|'.$tavrida_count.'|'.$gruz_count;


                                    if (substr_count($size, 'x') == 2) {
                                        list($length, $width, $height) = explode('x', $size);
                                        if (isset($brands[$brand])) {
                                            $brand_id = $brands[$brand];
                                            if (isset($models[$brand_id][$model])) {
                                                $model_id = $models[$brand_id][$model];
                                            }
                                            else {
                                                $save_data = array(
                                                    'is_active' => 1,
                                                    'brand_id' => $brand_id,
                                                    'category_id' => $category_id,
                                                    'title' => $model_name,
                                                    'meta_title' => $model_name,
                                                    'slug' => $this->_transliterate($model_name)
                                                );
                                                $this->BrandModel->create();
                                                if ($this->BrandModel->save($save_data)) {
                                                    $created_models ++;
                                                    $model_id = $this->BrandModel->id;
                                                    $models[$brand_id][$model] = $model_id;
                                                }
                                            }
                                        }
                                        else {
                                            if (isset($need_to_create_brands[$brand_name])) {
                                                $need_to_create_brands[$brand_name][] = $i;
                                            }
                                            else {
                                                $need_to_create_brands[$brand_name] = array($i);
                                            }
                                            /*
                                            $slug = $this->_transliterate($brand_name);
                                            $check_slug = $slug;
                                            $j = 2;
                                            while (isset($brand_slugs[$check_slug])) {
                                                $check_slug = $slug . $j;
                                                $j ++;
                                            }
                                            $brand_slugs[$check_slug] = 1;
                                            $slug = $check_slug;
                                            $save_data = array(
                                                'is_active' => 1,
                                                'category_id' => $category_id,
                                                'title' => $brand_name,
                                                'slug' => $slug,
                                                'meta_title' => $brand_name
                                            );
                                            $this->Brand->create();
                                            if ($this->Brand->save($save_data)) {
                                                $created_brands ++;
                                                $brand_id = $this->Brand->id;
                                                $recount_brands[] = $brand_id;
                                                $brands[$brand] = $brand_id;
                                                $save_data = array(
                                                    'is_active' => 1,
                                                    'brand_id' => $brand_id,
                                                    'category_id' => $category_id,
                                                    'title' => $model_name,
                                                    'meta_title' => $model_name
                                                );
                                                $this->BrandModel->create();
                                                if ($this->BrandModel->save($save_data)) {
                                                    $created_models ++;
                                                    $model_id = $this->BrandModel->id;
                                                    $recount_models[] = $model_id;
                                                    $models[$brand_id][$model] = $model_id;
                                                }
                                            }
                                            */
                                        }
                                        if (!empty($brand_id) && !empty($model_id)) {
                                            if (!in_array($brand_id, $recount_brands)) {
                                                $recount_brands[] = $brand_id;
                                            }
                                            if (!in_array($model_id, $recount_models)) {
                                                $recount_models[] = $model_id;
                                            }
                                            $conditions = array(
                                                'Product.brand_id' => $brand_id,
                                                'Product.model_id' => $model_id,
                                                'Product.category_id' => $category_id,
                                                'Product.ah' => $ah,
                                                'Product.current' => $current,
                                                'Product.width' => $width,
                                                'Product.length' => $length,
                                                'Product.height' => $height,
                                                'Product.f1' => $f1,
                                                'Product.f2' => $f2
                                            );
                                            if ($only_prices) {
                                                if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
                                                    if ($price != $product['Product']['price'] || $ignore_prices) {
                                                        if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
                                                            $this->Product->id = $product['Product']['id'];
                                                            if ($this->Product->saveField('price', $price)) {
                                                                $this->Product->saveField('supplier_id', $supplier_id);
                                                                $updated_products ++;
                                                            }
                                                            else {
                                                                $not_updated_products ++;
                                                                debug($this->Product->validationErrors);
                                                            }
                                                        }
                                                        else {
                                                            $nothing_update_products ++;
                                                        }
                                                    }
                                                    else {
                                                        $nothing_update_products ++;
                                                    }
                                                }
                                            }
                                            else {
                                                if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
                                                    $save_data = array();
                                                    if ($price <= $product['Product']['price'] || $ignore_prices) {
                                                        if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
                                                            $save_data['price'] = $price;
                                                            $save_data['supplier_id'] = $supplier_id;
                                                            if ($stock_count != $product['Product']['stock_count']) {
                                                                $save_data['stock_count'] = $stock_count;
                                                            }
                                                            if ($in_stock != $product['Product']['in_stock']) {
                                                                $save_data['in_stock'] = $in_stock;
                                                            }
                                                            if (!empty($save_data)) {
                                                                $this->Product->id = $product['Product']['id'];
                                                                if ($this->Product->save($save_data, false)) {
                                                                    $updated_products ++;
                                                                }
                                                                else {
                                                                    $not_updated_products ++;
                                                                    debug($this->Product->validationErrors);
                                                                }
                                                            }
                                                            else {
                                                                $nothing_update_products ++;
                                                            }
                                                        }
                                                        else {
                                                            $nothing_update_products ++;
                                                        }
                                                    }
                                                    else {
                                                        $nothing_update_products ++;
                                                    }
                                                }
                                                else {
                                                    // product extra images
                                                    $filename = '';

                                                    if (!empty($model_extra_filenames[$model_id])) {
                                                        $existing_file_names = explode('|', $model_extra_filenames[$model_id]);

                                                        if ($existing_file_names != '' && !empty($existing_file_names)) {
                                                            foreach ($existing_file_names as $key => $img_item) {
                                                                list($params, $img) = explode(':', $img_item);
                                                                list($ah_value, $f2_value) = explode('-', $params);

                                                                if (intval($ah_value) == intval($ah) && trim($f2) == trim($f2_value)) {
                                                                    $filename = $img;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $save_data = array(
                                                        'is_active' => 1,
                                                        'supplier_id' => $supplier_id,
                                                        'brand_id' => $brand_id,
                                                        'model_id' => $model_id,
                                                        'category_id' => $category_id,
                                                        'ah' => $ah,
                                                        'current' => $current,
                                                        'width' => $width,
                                                        'length' => $length,
                                                        'height' => $height,
                                                        'f1' => $f1,
                                                        'f2' => $f2,
                                                        'price' => $price,
                                                        'stock_count' => $stock_count,
                                                        'in_stock' => $in_stock,
                                                        'material' => $country,
                                                        'color' => $manufacturing_technology,
                                                        'price_with_exchange' => $price_with_exchange,
                                                        'f3' => $f3,
                                                        'truck' => $start_stop,
                                                        'axis' => $warranty,
                                                        'auto' => $auto,
                                                        'p1' => $p1,
                                                        'filename' => $filename,
                                                        'count_place_0' => $autodom_count,
                                                        'count_place_1' => $tiptop_count,
                                                        'count_place_2' => $bam_count,
                                                        'count_place_3' => $atp_count,
                                                        'count_place_4' => $taksopark_count,
                                                        'count_place_5' => $vianorshop_count,
                                                        'count_place_6' => $hundai_count,
                                                        'count_place_7' => $tavrida_count,
                                                        'count_place_8' => $gruz_count,

                                                    );
                                                    $this->Product->create();
                                                    if ($this->Product->save($save_data)) {

                                                        $created_products ++;
                                                    }
                                                    else {
                                                        $not_created_products ++;
                                                        debug($this->Product->validationErrors);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                else {
                                    $skipped_rows ++;
                                }
                            }
                            break;

                        // шины собственный расширенный
                        case 10:
                            $category_id = 1;
                            $brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
                            $all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
                            $all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title'), 'order' => array('LENGTH(BrandModel.title)' => 'desc')));
                            $model_synonyms = $this->ModelSynonym->find('all');
                            $brand_synonyms = $this->BrandSynonym->find('all');
                            $brands = array();
                            $models = array();
                            foreach ($all_brands as $brand => $id) {
                                $brand = $this->_clean_text($brand);
                                $brands[$brand] = $id;
                                foreach ($brand_synonyms as $synonym) {
                                    if ($synonym['BrandSynonym']['brand_id'] == $id) {
                                        $brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
                                        $brands[$brand] = $id;
                                    }
                                }
                            }
                            foreach ($all_models as $item) {
                                if (!isset($models[$item['BrandModel']['brand_id']])) {
                                    $models[$item['BrandModel']['brand_id']] = array();
                                }
                                $model = $this->_clean_text($item['BrandModel']['title'], false);
                                $models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
                                foreach ($model_synonyms as $synonym) {
                                    if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
                                        $model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
                                        $models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
                                    }
                                }
                            }
                            //debug($data->sheets[0]['cells']);exit();
                            for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
                                if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
                                    $total_rows ++;
                                    $brand_id = null;
                                    $model_id = null;
                                    $brand_name = trim($data->sheets[0]['cells'][$i][2]);
                                    $title = trim($data->sheets[0]['cells'][$i][3]);
                                    $brand = $this->_clean_text($brand_name);
                                    $size = trim($data->sheets[0]['cells'][$i][1]);
                                    $axis_text = mb_strtolower(trim($data->sheets[0]['cells'][$i][17]));
                                    $auto = 'cars';
                                    $axis = '';
                                    if (substr_count($axis_text, 'руль+прицеп')) {
                                        $auto = 'trucks';
                                        $axis = 'руль/прицеп';
                                    }
                                    elseif (substr_count($axis_text, 'прицеп+руль')) {
                                        $auto = 'trucks';
                                        $axis = 'руль/прицеп';
                                    }
                                    elseif (substr_count($axis_text, 'руль/прицеп')) {
                                        $auto = 'trucks';
                                        $axis = 'руль/прицеп';
                                    }
                                    elseif (substr_count($axis_text, 'тяга+руль')) {
                                        $auto = 'trucks';
                                        $axis = 'универсальная';
                                    }
                                    elseif (substr_count($axis_text, 'руль+тяга')) {
                                        $auto = 'trucks';
                                        $axis = 'универсальная';
                                    }
                                    elseif (substr_count($axis_text, 'прицеп')) {
                                        $auto = 'trucks';
                                        $axis = 'прицеп';
                                    }
                                    elseif (substr_count($axis_text, 'тяга')) {
                                        $auto = 'trucks';
                                        $axis = 'тяга';
                                    }
                                    elseif (substr_count($axis_text, 'руль')) {
                                        $auto = 'trucks';
                                        $axis = 'рулевая';
                                    }
                                    elseif (substr_count($axis_text, 'ведущ')) {
                                        $auto = 'trucks';
                                        $axis = 'ведущая';
                                    }
                                    elseif (substr_count($axis_text, 'карьер')) {
                                        $auto = 'trucks';
                                        $axis = 'карьерная';
                                    }
                                    elseif (substr_count($axis_text, 'универ')) {
                                        $auto = 'trucks';
                                        $axis = 'универсальная';
                                    }
                                    if (isset($data->sheets[0]['cells'][$i][16])) {
                                        $type = mb_strtolower(trim($data->sheets[0]['cells'][$i][16]));
                                        if ($type == 'г') {
                                            $auto = 'trucks';
                                        }
                                        elseif ($type == 'лг') {
                                            $auto = 'light_trucks';
                                        }
                                        elseif ($type == 'сх') {
                                            $auto = 'agricultural';
                                        }
                                        elseif ($type == 'мото') {
                                            $auto = 'moto';
                                        }
                                        elseif ($type == 'джип') {
                                            $auto = 'cars';
                                        }
                                        elseif ($type == 'спецтехника') {
                                            $auto = 'special';
                                        }
                                        elseif ($type == 'спецтранспорт') {
                                            $auto = 'special';
                                        }
                                        elseif ($type == 'индустриальная') {
                                            $auto = 'special';
                                        }
                                        elseif ($type == 'погрузчики') {
                                            $auto = 'loader';
                                        }
                                        elseif ($type == 'погрузчик') {
                                            $auto = 'loader';
                                        }
                                    }
                                    $stud = 0;
                                    if (isset($data->sheets[0]['cells'][$i][17])) {
                                        $stud_text = mb_strtolower(trim($data->sheets[0]['cells'][$i][17]));
                                        if ($stud_text == 'шип' || $stud_text == 'ш') {
                                            $stud = 1;
                                        }
                                        elseif ($stud_text == 'подшип' || $stud_text == 'пш') {
                                            $stud = 0;
                                        }
                                        else {
                                            $stud = 0;
                                        }
                                    }

                                    $autodom_count = trim($data->sheets[0]['cells'][$i][6]);
                                    $tiptop_count = trim($data->sheets[0]['cells'][$i][7]);
                                    $bam_count = trim($data->sheets[0]['cells'][$i][8]);
                                    $atp_count = trim($data->sheets[0]['cells'][$i][9]);
                                    $taksopark_count = trim($data->sheets[0]['cells'][$i][10]);
                                    $vianorshop_count = trim($data->sheets[0]['cells'][$i][11]);
                                    $hundai_count = trim($data->sheets[0]['cells'][$i][12]);
                                    $tavrida_count = trim($data->sheets[0]['cells'][$i][13]);
                                    $gruz_count = trim($data->sheets[0]['cells'][$i][14]);

                                    if (empty($autodom_count)) {
                                        $autodom_count = 0;
                                    }
                                    if (empty($tiptop_count)) {
                                        $tiptop_count = 0;
                                    }
                                    if (empty($bam_count)) {
                                        $bam_count = 0;
                                    }
                                    if (empty($atp_count)) {
                                        $atp_count = 0;
                                    }
                                    if (empty($taksopark_count)) {
                                        $taksopark_count = 0;
                                    }
                                    if (empty($vianorshop_count)) {
                                        $vianorshop_count = 0;
                                    }
                                    if (empty($hundai_count)) {
                                        $hundai_count = 0;
                                    }
                                    if (empty($tavrida_count)) {
                                        $tavrida_count = 0;
                                    }
                                    if (empty($gruz_count)) {
                                        $gruz_count = 0;
                                    }

                                    // $stock_places = $autodom_count.'|'.$tiptop_count.'|'.$bam_count.'|'.$atp_count.'|'.$taksopark_count.'|'.$vianorshop_count.'|'.$hundai_count.'|'.$tavrida_count.'|'.$gruz_count;
                                    $free_tyremount = trim($data->sheets[0]['cells'][$i][18]);
                                    $free_storage = trim($data->sheets[0]['cells'][$i][19]);
                                    $warranty = trim($data->sheets[0]['cells'][$i][20]);

                                    if (!empty($free_tyremount)) {
                                        $free_tyremount = 1;
                                    }
                                    if (!empty($free_storage)) {
                                        $free_storage = 1;
                                    }
                                    if (!empty($warranty)) {
                                        $warranty = 1;
                                    }

                                    $xl = 0;
                                    $run_flat = 0;
                                    $tyre_title = mb_strtolower($title);

                                    if (substr_count($tyre_title, ' xl')) {
                                        $xl = 1;
                                    }
                                    if (substr_count($tyre_title, 'extra load')) {
                                        $xl = 1;
                                    }
                                    if (substr_count($title, ' RF')) {
                                        $run_flat = 1;
                                    }
                                    if (substr_count($tyre_title, 'run flat')) {
                                        $run_flat = 1;
                                    }
                                    if (substr_count($tyre_title, 'run-flat')) {
                                        $run_flat = 1;
                                    }
                                    if (substr_count($tyre_title, 'runflat')) {
                                        $run_flat = 1;
                                    }

                                    $last_space = mb_strrpos($title, ' ');
                                    if ($last_space === false) {
                                        $error_lines[] = $i;
                                        $skipped_rows ++;
                                        continue;
                                    }
                                    $f = mb_substr($title, $last_space + 1);
                                    if (mb_strlen($f) < 3) {
                                        $error_lines[] = $i;
                                        $skipped_rows ++;
                                        continue;
                                    }
                                    $f1 = mb_substr($f, 0, -1);
                                    $f2 = mb_substr($f, -1);
                                    $model_name = trim(str_replace($f, '', $title));
                                    $model = $this->_clean_text($model_name, false);
                                    $delimiter = null;
                                    if (substr_count($size, '/') == 1) {
                                        $size = str_replace('R', '/', $size);
                                    }
                                    elseif (substr_count($size, '-') == 1) {
                                        $size = str_replace('R', '-', $size);
                                    }
                                    if (substr_count($size, '/') == 2) {
                                        $delimiter = '/';
                                    }
                                    elseif (substr_count($size, '-') == 2) {
                                        $delimiter = '-';
                                    }
                                    else {
                                        $size = str_replace(' ', '', $size);
                                        if (substr_count($size, 'R') == 1) {
                                            list($size1, $size3) = explode('R', $size);
                                            $size1 = intval($size1);
                                            $size = implode('/', array($size1, '', $size3));
                                            $delimiter = '/';
                                        }
                                        elseif (substr_count($size, '/') == 1) {
                                            list($size1, $size3) = explode('/', $size);
                                            $size1 = intval($size1);
                                            $size = implode('/', array($size1, '', $size3));
                                            $delimiter = '/';
                                        }
                                    }
                                    if (!empty($delimiter)) {
                                        list($size1, $size2, $size3) = explode($delimiter, $size);
                                        $price = floatval(trim($data->sheets[0]['cells'][$i][5])) / $rate;
                                        $stock_count = intval(trim($data->sheets[0]['cells'][$i][15]));
                                        $season = 'summer';
                                        $season_text = mb_strtolower($data->sheets[0]['cells'][$i][4]);
                                        if (!empty($season_text)) {
                                            if ($season_text == 'в') {
                                                $season = 'all';
                                            }
                                            elseif ($season_text == 'з') {
                                                $season = 'winter';
                                            }
                                            elseif ($season_text == 'л') {
                                                $season = 'summer';
                                            }
                                        }
                                        if (isset($brands[$brand])) {
                                            $brand_id = $brands[$brand];
                                            if (isset($models[$brand_id][$model])) {
                                                $model_id = $models[$brand_id][$model];
                                            }
                                            else {
                                                $save_data = array(
                                                    'is_active' => 1,
                                                    'brand_id' => $brand_id,
                                                    'category_id' => $category_id,
                                                    'title' => $model_name,
                                                    'meta_title' => $model_name,
                                                    'slug' => $this->_transliterate($model_name)
                                                );
                                                $this->BrandModel->create();
                                                if ($this->BrandModel->save($save_data)) {
                                                    $created_models ++;
                                                    $model_id = $this->BrandModel->id;
                                                    $recount_models[] = $model_id;
                                                    $model_photos[$model_id] = false;
                                                    $models[$brand_id][$model] = $model_id;
                                                }
                                            }
                                        }
                                        else {
                                            if (isset($need_to_create_brands[$brand_name])) {
                                                $need_to_create_brands[$brand_name][] = $i;
                                            }
                                            else {
                                                $need_to_create_brands[$brand_name] = array($i);
                                            }
                                            /*
                                            $slug = $this->_transliterate($brand_name);
                                            $check_slug = $slug;
                                            $j = 2;
                                            while (isset($brand_slugs[$check_slug])) {
                                                $check_slug = $slug . $j;
                                                $j ++;
                                            }
                                            $brand_slugs[$check_slug] = 1;
                                            $slug = $check_slug;
                                            $save_data = array(
                                                'is_active' => 1,
                                                'category_id' => $category_id,
                                                'title' => $brand_name,
                                                'slug' => $slug,
                                                'meta_title' => $brand_name
                                            );
                                            $this->Brand->create();
                                            if ($this->Brand->save($save_data)) {
                                                $created_brands ++;
                                                $brand_id = $this->Brand->id;
                                                $recount_brands[] = $brand_id;
                                                $brands[$brand] = $brand_id;
                                                $save_data = array(
                                                    'is_active' => 1,
                                                    'brand_id' => $brand_id,
                                                    'category_id' => $category_id,
                                                    'title' => $model_name,
                                                    'meta_title' => $model_name
                                                );
                                                $this->BrandModel->create();
                                                if ($this->BrandModel->save($save_data)) {
                                                    $created_models ++;
                                                    $model_id = $this->BrandModel->id;
                                                    $recount_models[] = $model_id;
                                                    $models[$brand_id][$model] = $model_id;
                                                }
                                            }
                                            */
                                        }
                                        if (!empty($brand_id) && !empty($model_id)) {
                                            if (!in_array($brand_id, $recount_brands)) {
                                                $recount_brands[] = $brand_id;
                                            }
                                            if (!in_array($model_id, $recount_models)) {
                                                $recount_models[] = $model_id;
                                            }
                                            $conditions = array(
                                                'Product.brand_id' => $brand_id,
                                                'Product.model_id' => $model_id,
                                                'Product.category_id' => $category_id,
                                                'Product.size1' => $size1,
                                                'Product.size2' => $size2,
                                                'Product.size3' => $size3,
                                                'Product.f1' => $f1,
                                                'Product.f2' => $f2
                                            );
                                            if ($stud !== null) {
                                                $conditions['Product.stud'] = $stud;
                                            }
                                            if ($only_prices) {
                                                if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.supplier_id')))) {
                                                    if ($price != $product['Product']['price'] || $ignore_prices) {
                                                        if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
                                                            $this->Product->id = $product['Product']['id'];
                                                            if ($this->Product->saveField('price', $price)) {
                                                                $this->Product->saveField('supplier_id', $supplier_id);
                                                                $updated_products ++;
                                                            }
                                                            else {
                                                                $not_updated_products ++;
                                                                debug($this->Product->validationErrors);
                                                            }
                                                        }
                                                        else {
                                                            $nothing_update_products ++;
                                                        }
                                                    }
                                                    else {
                                                        $nothing_update_products ++;
                                                    }
                                                }
                                            }
                                            else {
                                                if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.stud', 'Product.season', 'Product.axis', 'Product.auto', 'Product.supplier_id')))) {
                                                    $save_data = array();
                                                    if ($price < $product['Product']['price'] || $ignore_prices) {
                                                        if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
                                                            $save_data['price'] = $price;
                                                            $save_data['supplier_id'] = $supplier_id;
                                                            if ($stock_count != $product['Product']['stock_count']) {
                                                                $save_data['stock_count'] = $stock_count;
                                                            }
                                                            if ($in_stock != $product['Product']['in_stock']) {
                                                                $save_data['in_stock'] = $in_stock;

                                                                if ($in_stock == 1) {
                                                                    $save_data['count_place_0'] = $autodom_count;
                                                                    $save_data['count_place_1'] = $tiptop_count;
                                                                    $save_data['count_place_2'] = $bam_count;
                                                                    $save_data['count_place_3'] = $atp_count;
                                                                    $save_data['count_place_4'] = $taksopark_count;
                                                                    $save_data['count_place_5'] = $vianorshop_count;
                                                                    $save_data['count_place_6'] = $hundai_count;
                                                                    $save_data['count_place_7'] = $tavrida_count;
                                                                    $save_data['count_place_8'] = $gruz_count;
                                                                }
                                                            }
                                                            // save supplier data
                                                            if ($product['Product']['in_stock'] != 1) {
                                                                $save_data['count_out_of_stock'] = $product['Product']['stock_count'];
                                                                $save_data['out_of_stock_supplier_id'] = $product['Product']['supplier_id'];
                                                            }
                                                            // save supplier data
                                                            if ($season != $product['Product']['season']) {
                                                                $save_data['season'] = $season;
                                                            }
                                                            if ($auto != $product['Product']['auto']) {
                                                                $save_data['auto'] = $auto;
                                                            }
                                                            if ($axis != $product['Product']['axis']) {
                                                                $save_data['axis'] = $axis;
                                                            }
                                                            if ($stud !== null && $stud != $product['Product']['stud']) {
                                                                $save_data['stud'] = $stud;
                                                            }

                                                            if (!empty($save_data)) {
                                                                $this->Product->id = $product['Product']['id'];
                                                                if ($this->Product->save($save_data, false)) {
                                                                    $updated_products ++;
                                                                }
                                                                else {
                                                                    $not_updated_products ++;
                                                                    debug($this->Product->validationErrors);
                                                                }
                                                            }
                                                            else {
                                                                $nothing_update_products ++;
                                                            }
                                                        }
                                                        else {
                                                            $nothing_update_products ++;
                                                        }
                                                    }
                                                    elseif ($price == $product['Product']['price']) {
                                                        if ($stock_count != $product['Product']['stock_count']) {
                                                            $save_data['stock_count'] = $stock_count;
                                                        }
                                                        if ($in_stock != $product['Product']['in_stock']) {
                                                            $save_data['in_stock'] = $in_stock;
                                                        }
                                                        $save_data['supplier_id'] = $supplier_id;
                                                        if (!empty($save_data)) {
                                                            $this->Product->id = $product['Product']['id'];
                                                            if ($this->Product->save($save_data, false)) {
                                                                $updated_products ++;
                                                            }
                                                            else {
                                                                $not_updated_products ++;
                                                                debug($this->Product->validationErrors);
                                                            }
                                                        }
                                                        else {
                                                            $nothing_update_products ++;
                                                        }
                                                    }
                                                    else {
                                                        $nothing_update_products ++;
                                                    }
                                                }
                                                else {
                                                    $save_data = array(
                                                        'is_active' => 1,
                                                        'supplier_id' => $supplier_id,
                                                        'brand_id' => $brand_id,
                                                        'model_id' => $model_id,
                                                        'category_id' => $category_id,
                                                        'size1' => $size1,
                                                        'size2' => $size2,
                                                        'size3' => $size3,
                                                        'sku' => $title,
                                                        'f1' => $f1,
                                                        'f2' => $f2,
                                                        'season' => $season,
                                                        'auto' => $auto,
                                                        'axis' => $axis,
                                                        'price' => $price,
                                                        'stock_count' => $stock_count,
                                                        'in_stock' => $in_stock,
                                                        'p1' => $free_tyremount,
                                                        'p2' => $free_storage,
                                                        'p3' => $warranty,
                                                        'p4' => $xl,
                                                        'p5' => $run_flat,
                                                        'count_place_0' => $autodom_count,
                                                        'count_place_1' => $tiptop_count,
                                                        'count_place_2' => $bam_count,
                                                        'count_place_3' => $atp_count,
                                                        'count_place_4' => $taksopark_count,
                                                        'count_place_5' => $vianorshop_count,
                                                        'count_place_6' => $hundai_count,
                                                        'count_place_7' => $tavrida_count,
                                                        'count_place_8' => $gruz_count,
                                                    );
                                                    if ($stud !== null) {
                                                        $save_data['stud'] = $stud;
                                                    }
                                                    $this->Product->create();
                                                    if ($this->Product->save($save_data)) {
                                                        $created_products ++;
                                                    }
                                                    else {
                                                        $not_created_products ++;
                                                        debug($this->Product->validationErrors);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        $error_lines[] = $i;
                                        $skipped_rows ++;
                                    }
                                }
                                else {
                                    $skipped_rows ++;
                                }
                            }
                            break;
                        case 11:
                            $category_id = 2;
                            $brand_slugs = $this->Brand->find('list', array('fields' => array('Brand.slug', 'Brand.id')));
                            $all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
                            $all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title')));
                            $model_synonyms = $this->ModelSynonym->find('all');
                            $brand_synonyms = $this->BrandSynonym->find('all');
                            $brands = array();
                            $models = array();
                            foreach ($all_brands as $brand => $id) {
                                $brand = $this->_clean_text($brand);
                                $brands[$brand] = $id;
                                foreach ($brand_synonyms as $synonym) {
                                    if ($synonym['BrandSynonym']['brand_id'] == $id) {
                                        $brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
                                        $brands[$brand] = $id;
                                    }
                                }
                            }
                            foreach ($all_models as $item) {
                                if (!isset($models[$item['BrandModel']['brand_id']])) {
                                    $models[$item['BrandModel']['brand_id']] = array();
                                }
                                $model = $this->_clean_text($item['BrandModel']['title'], false);
                                $models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
                                foreach ($model_synonyms as $synonym) {
                                    if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
                                        $model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
                                        $models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
                                    }
                                }
                            }
                            for ($i = 6; $i <= $data->sheets[0]['numRows']; $i++) {
                                if (isset($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][1])) {
                                    $total_rows ++;
                                    $brand_id = null;
                                    $model_id = null;

                                    $data->sheets[0]['cells'][$i][2] = str_replace(array('J', 'j'), '', $data->sheets[0]['cells'][$i][2]);
                                    $data->sheets[0]['cells'][$i][2] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][2]);
                                    $data->sheets[0]['cells'][$i][4] = str_replace(array('.0', ',0'), '', $data->sheets[0]['cells'][$i][4]);
                                    $size = trim($data->sheets[0]['cells'][$i][1]);
                                    $size3 = trim($data->sheets[0]['cells'][$i][2]);
                                    $et = str_replace('ET', '', trim($data->sheets[0]['cells'][$i][3]));
                                    $hub = trim($data->sheets[0]['cells'][$i][4]);
                                    $size = str_replace(',', '.', $size);
                                    $size3 = str_replace(',', '.', $size3);
                                    $et = str_replace(',', '.', $et);
                                    $hub = str_replace(',', '.', $hub);
                                    $brand_name = trim($data->sheets[0]['cells'][$i][5]);
                                    $model_name = trim($data->sheets[0]['cells'][$i][6]);
                                    $brand = $this->_clean_text($brand_name);
                                    $model = $this->_clean_text($model_name, false);
                                    $color = trim($data->sheets[0]['cells'][$i][7]);
                                    $price = floatval(trim($data->sheets[0]['cells'][$i][8])) / $rate;
                                    $stock_count = intval(trim($data->sheets[0]['cells'][$i][18]));

                                    $autodom_count = trim($data->sheets[0]['cells'][$i][9]);
                                    $tiptop_count = trim($data->sheets[0]['cells'][$i][10]);
                                    $bam_count = trim($data->sheets[0]['cells'][$i][11]);
                                    $atp_count = trim($data->sheets[0]['cells'][$i][12]);
                                    $taksopark_count = trim($data->sheets[0]['cells'][$i][13]);
                                    $vianorshop_count = trim($data->sheets[0]['cells'][$i][14]);
                                    $hundai_count = trim($data->sheets[0]['cells'][$i][15]);
                                    $tavrida_count = trim($data->sheets[0]['cells'][$i][16]);
                                    $gruz_count = trim($data->sheets[0]['cells'][$i][17]);

                                    if (empty($autodom_count)) {
                                        $autodom_count = 0;
                                    }
                                    if (empty($tiptop_count)) {
                                        $tiptop_count = 0;
                                    }
                                    if (empty($bam_count)) {
                                        $bam_count = 0;
                                    }
                                    if (empty($atp_count)) {
                                        $atp_count = 0;
                                    }
                                    if (empty($taksopark_count)) {
                                        $taksopark_count = 0;
                                    }
                                    if (empty($vianorshop_count)) {
                                        $vianorshop_count = 0;
                                    }
                                    if (empty($hundai_count)) {
                                        $hundai_count = 0;
                                    }
                                    if (empty($tavrida_count)) {
                                        $tavrida_count = 0;
                                    }
                                    if (empty($gruz_count)) {
                                        $gruz_count = 0;
                                    }

                                    // $stock_places = $autodom_count.'|'.$tiptop_count.'|'.$bam_count.'|'.$atp_count.'|'.$taksopark_count.'|'.$vianorshop_count.'|'.$hundai_count.'|'.$tavrida_count.'|'.$gruz_count;

                                    list($size1, $size2) = explode(' ', preg_replace('/ +/', ' ', $size));
                                    if (isset($brands[$brand])) {
                                        $brand_id = $brands[$brand];
                                        if (isset($models[$brand_id][$model])) {
                                            $model_id = $models[$brand_id][$model];
                                        }
                                        else {
                                            $save_data = array(
                                                'is_active' => 1,
                                                'brand_id' => $brand_id,
                                                'category_id' => $category_id,
                                                'title' => $model_name,
                                                'meta_title' => $model_name,
                                                'slug' => $this->_transliterate($model_name)
                                            );
                                            $this->BrandModel->create();
                                            if ($this->BrandModel->save($save_data)) {
                                                $created_models ++;
                                                $model_id = $this->BrandModel->id;
                                                $recount_models[] = $model_id;
                                                $models[$brand_id][$model] = $model_id;
                                            }
                                        }
                                    }
                                    else {
                                        if (isset($need_to_create_brands[$brand_name])) {
                                            $need_to_create_brands[$brand_name][] = $i;
                                        }
                                        else {
                                            $need_to_create_brands[$brand_name] = array($i);
                                        }
                                        /*
                                        $slug = $this->_transliterate($brand_name);
                                        $check_slug = $slug;
                                        $j = 2;
                                        while (isset($brand_slugs[$check_slug])) {
                                            $check_slug = $slug . $j;
                                            $j ++;
                                        }
                                        $brand_slugs[$check_slug] = 1;
                                        $slug = $check_slug;
                                        $save_data = array(
                                            'is_active' => 1,
                                            'category_id' => $category_id,
                                            'title' => $brand_name,
                                            'slug' => $slug,
                                            'meta_title' => $brand_name
                                        );
                                        $this->Brand->create();
                                        if ($this->Brand->save($save_data)) {
                                            $created_brands ++;
                                            $brand_id = $this->Brand->id;
                                            $recount_brands[] = $brand_id;
                                            $brands[$brand] = $brand_id;
                                            $save_data = array(
                                                'is_active' => 1,
                                                'brand_id' => $brand_id,
                                                'category_id' => $category_id,
                                                'title' => $model_name,
                                                'meta_title' => $model_name
                                            );
                                            $this->BrandModel->create();
                                            if ($this->BrandModel->save($save_data)) {
                                                $created_models ++;
                                                $model_id = $this->BrandModel->id;
                                                $recount_models[] = $model_id;
                                                $models[$brand_id][$model] = $model_id;
                                            }
                                        }
                                        */
                                    }
                                    if (!empty($brand_id) && !empty($model_id)) {
                                        if (!in_array($brand_id, $recount_brands)) {
                                            $recount_brands[] = $brand_id;
                                        }
                                        if (!in_array($model_id, $recount_models)) {
                                            $recount_models[] = $model_id;
                                        }
                                        $conditions = array(
                                            'Product.brand_id' => $brand_id,
                                            'Product.model_id' => $model_id,
                                            'Product.category_id' => $category_id,
                                            'Product.size1' => $size1,
                                            'Product.size2' => $size2,
                                            'Product.size3' => $size3,
                                            'Product.et' => $et,
                                            'Product.hub' => $hub
                                        );
                                        if (!empty($color)) {
                                            $conditions['Product.color'] = $color;
                                        }
                                        if ($only_prices) {
                                            if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price')))) {
                                                if ($price != $product['Product']['price'] || $ignore_prices) {
                                                    if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
                                                        $this->Product->id = $product['Product']['id'];
                                                        if ($this->Product->saveField('price', $price)) {
                                                            $this->Product->saveField('supplier_id', $supplier_id);
                                                            $updated_products ++;
                                                        }
                                                        else {
                                                            $not_updated_products ++;
                                                            debug($this->Product->validationErrors);
                                                        }
                                                    }
                                                    else {
                                                        $nothing_update_products ++;
                                                    }
                                                }
                                                else {
                                                    $nothing_update_products ++;
                                                }
                                            }
                                        }
                                        else {
                                            if ($product = $this->Product->find('first', array('conditions' => $conditions, 'fields' => array('Product.id', 'Product.price', 'Product.stock_count', 'Product.in_stock', 'Product.supplier_id')))) {
                                                $save_data = array();
                                                if ($price <= $product['Product']['price'] || $ignore_prices) {
                                                    if (!$only_suppliers || ($only_suppliers && $supplier_id == $product['Product']['supplier_id'])) {
                                                        $save_data['price'] = $price;
                                                        $save_data['supplier_id'] = $supplier_id;
                                                        if ($stock_count != $product['Product']['stock_count']) {
                                                            $save_data['stock_count'] = $stock_count;
                                                        }
                                                        if ($in_stock != $product['Product']['in_stock']) {
                                                            $save_data['in_stock'] = $in_stock;
                                                        }
                                                        if (!empty($save_data)) {
                                                            $this->Product->id = $product['Product']['id'];
                                                            if ($this->Product->save($save_data, false)) {
                                                                $updated_products ++;
                                                            }
                                                            else {
                                                                $not_updated_products ++;
                                                                debug($this->Product->validationErrors);
                                                            }
                                                        }
                                                        else {
                                                            $nothing_update_products ++;
                                                        }
                                                    }
                                                    else {
                                                        $nothing_update_products ++;
                                                    }
                                                }
                                                else {
                                                    $nothing_update_products ++;
                                                }
                                            }
                                            else {
                                                $sku = $brand_name . ' ' . $model_name . ' ' . $size3 . 'x' . $size1 . ' ' . $size2 . ' ET ' . $et . ' Dia ' . $hub;
                                                if (!empty($color)) {
                                                    $sku .= ' (' . $color . ')';
                                                }
                                                $save_data = array(
                                                    'is_active' => 1,
                                                    'supplier_id' => $supplier_id,
                                                    'brand_id' => $brand_id,
                                                    'model_id' => $model_id,
                                                    'category_id' => $category_id,
                                                    'size1' => $size1,
                                                    'size2' => $size2,
                                                    'size3' => $size3,
                                                    'et' => $et,
                                                    'hub' => $hub,
                                                    'color' => $color,
                                                    'sku' => $sku,
                                                    'price' => $price,
                                                    'in_stock' => $in_stock,
                                                    'stock_count' => $stock_count,
                                                    'count_place_0' => $autodom_count,
                                                    'count_place_1' => $tiptop_count,
                                                    'count_place_2' => $bam_count,
                                                    'count_place_3' => $atp_count,
                                                    'count_place_4' => $taksopark_count,
                                                    'count_place_5' => $vianorshop_count,
                                                    'count_place_6' => $hundai_count,
                                                    'count_place_7' => $tavrida_count,
                                                    'count_place_8' => $gruz_count,
                                                );
                                                $this->Product->create();
                                                if ($this->Product->save($save_data)) {
                                                    $created_products ++;
                                                }
                                                else {
                                                    $not_created_products ++;
                                                    debug($this->Product->validationErrors);
                                                }
                                            }
                                        }
                                    }
                                }
                                else {
                                    $skipped_rows ++;
                                }
                            }
                            break;
					}
					/****** конец switch **********/
					
					
					
					
					if (!empty($recount_models)) {
						$this->BrandModel->recountProducts($recount_models);
					}
					if (!empty($recount_brands)) {
						$this->Brand->recountModels($recount_brands);
						$this->Brand->recountProducts($recount_brands);
					}
					$error_lines_message = null;
					if (!empty($error_lines)) {
						$error_lines_message = __d('admin_import', 'message_skipped_rows_list');
						foreach ($error_lines as $line) {
							$error_lines_message .= __d('admin_import', 'message_skipped_rows_line', $line);
						}
					}
					$message_lines = array(
						__d('admin_import', 'message_total_rows', $total_rows),
						__d('admin_import', 'message_skipped_rows', $skipped_rows),
						__d('admin_import', 'message_updated_products', $updated_products),
						__d('admin_import', 'message_created_products', $created_products),
						__d('admin_import', 'message_not_created_products', $not_created_products),
						__d('admin_import', 'message_not_updated_products', $not_updated_products),
						__d('admin_import', 'message_nothing_update_products', $nothing_update_products),
						//__d('admin_import', 'message_created_brands', $created_brands),
						__d('admin_import', 'message_created_models', $created_models)
					);
					if (!empty($need_to_create_brands)) {
						$need_to_create_brands_lines = array();
						foreach ($need_to_create_brands as $brand_name => $lines) {
							$need_to_create_brands_lines[] = __d('admin_import', 'message_brand_lines', $brand_name, implode(', ', $lines));
						}
						$message_lines[] = __d('admin_import', 'message_need_to_create_brands', implode(', ', $need_to_create_brands_lines));
					}
					if (!empty($error_lines_message)) {
						$message_lines[] = $error_lines_message;
					}
					$this->Session->write('message_lines', $message_lines);
					$this->info($this->t('message_item_saved'));
					$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_import'));
				}
				else {
					$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
				}
			}
			else {
				$this->error($this->t('error_item_not_saved'));
			}
		}
		if ($this->Session->check('message_lines')) {
			$this->set('message_lines', $this->Session->read('message_lines'));
			$this->Session->delete('message_lines');
		}
		
		$this->loadModel('Supplier');
		$this->set('suppliers', $this->Supplier->find('list', array('fields' => array('Supplier.id', 'Supplier.title'), 'order' => array('Supplier.title' => 'asc'))));
		$this->set('currencies', $this->Currency->find('list', array('fields' => array('Currency.id', 'Currency.title'), 'order' => array('Currency.sort_order' => 'asc'))));
		$this->set('types', $this->Import->types);
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_import'));
		//$this->render('admin_import');
	}
	public function admin_convert_tyres() {
		$this->layout = 'admin'; 
		$this->loadModel('Import');
		if (!empty($this->request->data)) {
			$this->Import->set($this->request->data);
			unset($this->Import->validate['type']);
			if ($this->Import->validates()) {
				app::import('Vendor', 'Spreadsheet_Excel_Reader', array('file' => 'phpExcelReader' . DS . 'Excel' . DS . 'reader.php'));
				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('UTF-8');
				if ($data->read(TMP . $this->Import->tmp_file)) {
					unlink(TMP . $this->Import->tmp_file);
					foreach ($data->sheets as $sheet_number => $sheet) {
						if (isset($sheet['cells'])) {
							foreach ($sheet['cells'] as $i => $row) {
								foreach ($row as $j => $value) {
									if (preg_match('/' . iconv('utf-8', 'windows-1251', '[АБВГДЕЁЖСЗИЙКЛМНОПРСТУФХСЧШЩЭЮЯЬЪЫабвгдеёжсзийклмнопрстуфхсчшщэюяьъы]') . '/', $value) && strlen($value) == mb_strlen($value)) {
										$data->sheets[$sheet_number]['cells'][$i][$j] = @iconv('windows-1251', 'utf-8', $value);
									}
								}
							}
						}
					}
					/*
					foreach ($data->sheets as $sheet_number => $sheet) {
						if (isset($sheet['cells'])) {
							foreach ($sheet['cells'] as $i => $row) {
								foreach ($row as $j => $value) {
									$encoding = mb_detect_encoding($value, array('UTF-8', 'Windows-1251'), true);
									if ((preg_match('/' . iconv('utf-8', 'windows-1251', '[АБВГДЕЁЖСЗИЙКЛМНОПРСТУФХСЧШЩЭЮЯЬЪЫабвгдеёжсзийклмнопрстуфхсчшщэюяьъы]') . '/', $value) && strlen($value) == mb_strlen($value)) || $encoding == 'windows-1251') {
										$data->sheets[$sheet_number]['cells'][$i][$j] = @iconv('windows-1251', 'utf-8', $value);
									}
								}
							}
						}
					}
					*/
					if (!empty($data)) {
						$column_fields = array(
							'полное наименование' => 'title',
							'номенклатура/ характеристика номенклатуры' => 'title',
							'цена usd' => 'price',
							'цінова група' => 'title',
							'бренд' => 'brand',
							'ш' => 'size1',
							'п' => 'size2',
							'д' => 'size3',
							'ціна' => 'price',
							'цена' => 'price',
							'валюта' => 'currency',
							'залишок' => 'stock_count',
							'сезон' => 'season',
							'тип' => 'auto',
                            'авто' => 'auto',
							'ценовая группа/ номенклатура/ характеристика номенклатуры' => 'title',
							'маг' => 'price',
							'мин' => 'price',
							'спец' => 'price',
							'спецa' => 'price',
							'спецb' => 'price',
							'спецc' => 'price',
							'всего остаток' => 'stock_count',
							'размер' => 'size',
							'индекс' => 'f',
							'нагрузка,скорость' => 'f',
							'бренд' => 'brand',
							'модель' => 'model',
							'опт' => 'price',
							'склад' => 'stock_count',
							'ширина' => 'size1',
							'высота' => 'size2',
							'диаметр' => 'size3',
							'индекс нагрузки' => 'f1',
							'индекс скорости' => 'f2',
							'доп.параметры' => 'stud',
							'производитель' => 'brand',
							'кол' => 'stock_count',
							'розница' => 'price',
							'розмiр' => 'size',
							'марка' => 'brand',
							'iндекс' => 'f',
							'к-ть' => 'stock_count',
							'товар' => 'title',
							'колич' => 'stock_count',
							'нагр./скор.' => 'f',
							'модель протектора' => 'model',
							'$' => 'price',
							'профиль' => 'size2',
							'радиус' => 'size3',
							'наименование' => 'title',
							'цена оптовая, usd' => 'price',
							'цена розничная, грн' => 'price',
							'цена опт.' => 'price',
							'ост.' => 'stock_count',
							'оптовая' => 'price',
							'кол-во' => 'stock_count',
							'опт, $' => 'price',
							'применение' => 'auto',
							'типоразмер' => 'size',
							'тип оси' => 'axis',
							'торговая марка' => 'brand',
							'остаток' => 'stock_count',
							'цена розничная' => 'price',
							'категория 1 = минимально допустимая цена продажи на украине' => 'price',
							'категория 2' => 'price',
							'категория 3' => 'price',
							'категория 4' => 'price',
							'рекоменд. розничная цена ооо "тпк "омега-автопоставка"' => 'price',
							'применяемость' => 'auto',
							'ось' => 'axis',
							'чп"авраменко" г.днепропетровск' => 'title',
							'цена 3' => 'price',
							'безнал' => 'price',
							'ост' => 'stock_count',
							'тм' => 'brand',
							'сезон / ко' => 'season',
							'ширина / полка' => 'size1',
							'высота / вылет' => 'size2',
							'r' => 'size3',
							'вид / мо' => 'auto',
							'наименование товара' => 'title',
							'острочка' => 'price',
							'остатокпо фирме' => 'stock_count',
							'остаток, кол.' => 'stock_count',
							'цена, грн' => 'price',
							'типоразмер/модель' => 'title',
							'оптовая цена, грн' => 'price',
							'основной склад (наличие,шт.)' => 'stock_count',
							'произв-ль' => 'brand',
							'индекс нагрузки/скорости' => 'f',
							'главный склад (днепропетровск)' => 'stock_count',
							'главный склад логистический' => 'stock_count',
							'главный склад vip' => 'stock_count',
							'севастополь' => 'stock_count',
							'тп симферополь' => 'stock_count',
							'феодосия' => 'stock_count',
							'керчь' => 'stock_count',
							'свободный остаток' => 'stock_count',
							'склад 1' => 'stock_count',
							'склад 2' => 'stock_count',
							'цена        склада 2, грн' => 'price',
							'склад 2 (наличие,шт.)' => 'stock_count',
							'симферополь' => 'stock_count',
							'tyreplusсимферополь' => 'stock_count',
							'tyreplusфеодосия' => 'stock_count',
							'евпатория' => 'stock_count',
							'опт (грн)' => 'price',
							'номенклатура' => 'title',
							'номенклатура.производитель' => 'brand',
							'номенклатура.модель' => 'model',
							'номенклатура.тип рисунка протектора' => 'season',
							'розничная' => 'price',
							'ось' => 'axis',
							'остаток свободный' => 'stock_count',
							'оптовые' => 'price',
							'опт 2' => 'price',
							'опт грн' => 'price',
							'описание' => 'season_type',
							'тмц' => 'title',
							'количество' => 'stock_count',
							'бренд (св-во номенклатура)' => 'brand',
							'1 склад' => 'stock_count',
							'2 склад' => 'stock_count',
							'новоукраинский' => 'stock_count',
							'мск' => 'stock_count',
							'2. розничная' => 'price',
							'склад     ооо "пин"' => 'stock_count',
							'свободный остаток' => 'stock_count',
							'цена, руб.' => 'price',
							'крупный опт цена(руб.)' => 'price',
							'г. краснодар, х. ленина 37, склад 2' => 'stock_count',
							'г. краснодар, х. ленина, 37' => 'stock_count',
							'шипы' => 'stud',
							'сезонность' => 'season',
							'спец цена' => 'price'
						);
						$required_fields = array(
							'brand_id',
							'model_id',
							'size1',
							'size2',
							'size3',
							//'f1',
							//'f2'
						);
						$errors = array();
						$products = array();
						$total_rows_count = 0;
						$total_sheets_count = 0;
						$total_converted_rows = 0;
						$total_skipped_rows = 0;
						$total_error_rows = 0;
						$product_studs = array(
							'нешип.' => 'нешип',
							'нешип' => 'нешип',
							'подшип.' => 'подшип',
							'подшип' => 'подшип',
							'нешипованная' => 'нешип',
							'не шипованная' => 'нешип',
							'под. шип.' => 'подшип',
							'под шип' => 'подшип',
							'під шип' => 'подшип',
							'п/ш' => 'подшип',
							'п.ш.' => 'подшип',
							'не шип' => 'нешип',
							'шипована' => 'шип',
							'шипованная' => 'шип',
							'шипованные' => 'шип',
							'шипованна' => 'шип',
							'шипи' => 'шип',
							'шип.' => 'шип',
							'шип' => 'шип',
							'ш' => 'шип',
							'stud' => 'шип'
						);
						$product_seasons = array(
							'літня' => 'летняя',
							'літо' => 'летняя',
							'всесезонна' => 'всесезонная',
							'зимова' => 'зимняя',
							'летняя' => 'летняя',
							'летние' => 'летняя',
							'лето' => 'летняя',
							'зимняя' => 'зимняя',
							'зимние' => 'зимняя',
							'зима' => 'зимняя',
							'всесезонная' => 'всесезонная',
							'всесезонные' => 'всесезонная',
							'летняя (л)' => 'летняя',
							'всесезонка (в)' => 'всесезонная',
							'зимняя (з)' => 'зимняя',
							'л' => 'летняя',
							'в' => 'всесезонная',
							'з' => 'зимняя',
							'зимові' => 'зимняя',
							'літні' => 'летняя',
                            'летние и всесезонные' => 'всесезонная',
                            'зимние и всесезонные' => 'всесезонная',
						);
						$product_autos = array(
							'легкова' => 'легковой',
							'легковая' => 'легковой',
							'грузовая' => 'грузовой',
							'грузовых' => 'грузовой',
							'грузовой' => 'грузовой',
							'легкогрузовые' => 'легкогрузовая',
                            'легкогруз' => 'легкогрузовая',
							'джипы' => 'легковой',
							'микроавтобус' => 'легковой',
							'внедорожник' => 'легковой',
							'легкогрузовая' => 'легкогрузовая',
							'сельхоз' => 'с/х',
							'г' => 'грузовой',
							'л' => 'легковой',
							'лг' => 'легкогрузовая',
							'сх' => 'с/х',
							'легковi' => 'легковой',
							'легковантажні' => 'легкогрузовая',
							'вантажні' => 'грузовой',
                            'спецтехника(Индустриальная)' => 'индустриальная',
                            'индустриальная' => 'индустриальная',
                            'сельхозтехника' => 'с/х',
                            'сельхозшина' => 'с/х'
						);
						$product_axis = array(
							'ведущая' => 'ведущая',
                            '(на ведущую ось)' => 'ведущая',
							'управляемая' => 'руль',
							'прицеп' => 'прицеп',
                            'приц.' => 'прицеп',
							'универсальная' => 'универсальная',
							'рулевая/универсальная' => 'универсальная',
							'прицепная' => 'прицеп',
							'рулевая' => 'руль',
                            '(на рулевую ось)' => 'руль',
							'тяга+руль' => 'универсальная', 
							'руль+тяга' => 'универсальная',
							'руль+прицеп' => 'универсальная',
							'приводная' => 'тяга',
							'руль' => 'руль',
							'тяга' => 'тяга',
                            'руль/прицеп' => 'руль/прицеп',
                            'карьерная' => 'карьерная',
                            'карьер' => 'карьерная'
						);
						$this->loadModel('Brand');
						$this->loadModel('BrandModel');
						$this->loadModel('ModelSynonym');
						$this->loadModel('BrandSynonym');
						$category_id = 1;
						$brands = Cache::read('import_brands_' . $category_id, 'long');
						$models = Cache::read('import_models_' . $category_id, 'long');
						$models_by_id = Cache::read('import_models_by_id_' . $category_id, 'long');
						$brands_by_id = Cache::read('import_brands_by_id_' . $category_id, 'long');
						if (empty($brands)) {
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							$models_by_id = array();
							$brands_by_id = array();
							foreach ($all_brands as $brand => $id) {
								$brand = trim($this->_clean_text($brand));
								if (mb_strlen($brand) > 1) {
									$brands[$brand] = $id;
									$brands_by_id[$id] = $brand;
								}
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							uksort($brands, 'cmp');
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								$models_by_id[$item['BrandModel']['id']] = $model;
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = trim($this->_clean_text($synonym['ModelSynonym']['title'], false));
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
								uksort($models[$item['BrandModel']['brand_id']], 'cmp');
							}
							Cache::write('import_brands_' . $category_id, $brands, 'long');
							Cache::write('import_models_' . $category_id, $models, 'long');
							Cache::write('import_models_by_id_' . $category_id, $models_by_id, 'long');
							Cache::write('import_brands_by_id_' . $category_id, $brands_by_id, 'long');
						}
						//debug($models);exit();
						$merge_cells = array();
						//debug($data);exit();
						//debug($data->sheets);exit();
						foreach ($data->sheets as $sheet_number => $sheet) {
							$total_sheets_count ++;
							$fields_order = array();
							// find first line
							$first_line = null;
							if (isset($sheet['cells'])) {
								// исключения
								// file прайс 17,09,12 опт.xls
								if (isset($sheet['cells'][1][1]) && $sheet['cells'][1][1] == 'Анатолий "АВТОПЛАНЕТА"') {
									$sheet['cells'][10][1] = 'наименование';
									$sheet['cells'][10][2] = 'сезон';
								}
								foreach ($sheet['cells'] as $i => $row) {
									$total_rows_count ++;
									if (count($row) < 3) {
										$total_skipped_rows ++;
										continue;
									}
									$first_line = $i;
									//debug($row);
									//var_dump($row);
									foreach ($row as $j => $cell) {
										$cell = trim(mb_strtolower(str_replace(array("\n", "\r"), '', $cell)));
										if (isset($column_fields[$cell])) {
											$fields_order[$j] = $column_fields[$cell];
										}
									}
									// исключения
									// file avtoshinopt10092012.xls
									if (isset($row[1]) && isset($row[3]) && $row[1] == 'Размер' && $row[3] == 'Нагрузка,Скорость') {
										$merge_cells[1] = array(1, 2);
										unset($fields_order[3]);
										$fields_order[4] = 'f';
									}

									// file Остатки 14-08-2012.xls
									if (isset($row[3]) && isset($row[4]) && $row[3] == 'Типоразмер' && $row[4] == 'Посадочный Диаметр') {
										$merge_cells[3] = array(3, 4);
									}
									
									// Прайс_шины диски..xls
									if (isset($row[1]) && isset($row[2]) && $row[1] == 'Тип' && $row[2] == 'ТМ') {
										unset($fields_order[1]);
									}
									// Прайс Шина Трейдинг 21092012_1.xls
									if (isset($row[1]) && isset($row[2]) && isset($row[3]) && $row[1] == 'Наименование товара' && $row[2] == 'Ед. изм.' && $row[3] == 'Применяемость') {
										$fields_order[3] = 'axis';
									}

									// склад Луганск опт 29.08.xls
									if (isset($row[1]) && isset($row[2]) && isset($row[3]) && $row[1] == 'Код' && $row[2] == 'Качество' && $row[3] == 'Завод') {
										$fields_order = array(
											3 => 'size',
											5 => 'brand',
											7 => 'title',
											11 => 'stock_count',
											13 => 'price'
										);
									}
									// склад Луганск опт 29.08.xls
									if (isset($row[3]) && isset($row[7]) && isset($row[8]) && $row[3] == 'Наименование' && $row[7] == 'Остаток' && $row[8] == 'Спец цена') {
										$fields_order = array(
											2 => 'title',
											7 => 'stock_count',
											8 => 'price'
										);
									}
									// Шины грузовые 10.09.2012_1.xls
									if (isset($row[5]) && isset($row[6]) && $row[5] == 'Произв-ль' && $row[6] == 'Модель') {
										$fields_order[9] = 'axis';
									}
									// ПРАЙС  КРЫМ ШИНА 16,09,2014_1
									if (isset($row[1]) && isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[8]) && $row[1] == 'Размер' && $row[2] == 'Бренд' && $row[3] == 'Наименование' && $row[4] == 'кол-во' && $row[8] == 'Цена') {
										$required_fields = array(
											'brand_id',
											'model_id',
											'size1',
											'size2',
											'size3'
										);
									}
									// Прайс-лист_Шины и диски опт и опт2_28.окт..2014
									if (isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[5]) && isset($row[6]) && $row[2] == 'Артикул' && $row[3] == 'Наименование' && $row[4] == 'Код' && $row[5] == 'Остаток свободный' && $row[6] == 'Оптовые') {
										$required_fields = array(
											'brand_id',
											'model_id',
											'size1',
											'size2',
											'size3'
										);
									}
									if (count(array_unique($fields_order)) < 3) {
										//debug($fields_order);
										//$fields_order = array();
										continue;
									}
									break;
								}
							}
							//Configure::write('debug', 2);
							//debug($fields_order);exit();
							if (!empty($fields_order)) {
								//debug($fields_order);exit();
								$product_season = null;
								$product_auto = null;
								$product_stud = null;
								$has_season_column = in_array('season', $fields_order);
								$has_auto_column = in_array('auto', $fields_order);
								$has_stud_column = in_array('stud', $fields_order);
								foreach ($sheet['cells'] as $i => $row) {
									//debug($row);
									if ($i > $first_line) {
										$total_rows_count ++;
										// find season and auto here
										if (count($row) < 3) {
											$total_skipped_rows ++;
											if (!$has_season_column || !$has_auto_column) {
												foreach ($row as $cell_value) {
													$cell_value = trim(mb_strtolower($cell_value));
													if (!$has_season_column) {
														foreach ($product_seasons as $key => $value) {
															if (mb_substr_count($cell_value, $key) > 0) {
																$product_season = $value;
																$product_auto = null;
																break;
															}
														}
													}
													if (!$has_auto_column) {
														foreach ($product_autos as $key => $value) {
															if (mb_substr_count($cell_value, $key) > 0) {
																$product_auto = $value;
																break;
															}
														}
													}
												}
											}
											continue;
										}
										$save_data = array();
										foreach ($row as $field => $value) {
											if (isset($fields_order[$field])) {
												$type = $fields_order[$field];
												$value = trim($value);
												if ($type == 'price') {
													$value = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $value))));
													if (isset($save_data['price'])) {
														$save_data['price'] = min($value, $save_data['price']);
													}
													else {
														$save_data['price'] = $value;
													}
												}
												elseif ($type == 'stock_count') {
													$value = abs(intval(preg_replace('/[^0-9\.,]/', '', $value)));
													if (isset($save_data['stock_count'])) {
														$save_data['stock_count'] += $value;
													}
													else {
														$save_data['stock_count'] = $value;
													}
												}
												else {
													if (!empty($merge_cells) && isset($merge_cells[$field])) {
														$val = '';
														foreach ($merge_cells[$field] as $key) {
															if (isset($row[$key])) {
																$val .= $row[$key];
															}
														}
														$save_data[$type] = $val;
													}
													else {
														$save_data[$type] = $value;
													}

												}
											}
										}
										//debug($save_data);exit();
										if (isset($save_data['title'])) {
											if (substr_count(mb_strtolower($save_data['title']), 'диск')) {
												$not_founded_fields = array();
												$not_founded_fields = $required_fields;
												$errors[] = __d('admin_import', 'convert_error', $sheet_number + 1, $i, implode(', ', $not_founded_fields));
												$total_error_rows ++;
												continue;
											}
											$replaces = array('Корея', 'с камерой без ободной ленты', 'Франция', 'Англия', 'Германия', 'Сербия', 'Испания', 'Италия', 'Япония', 'Герм', 'Фра', ' 2007г', ' 2008г', ' 2009г', '2010г', '2011г', '2012г', '2013г', ' 2009', ' 2010', ' 2011', ' 2012', ' 2013', '2010', 'Рос', 'ЮАР', 'Чех', 'США', 'Словения', 'Пол', ' с кам', 'осевые', 'рулевые', 'спец.цена', 'безкамерная', 'бескамерная', 'відновл.', 'камерная', 'акция', 'АКЦИЯ', 'акци', 'АКЦИ', 'б/к', '2007год', 'retread', 'з обідною стрічкою', 'grnx', 'камерна', 'с камерой', 'з камерою', 'owl', 'DOT-09', 'DOT-08', '2008г', 'прих.23,08+8шт', 'прих.15,08', 'Китай', 'прих.22,08+16шт', 'прих.23,08', 'прих.22,08', '10год', '10г', 'Исп', 'Гер', 'Ита', 'Фр', 'год');
											$replaces_at_the_end = array(
												'south africa',
												'south afri',
												'indonesia',
												'malaysia',
												'indonesi',
												'columbia',
												'vietnam',
												'indones',
												'serbia',
												'mexica',
												'spain',
												'slov',
												'cheh',
												'phil',
												'port',
												'tail',
												'serb',
												'taiw',
												'arg',
												'rom',
												'usa',
												'seb',
												'mex',
												'idn',
												'fra',
												'chi',
												'tur',
												'jap',
												'fin',
												'bra',
												'kor',
												'spa',
												'rus',
												'hun',
												'ita',
												'pol',
												'eng',
												'ger',
												'tu',
												'us',
												'ua',
												'ge',
												'de',
												'tw',
												'сн',
												'tr',
												'kr',
												'bl',
												'ro'
											);
											$symbols = array(', :', '*,', '*', '(2,4)', '(2)', '(4)', ' :', 'а/ш');
											$title = $save_data['title'];
											$title = trim(preg_replace('/\bXL\b|\bTT\b|\bTL\b|\bM\+S\b|\bM\.S\b|\bM\&S\b|\bMS\b|\bMud\+Snow\b/i', ' ', $title));
											$title = trim(str_ireplace(array(' (шт.)', ' (<>)', 'Автопокрышки ', ' бескамерная', 'Шина ', '"', 'Автошина'), ' ', $title));
											$title = trim(str_ireplace($replaces, ' ', $title));
											$title = trim(str_ireplace($symbols, ' ', $title));
											$title = trim(str_ireplace($symbols, ' ', $title));
											
											$title = trim(preg_replace('/\b[0-9]+\sсл\b/ui', ' ', $title));
											/*
											if ($i == 522) {
												debug($save_data);
												debug($title);
												exit();
											}
											*/
											foreach ($replaces_at_the_end as $value) {
												if (preg_match('/(\s|^)' . preg_quote($value) . '$/ui', $title, $mathces)) {
													$title = trim(preg_replace('/' . preg_quote(trim($mathces[0])) . '$/i', ' ', $title));
													break;
												}
											}
										}
										if (isset($save_data['season_type'])) {
											$season_type = trim(str_replace('4x4', '', $save_data['season_type']));
											$parts = explode(' ', $season_type);
											foreach ($parts as $part) {
												$part = trim($part);
												if (!empty($part)) {
													$part = mb_strtolower($part);
													if (isset($product_seasons[$part])) {
														$save_data['season'] = $product_seasons[$part];
													}
													elseif (isset($product_autos[$part])) {
														$save_data['auto'] = $product_autos[$part];
													}
												}
											}
										}
										// find brand
										if (!isset($save_data['brand']) && isset($title)) {
											$brand_title = trim($this->_clean_text($title));
											foreach ($brands as $brand => $brand_id) {
												if (preg_match('/(\s|^|\()' . $brand . '(\)|\s|$)/', $brand_title, $mathces)) {
													$title = trim(preg_replace('/' . trim($mathces[0]) . '/i', '', $title));
													$save_data['brand'] = trim($mathces[0]);
													break;
												}
											}
										}
										// find size1, size2 and size3
										if (!isset($save_data['size1']) || !isset($save_data['size2']) || !isset($save_data['size3'])) {
											if (isset($save_data['size'])) {
												$size_title = $save_data['size'];
											}
											elseif (isset($title)) {
												$size_title = $title;
											}
											if (isset($size_title)) {
												if (preg_match('/(\s|^)([0-9\.,]{1,4})(-|\/)([0-9\.,]{1,4})\s*(-|\/|R-|ZR|PR|LTR)([0-9\.,CС ]{2,4})(\s|\/[0-9]+|$)/iu', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[2]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[4]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[6]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												//315/35 20
												elseif (preg_match('/\b([0-9]{1,4})\/([0-9\.,]{1,4})(r|\s)([0-9\.,CС ]{2,4})\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[1]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[2]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[4]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/(\s|^)([0-9\.,]{1,4})(-|\/|x)([0-9\.,]{1,4})\s*(-|\/|R)([0-9\.,CС ]{2,4})\sC(\s|\/[0-9]+|$)/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[2]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[4]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[6]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/\b([0-9]{1,4})\/([0-9]{2,4})\b\s*R([0-9\.,CС ]{2,4})/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[1]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[2]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[3]);
												}
												//R17 215/60
												elseif (preg_match('/\bR([0-9\.,CС ]{2,4})\s([0-9]{1,4})\/([0-9\.,]{1,4})\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[2]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[3]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[1]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/\b([0-9]{1,4})\/([0-9\.,CС ]{2,4})\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[1]);
													$save_data['size2'] = 0;
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[2]);
												}
												elseif (preg_match('/(\s|^)([0-9\.,]{1,4})(-|\/|x)([0-9\.,]{1,4})\s*(-|\/|R)([0-9\.,CС ]{2,4})(\s|\/[0-9]+|$)/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[2]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[4]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[6]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/(\s|^)R*([0-9R\.,CС]{2,})(\s)([0-9\.,]{1,4})(-|\/)([0-9\.,]{1,4})(\s|$)/ui', $size_title, $mathces)) {
													$save_data['size1'] = str_ireplace(',', '.', $mathces[4]);
													$save_data['size2'] = str_ireplace(',', '.', $mathces[6]);
													$save_data['size3'] = str_ireplace(array(',', 'С', 'с', ' '), array('.', 'C', 'C', ''), $mathces[2]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/(\s|^)([0-9]{3})\s?r([0-9]{2})c(\s|$)/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[2];
													$save_data['size2'] = '';
													$save_data['size3'] = $mathces[3];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
												elseif (preg_match('/\b([0-9,]{2,})R([0-9,]{2,})\s*\(([0-9,]{2,})R([0-9,]{2,})\)\/[0-9]+\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[1];
													$save_data['size2'] = '0';
													$save_data['size3'] = $mathces[2];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
												elseif (preg_match('/\b([0-9,]{2,})R([0-9,]{2,})\s*\(([0-9,]{2,})R([0-9,]{2,})\)/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[1];
													$save_data['size2'] = '0';
													$save_data['size3'] = $mathces[2];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
												elseif (preg_match('/\b([0-9,]{2,})R([0-9,]{2,})\/[0-9]+\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[1];
													$save_data['size2'] = '0';
													$save_data['size3'] = $mathces[2];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
												elseif (preg_match('/\b([0-9,]+)R([0-9,]{2,})\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[1];
													$save_data['size2'] = '0';
													$save_data['size3'] = $mathces[2];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
												elseif (preg_match('/\b([0-9\.]+)\s*R([0-9\.]{2,})\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[1];
													$save_data['size2'] = '0';
													$save_data['size3'] = $mathces[2];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
												elseif (preg_match('/\b([0-9,]+)-([0-9,]{2,})\b/ui', $size_title, $mathces)) {
													$save_data['size1'] = $mathces[1];
													$save_data['size2'] = '0';
													$save_data['size3'] = $mathces[2];
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], '', $title));
													}
												}
											}
										}
										else {
											$save_data['size2'] = str_replace(array('/', 'C', 'C'), '', $save_data['size2']);
											$save_data['size3'] = str_replace(array('R', 'D'), '', $save_data['size3']);
										}
										if (isset($save_data['stock_count'])) {
											$save_data['stock_count'] = intval(trim(preg_replace('/[^0-9\.,]/', '', $save_data['stock_count'])));
										}
										if (isset($save_data['price'])) {
											$save_data['price'] = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $save_data['price']))));
										}
										// find f1 and f2
										if (!isset($save_data['f']) || !isset($save_data['f1']) || !isset($save_data['f2'])) {
											if (isset($save_data['f'])) {
												$f_title = $save_data['f'];
											}
											elseif (isset($title)) {
												$f_title = $title;
											}
											if (isset($f_title)) {
												if (preg_match('/\b([0-9]{2,}\/[0-9]{2,})\s*(F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н)\b/ui', $f_title, $mathces)) {
													$save_data['f1'] = $mathces[1];
													$save_data['f2'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[2]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/\b([0-9]{2,})\s*(F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н)\b/ui', $f_title, $mathces)) {
													$save_data['f1'] = $mathces[1];
													$save_data['f2'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[2]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/\b([0-9]{3,})\s*((A|B|C|D|E|F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н)[1-8]*)\b/ui', $f_title, $mathces)) {
													$save_data['f1'] = $mathces[1];
													$save_data['f2'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[2]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/\b(([0-9]{3,})\s*((A|B|C|D|E|F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н)[1-8]*))\/(([0-9]{3,})\s*(A|B|C|D|E|F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н))\b/ui', $f_title, $mathces)) {
													$save_data['f1'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[1]);
													$save_data['f2'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[5]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
												elseif (preg_match('/\b(([0-9]{3,})\s*(A|B|C|D|E|F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н))\/(([0-9]{3,})\s*((A|B|C|D|E|F|G|J|K|L|M|N|P|Q|R|S|T|U|H|V|VR|W|Y|ZR|К|М|Р|Т|Н)[1-8]*))\b/ui', $f_title, $mathces)) {
													$save_data['f1'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[1]);
													$save_data['f2'] = str_ireplace(array('К', 'М', 'Р', 'Т', 'Н'), array('K', 'M', 'P', 'T', 'H'), $mathces[4]);
													if (isset($title)) {
														$title = trim(str_ireplace($mathces[0], ' ', $title));
													}
												}
											}
										}
										if (isset($save_data['f1']) && isset($save_data['f2']) && isset($title)) {
											$title = trim(str_ireplace(array(',' . $save_data['f1'] . $save_data['f2'], ' ' . $save_data['f1'] . $save_data['f2']), ' ', $title));
										}
										if (isset($save_data['size1']) && isset($save_data['size2']) && isset($save_data['size3']) && isset($title)) {
											$title = trim(preg_replace('/' . preg_quote($save_data['size1'], '/') . '[A-zА-я\\/-]' . preg_quote($save_data['size2'], '/') . '[A-zА-я\\/ -]*' . preg_quote($save_data['size3'], '/') . '[A-zА-я\\/-]*/ui', ' ', $title));
											if ($save_data['size2'] == '') {
												$title = trim(preg_replace('/' . preg_quote($save_data['size1'], '/') . '[A-zА-я\\/-]' . preg_quote($save_data['size3'], '/') . '[A-zА-я\\/-]*/ui', ' ', $title));
											}
											if ($save_data['size3'] == 'S' || $save_data['size3'] == 'T') {
												$title = trim(preg_replace('/' . preg_quote($save_data['size1'], '/') . '[A-zА-я\\/-]' . preg_quote($save_data['size2'], '/') . '[A-zА-я\\/ -]{1,2}/ui', ' ', $title));
											}
										}
										if (isset($save_data['size3'])) {
											if (substr_count($save_data['size3'], 'C') > 0) {
												$product_auto = 'легкогрузовая';
											}
											//$save_data['size3'] = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $save_data['size3']))));
										}
										if (isset($save_data['size1']) && isset($save_data['size3']) && !isset($save_data['size2'])) {
											$save_data['size2'] = '00';
										}

										if (isset($save_data['size2']) && ($save_data['size2'] == '' || $save_data['size2'] == '0')) {
											$save_data['size2'] = '00';
										}
										//debug($title);
										if (isset($save_data['brand']) && isset($title)) {
											$title = trim(preg_replace('/\(' . $save_data['brand'] . '\)/ui', '', $title));
											$title = trim(preg_replace('/' . $save_data['brand'] . '/ui', ' ', $title));
										}
										// find stud
										if (!$has_stud_column) {
											if (isset($title)) {
												foreach ($product_studs as $key => $value) {
													if (preg_match('/(\s|^|\(|)' . preg_quote($key, '/') . '(,|\)|\s|$)/ui', $title, $mathces)) {
														$title = trim(preg_replace('/' . preg_quote(trim($mathces[0]), '/') . '/i', ' ', $title));
														$save_data['stud'] = $value;
														break;
													}
												}
											}
										}
										elseif (isset($save_data['stud'])) {
											$stud = mb_strtolower($save_data['stud']);
											if (isset($product_studs[$stud])) {
												$save_data['stud'] = $product_studs[$stud];
											}
										}
										if (!isset($save_data['auto']) && !empty($product_auto)) {
											$save_data['auto'] = $product_auto;
										}
                                        // find run flat and xl

                                        $tyre_title = mb_strtolower($title);

                                        $save_data['p4'] = 0;
                                        $save_data['p5'] = 0;

                                        if (substr_count($tyre_title, ' xl')) {
                                            $save_data['p4'] = 1;
                                        }
                                        if (substr_count($tyre_title, 'extra load')) {
                                            $save_data['p4'] = 1;
                                        }
                                        if (substr_count($title, ' RF')) {
                                            $save_data['p5'] = 1;
                                        }
                                        if (substr_count($tyre_title, 'run flat')) {
                                            $save_data['p5'] = 1;
                                        }
                                        if (substr_count($tyre_title, 'run-flat')) {
                                            $save_data['p5'] = 1;
                                        }
                                        if (substr_count($tyre_title, 'runflat')) {
                                            $save_data['p5'] = 1;
                                        }

										if (!isset($save_data['axis']) && isset($title)) {
											foreach ($product_axis as $key => $value) {
												if (preg_match('/\b' . preg_quote($key, '/') . '\b/ui', $title, $mathces)) {
													$title = trim(preg_replace('/' . preg_quote(trim($mathces[0]), '/') . '/i', ' ', $title));
													$save_data['axis'] = $value;
													break;
												}
											}
										}
										if (isset($save_data['axis'])) {
											$save_data['auto'] = 'грузовой';
											$axis = mb_strtolower($save_data['axis']);
											if (isset($product_axis[$axis])) {
												$save_data['axis'] = $product_axis[$axis];
											}
										}
										elseif (isset($save_data['auto'])) {
											$auto = mb_strtolower($save_data['auto']);
											if (isset($product_autos[$auto])) {
												$save_data['auto'] = $product_autos[$auto];
											}
										}
										if (isset($save_data['brand'])) {
											$save_data['brand'] = str_ireplace(array(' $', ' ГРН'), '', $save_data['brand']);
											$save_data['brand'] = $this->_clean_text($save_data['brand']);
											if (isset($brands[$save_data['brand']])) {
												$save_data['brand_id'] = $brands[$save_data['brand']];
												// find model
												if (!isset($save_data['model']) && isset($title)) {
													$save_data['model'] = $title;
												}
												if (isset($save_data['model'])) {
													$save_data['model'] = trim(str_ireplace(array('відновл.', 'лента', 'кольцо', 'DOT-09', 'DOT-08', 'DOT-07', 'Graphite', 'silver', 'black', '(runflat)', '(п\слик)', '(п\ш)', 'п/ш', 'слик', 'rwl', 'owl', 'пш', 'wsw'), ' ', $save_data['model']));
													$save_data['model'] = trim(preg_replace('/\b(xl|mfs|mo|rf|ms|rof|ao|шип)\b/ui', ' ', $save_data['model']));
													$save_data['model'] = trim($this->_clean_text($save_data['model'], false));
													if (isset($models[$save_data['brand_id']][$save_data['model']])) {
														$save_data['model_id'] = $models[$save_data['brand_id']][$save_data['model']];
													}
													else {
														$model_id = md5($save_data['model']);
														$models_by_id[$model_id] = $save_data['model'];
														$models[$save_data['brand_id']][$save_data['model']] = $model_id;
														$save_data['model_id'] = $model_id;
													}
												}
											}
										}
										if (!isset($save_data['season']) && !empty($product_season)) {
											$save_data['season'] = $product_season;
										}
										elseif (isset($save_data['season'])) {
											$season = mb_strtolower($save_data['season']);
											if (isset($product_seasons[$season])) {
												$save_data['season'] = $product_seasons[$season];
											}
										}
										$isset_all_fields = true;
										foreach ($required_fields as $field) {
											if (!isset($save_data[$field])) {
												$isset_all_fields = false;
												break;
											}
										}
										if ($isset_all_fields) {
											$products[] = $save_data;
											$total_converted_rows ++;
										}
										else {
											$not_founded_fields = array();
											foreach ($required_fields as $field) {
												if (!isset($save_data[$field])) {
													if ($field == 'model_id') {
														if (isset($save_data['model']) && !empty($save_data['model'])) {
															$not_founded_fields[] = __d('admin_import', 'reqired_field_model', $save_data['model']);
														}
														else {
															$not_founded_fields[] = __d('admin_import', 'reqired_field_' . $field);
														}
													}
													else {
														$not_founded_fields[] = __d('admin_import', 'reqired_field_' . $field);
													}
												}
											}
											$errors[] = __d('admin_import', 'convert_error', $sheet_number + 1, $i, implode(', ', $not_founded_fields));
											$total_error_rows ++;
										}



									}
								}
							}
						}
						if (!empty($products)) {
							app::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel' . DS . 'PHPExcel.php'));
							$objPHPExcel = new PHPExcel();
							$i = 1;
							foreach ($products as $item) {
								if (!isset($item['f1'])) {
									$item['f1'] = '';
								}
								if (!isset($item['f2'])) {
									$item['f2'] = '';
								}
								$sku = trim($brands_by_id[$item['brand_id']] . ' ' . $models_by_id[$item['model_id']] . ' ' . $item['size1'] . '/' . $item['size2'] . ' R' . $item['size3'] . ' ' . $item['f1'] . $item['f2']);
								$objPHPExcel->setActiveSheetIndex(0)
											->setCellValueExplicit('A' . $i, $brands_by_id[$item['brand_id']])
											->setCellValueExplicit('B' . $i, $models_by_id[$item['model_id']])
											->setCellValueExplicit('C' . $i, $sku)
											->setCellValueExplicit('F' . $i, $item['size1'])
											->setCellValueExplicit('G' . $i, $item['size2'])
											->setCellValueExplicit('H' . $i, $item['size3'])
											->setCellValueExplicit('I' . $i, $item['f1'])
											->setCellValueExplicit('J' . $i, $item['f2']);
								if (isset($item['price'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P' . $i, $item['price']);
								}
								if (isset($item['stock_count'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N' . $i, $item['stock_count']);
								}
								if (isset($item['season'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D' . $i, $item['season']);
								}
								if (isset($item['auto'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E' . $i, $item['auto']);
								}
								if (isset($item['stud'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L' . $i, $item['stud']);
								}
								if (isset($item['axis'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E' . $i, $item['axis']);
								}
                                if (isset($item['p4']) && $item['p4'] != 0) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('T' . $i, 'XL');
                                }
                                if (isset($item['p5']) && $item['p5'] != 0) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('U' . $i, 'RUN FLAT');
                                }
								$i ++;
							}
							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
							$filename = md5(uniqid(rand(), true)) . '.xls';
							$objWriter->save(WWW_ROOT . 'xls' . DS . $filename);
							$this->set('filename', $filename);
							$this->info($this->t('message_item_converted'));
						}
						else {
							$this->error($this->t('error_no_products_found'));
						}
						$stat = array(
							'total_rows_count' => $total_rows_count,
							'total_converted_rows' => $total_converted_rows,
							'total_sheets_count' => $total_sheets_count,
							'total_skipped_rows' => $total_skipped_rows,
							'total_error_rows' => $total_error_rows
						);
						$this->set('errors', $errors);
						$this->set('stat', $stat);
						//$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_convert'));
					}
					else {
						$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
					}
				}
				else {
					$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
				}
			}
			else {
				$this->error($this->t('error_item_not_converted'));
			}
		}
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_convert_tyres'));
		$this->render('admin_convert');
	}
	public function admin_convert_tubes() {
		$this->layout = 'admin'; 
		$this->loadModel('Import');
		if (!empty($this->request->data)) {
			$this->Import->set($this->request->data);
			unset($this->Import->validate['type']);
			if ($this->Import->validates()) {
				app::import('Vendor', 'Spreadsheet_Excel_Reader', array('file' => 'phpExcelReader' . DS . 'Excel' . DS . 'reader.php'));
				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('UTF-8');
				if ($data->read(TMP . $this->Import->tmp_file)) {
					unlink(TMP . $this->Import->tmp_file);
					if (!empty($data)) {
						$column_fields = array(
							'ценовая группа/ номенклатура/ характеристика номенклатуры' => 'title',
							'номенклатура/ характеристика номенклатуры' => 'title',
							'маг' => 'price',
							'мин' => 'price',
							'спец' => 'price',
							'спецa' => 'price',
							'спецb' => 'price',
							'спецc' => 'price',
							'всего остаток' => 'stock_count',
							'наименование' => 'title',
							'опт' => 'price',
							'розница' => 'price',
							'склад' => 'stock_count',
							'товар' => 'title',
							'розничная цена, грн' => 'price',
							'оптовая цена, грн' => 'price',
							'основной склад (наличие,шт.)' => 'stock_count',
							'цена        склада 2, грн' => 'price',
							'склад 2 (наличие,шт.)' => 'stock_count',
						);
						$required_fields = array(
							'title',
							'type'
						);
						$errors = array();
						$products = array();
						$total_rows_count = 0;
						$total_sheets_count = 0;
						$total_converted_rows = 0;
						$total_skipped_rows = 0;
						$total_error_rows = 0;
						$product_types = array(
							'автокамера' => 'автокамера',
							'мотокамера' => 'мотокамера',
							//'ущільнювальне кільце' => 'подшип',
							'обідна стрічка \(фліпер\)' => 'ободная лента',
							'ободные ленты' => 'ободная лента',
							'автокамеры' => 'автокамера',
							'камера' => 'автокамера',
							'ободная лента' => 'ободная лента',
							'Фліпер' => 'ободная лента'
						);
						$merge_cells = array();
						//debug($data);exit();
						//debug($data->sheets);exit();
						foreach ($data->sheets as $sheet_number => $sheet) {
							$total_sheets_count ++;
							$fields_order = array();
							// find first line
							$first_line = null;
							if (isset($sheet['cells'])) {
								foreach ($sheet['cells'] as $i => $row) {
									$total_rows_count ++;
									if (count($row) < 2) {
										$total_skipped_rows ++;
										continue;
									}
									$first_line = $i;
									//debug($row);
									foreach ($row as $j => $cell) {
										$cell = trim(mb_strtolower(str_replace(array("\n", "\r"), '', $cell)));
										if (isset($column_fields[$cell])) {
											$fields_order[$j] = $column_fields[$cell];
										}
									}
									if (count($fields_order) < 2) {
										continue;
									}
									break;
								}
							}
							if (!empty($fields_order)) {
								//debug($fields_order);exit();
								if ($sheet_number == 10) {
									//debug($fields_order);exit();
									//debug($sheet['cells']);exit();
								}
								$product_type = null;
								$has_type_column = in_array('type', $fields_order);
								foreach ($sheet['cells'] as $i => $row) {
									//debug($row);
									if ($i > $first_line) {
										$total_rows_count ++;
										// find season and auto here
										if (count($row) < 3) {
											$total_skipped_rows ++;
											if (!$has_type_column) {
												foreach ($row as $cell_value) {
													$cell_value = trim(mb_strtolower($cell_value));
													if (!$has_type_column) {
														foreach ($product_types as $key => $value) {
															if (preg_match('/(\s|^)' . $key . '(\s|$)/ui', $cell_value, $mathces)) {
																$product_type = $value;
																break;
															}
														}
													}
												}
											}
											continue;
										}
										$save_data = array();
										foreach ($row as $field => $value) {
											if (isset($fields_order[$field])) {
												$type = $fields_order[$field];
												$value = trim($value);
												if ($type == 'price') {
													$value = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $value))));
													if (isset($save_data['price'])) {
														$save_data['price'] = min($value, $save_data['price']);
													}
													else {
														$save_data['price'] = $value;
													}
												}
												elseif ($type == 'stock_count') {
													$value = abs(intval(preg_replace('/[^0-9\.,]/', '', $value)));
													if (isset($save_data['stock_count'])) {
														$save_data['stock_count'] += $value;
													}
													else {
														$save_data['stock_count'] = $value;
													}
												}
												else {
													if (!empty($merge_cells) && isset($merge_cells[$field])) {
														$val = '';
														foreach ($merge_cells[$field] as $key) {
															if (isset($row[$key])) {
																$val .= $row[$key];
															}
														}
														$save_data[$type] = $val;
													}
													else {
														$save_data[$type] = $value;
													}

												}
											}
										}
										// find type
										if (!$has_type_column) {
											if (isset($save_data['title'])) {
												foreach ($product_types as $key => $value) {
													if (preg_match('/(\s|^)' . $key . '(\s|$)/ui', $save_data['title'], $mathces)) {
														$save_data['title'] = trim(str_ireplace(trim($mathces[0]), ' ', $save_data['title']));
														$save_data['type'] = $value;
														break;
													}
												}
											}
										}
										elseif (isset($save_data['type'])) {
											$type = mb_strtolower($save_data['type']);
											if (isset($product_types[$type])) {
												$save_data['type'] = $product_types[$type];
											}
										}
										if (isset($save_data['stock_count'])) {
											$save_data['stock_count'] = intval(trim(preg_replace('/[^0-9\.,]/', '', $save_data['stock_count'])));
										}
										if (isset($save_data['price'])) {
											$save_data['price'] = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $save_data['price']))));
										}
										if (isset($save_data['type']) && isset($save_data['title'])) {
											$products[] = $save_data;
											$total_converted_rows ++;
										}
										else {
											$not_founded_fields = array();
											foreach ($required_fields as $field) {
												if (!isset($save_data[$field])) {
													$not_founded_fields[] = __d('admin_import', 'reqired_field_' . $field);
												}
											}
											$errors[] = __d('admin_import', 'convert_error', $sheet_number + 1, $i, implode(', ', $not_founded_fields));
											$total_error_rows ++;
										}
										/*
										if ($i  == 11) {
											debug($row);
											debug($save_data);
											exit();
										}
										*/
										
										
									}
								}
							}
						}
						if (!empty($products)) {
							app::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel' . DS . 'PHPExcel.php'));
							$objPHPExcel = new PHPExcel();
							$i = 1;
							foreach ($products as $item) {
								$objPHPExcel->setActiveSheetIndex(0)
											->setCellValueExplicit('A' . $i, $item['type'])
											->setCellValueExplicit('B' . $i, $item['title']);
								if (isset($item['price'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E' . $i, $item['price']);
								}
								if (isset($item['stock_count'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $i, $item['stock_count']);
								}
								$i ++;
							}
							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
							$filename = md5(uniqid(rand(), true)) . '.xls';
							$objWriter->save(WWW_ROOT . 'xls' . DS . $filename);
							$this->set('filename', $filename);
							$this->info($this->t('message_item_converted'));
						}
						else {
							$this->error($this->t('error_no_products_found'));
						}
						$stat = array(
							'total_rows_count' => $total_rows_count,
							'total_converted_rows' => $total_converted_rows,
							'total_sheets_count' => $total_sheets_count,
							'total_skipped_rows' => $total_skipped_rows,
							'total_error_rows' => $total_error_rows
						);
						$this->set('errors', $errors);
						$this->set('stat', $stat);
						//$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_convert'));
					}
					else {
						$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
					}
				}
				else {
					$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
				}
			}
			else {
				$this->error($this->t('error_item_not_converted'));
			}
		}
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_convert_tubes'));
		$this->render('admin_convert');
	}
	public function admin_convert_disks() {
		$this->layout = 'admin'; 
		$this->loadModel('Import');
		if (!empty($this->request->data)) {
			$this->Import->set($this->request->data);
			unset($this->Import->validate['type']);
			if ($this->Import->validates()) {
				app::import('Vendor', 'Spreadsheet_Excel_Reader', array('file' => 'phpExcelReader' . DS . 'Excel' . DS . 'reader.php'));
				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('UTF-8');
				if ($data->read(TMP . $this->Import->tmp_file)) {
					unlink(TMP . $this->Import->tmp_file);
					if (!empty($data)) {
						$column_fields = array(
							'r' => 'radius',
							'ширина' => 'dia',
							'бренд' => 'brand',
							'модель' => 'model',
							'pcd' => 'pcd',
							'et' => 'et',
							'dia' => 'hub',
							'hub' => 'dia',
							'pcd диска (св-во номенклатура)' => 'pcd',
							'размер (св-во номенклатура)' => 'et',
							'остаток' => 'stock_count',
							'наличие на складе, шт' => 'stock_count',
							'цена i' => 'price',
							'цена ii' => 'price',
							'цвет' => 'color',
							'группа' => 'brand',
							'номер' => 'title',
							'название' => 'model',
							'количество' => 'stock_count',
							'розничная' => 'price',
							'ценовая группа/ номенклатура/ характеристика номенклатуры' => 'title',
							'маг' => 'price',
							'мин' => 'price',
							'спец' => 'price',
							'спецa' => 'price',
							'спецb' => 'price',
							'спецc' => 'price',
							'всего остаток' => 'stock_count',
							'товар' => 'title',
							'колич' => 'stock_count',
							'оптовая' => 'price',
							'номенклатура' => 'title',
							'базова' => 'price',
							'остаток' => 'stock_count',
							'цена оптовая, usd' => 'price',
							'склад' => 'stock_count',
							'производитель' => 'brand',
							'наименование' => 'title',
							'цена опт.' => 'price',
							'ост.' => 'stock_count',
							'розница' => 'price',
							'оптовая' => 'price',
							'категория 2' => 'price',
							'категория 3 (мин)' => 'price',
							'тм' => 'brand',
							'наименование товара' => 'title',
							'предоплата' => 'price',
							'острочка' => 'price',
							'остатокпо фирме' => 'stock_count',
							'размер' => 'size1',
							'ширина диска (св-во номенклатура)' => 'size1',
							'pcd1' => 'size2',
							'pcd2' => 'pcd2',
							'ет + ступ' => 'size3',
							'кр. опт' => 'price',
							'кво' => 'stock_count',
							'тмц' => 'title',
							'заказ' => 'price',
							'номенклатура/ характеристика номенклатуры' => 'title',
							'диллерская' => 'price',
							'завод' => 'brand',
							'рсd' => 'pcd',
							'ет' => 'et',
							'оптовая цена, грн' => 'price',
							'основной склад (наличие,шт.)' => 'stock_count',
							'склад 1' => 'stock_count',
							'склад 2' => 'stock_count',
							'цена        склада 2, грн' => 'price',
							'склад 2 (наличие,шт.)' => 'stock_count',
							'вылет' => 'et',
							'nb' => 'hub',
							'диллер' => 'price',
							'опт' => 'price',
							'диаметр' => 'radius',
							'посадочный диаметр (св-во номенклатура)' => 'radius',
							'основной, шт' => 'stock_count',
							'прайс 20' => 'price',
							'кр.опт' => 'price',
							'serie' => 'brand',
							'hub ø' => 'hub',
							'name' => 'model',
							'coulor' => 'color',
							'база' => 'price',
							'от 2000' => 'price',
							'от 5000' => 'price',
							'от 8000' => 'price',
							'от 12000' => 'price',
							'от 15000' => 'price',
							'кп' => 'price',
							'цена' => 'price',
							'size' => 'size1',
							'наименование товаров' => 'title',
							'бренд' => 'brand',
							'ширина диска (св-во номенклатура)' => 'dia',
							'тмц' => 'title',
							'количество' => 'stock_count',
							'свободный остаток' => 'stock_count',
							'цена, руб.' => 'price',
							'розничная, руб.' => 'price',

						);
						$required_fields = array(
							'brand_id',
							'model_id',
							'radius',
							'pcd',
							'dia',
							'et',
							'hub'
						);
						$product_colors = array(
						);
						
						$product_materials=$this->product_materials;
						
						

						$errors = array();
						$products = array();
						$total_rows_count = 0;
						$total_sheets_count = 0;
						$total_converted_rows = 0;
						$total_skipped_rows = 0;
						$total_error_rows = 0;
						$this->loadModel('Brand');
						$this->loadModel('BrandModel');
						$this->loadModel('ModelSynonym');
						$this->loadModel('BrandSynonym');
						$category_id = 2;
						$brands = Cache::read('import_brands_' . $category_id, 'long');
						$models = Cache::read('import_models_' . $category_id, 'long');
						$models_by_id = Cache::read('import_models_by_id_' . $category_id, 'long');
						$brands_by_id = Cache::read('import_brands_by_id_' . $category_id, 'long');
						if (empty($brands)) {
							$all_brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'fields' => array('Brand.title', 'Brand.id')));
							$all_models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => $category_id), 'fields' => array('BrandModel.id', 'BrandModel.brand_id', 'BrandModel.title')));
							$model_synonyms = $this->ModelSynonym->find('all');
							$brand_synonyms = $this->BrandSynonym->find('all');
							$brands = array();
							$models = array();
							$models_by_id = array();
							$brands_by_id = array();
							foreach ($all_brands as $brand => $id) {
								$brand = trim($this->_clean_text($brand));
								if (mb_strlen($brand) > 1) {
									$brands[$brand] = $id;
									$brands_by_id[$id] = $brand;
								}
								foreach ($brand_synonyms as $synonym) {
									if ($synonym['BrandSynonym']['brand_id'] == $id) {
										$brand = trim($this->_clean_text($synonym['BrandSynonym']['title']));
										$brands[$brand] = $id;
									}
								}
							}
							uksort($brands, 'cmp');
							foreach ($all_models as $item) {
								if (!isset($models[$item['BrandModel']['brand_id']])) {
									$models[$item['BrandModel']['brand_id']] = array();
								}
								$model = $this->_clean_text($item['BrandModel']['title'], false);
								$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
								$models_by_id[$item['BrandModel']['id']] = $model;
								foreach ($model_synonyms as $synonym) {
									if ($synonym['ModelSynonym']['model_id'] == $item['BrandModel']['id']) {
										$model = $this->_clean_text($synonym['ModelSynonym']['title'], false);
										$models[$item['BrandModel']['brand_id']][$model] = $item['BrandModel']['id'];
									}
								}
								uksort($models[$item['BrandModel']['brand_id']], 'cmp');
							}
							Cache::write('import_brands_' . $category_id, $brands, 'long');
							Cache::write('import_models_' . $category_id, $models, 'long');
							Cache::write('import_models_by_id_' . $category_id, $models_by_id, 'long');
							Cache::write('import_brands_by_id_' . $category_id, $brands_by_id, 'long');
						}
						$merge_cells = array();
						$fill_cells = array();
						//debug($data);exit();
						//debug($data->sheets);exit();
						$kik = false;
						foreach ($data->sheets as $sheet_number => $sheet) {
							$total_sheets_count ++;
							$fields_order = array();
							// find first line
							$first_line = null;
							if (isset($sheet['cells'])) {
								foreach ($sheet['cells'] as $i => $row) {
									$total_rows_count ++;
									if (count($row) < 3) {
										$total_skipped_rows ++;
										continue;
									}
									$first_line = $i;
									//var_dump($row);
									foreach ($row as $j => $cell) {
										$cell = trim(mb_strtolower(str_replace(array("\n", "\r"), '', $cell)));
										if (isset($column_fields[$cell])) {
											$fields_order[$j] = $column_fields[$cell];
										}
									}
									// исключения
									// file Прайс-лист Интершина 21.09.2012.xls
									if (isset($row[1]) && isset($row[3]) && isset($row[9]) && $row[1] == '№ п/п' && $row[3] == 'Размер' && $row[9] == 'Заказ') {
										$merge_cells[5] = array(4, 5, 3);
									}
									// file Прайс-лист на шины и диски_Омега_ 13.09.12.xls
									if (isset($row[1]) && isset($row[2]) && isset($row[3]) && $row[1] == 'Карточка' && $row[2] == 'Код' && $row[3] == 'Наименование') {
										$fields_order[5] = 'stock_count';
									}
									// file Склад-на-01-09-12-_D2.xls
									if (isset($row[4]) && isset($row[5]) && isset($row[6]) && $row[4] == 'PCD1' && $row[5] == 'PCD2' && $row[6] == 'ЕТ + Ступ') {
										$fields_order[2] = 'title';
										$fill_cells['brand'] = 'ZW';
									}

									// Залишки на 24.07.13 для менеджерів
									if (isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[9]) && $row[4] == 'Номенклатура.Номенклатурная группа.Батьківський елемент' && $row[2] == 'Номенклатура' && $row[3] == 'Остаток' && $row[9] == 'Кінцевий споживач') {
										$fill_cells['brand'] = 'WSP Italy';
									}

									// file Склад Диски.xls
									if (isset($row[1]) && isset($row[2]) && isset($row[3]) && $row[1] == 'Картинка' && $row[2] == 'ТМЦ' && $row[3] == 'Заказ') {
										$fill_cells['price'] = '0';
									}
									// file НОВИЙ ПРАЙС с 12.04.2012 рабочий.xls
									if (isset($row[1]) && isset($row[2]) && isset($row[3]) && $row[1] == 'Serie' && $row[2] == 'Model' && $row[3] == 'Size') {
										$fields_order[9] = 'hub';
										$fields_order[4] = 'radius';
										$fields_order[4] = 'radius';
									}
									// file Склад дисков КиК и Ifreeот06-05-2013
									if (isset($row[2]) && isset($row[3]) && isset($row[4]) && $row[2] == 'Номенклатура/ Характеристика номенклатуры' && $row[3] == 'Остаток' && $row[4] == 'Диллерская') {
										$kik = true;
									}
									if (count(array_unique($fields_order)) < 3) {
										//debug($fields_order);
										//$fields_order = array();
										continue;
									}
									break;
								}
							}

							//debug($fields_order);exit();
							if (!empty($fields_order)) {
								if ($sheet_number == 1) {
									
								}
								foreach ($sheet['cells'] as $i => $row) {
									//debug($row);
									if ($i > $first_line) {
										$total_rows_count ++;
										// find season and auto here
										if ((count($row) + count($fill_cells))  < 3) {
											$total_skipped_rows ++;
											continue;
										}
										$save_data = array();
										foreach ($row as $field => $value) {
											if (isset($fields_order[$field])) {
												$type = $fields_order[$field];
												$value = trim($value);
												if ($type == 'price') {
													$value = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $value))));
													if (isset($save_data['price'])) {
														$save_data['price'] = min($value, $save_data['price']);
													}
													else {
														$save_data['price'] = $value;
													}
												}
												elseif ($type == 'stock_count') {
													$value = abs(intval(preg_replace('/[^0-9\.,]/', '', $value)));
													if (isset($save_data['stock_count'])) {
														$save_data['stock_count'] += $value;
													}
													else {
														$save_data['stock_count'] = $value;
													}
												}
												else {
													if (!empty($merge_cells) && isset($merge_cells[$field])) {
														$val = '';
														foreach ($merge_cells[$field] as $key) {
															if (isset($row[$key])) {
																$val .= ' ' . $row[$key];
															}
														}
														$save_data[$type] = $val;
													}
													else {
														$save_data[$type] = $value;
													}
												}
											}
										}
										if (!empty($fill_cells)) {
											$save_data = array_merge($save_data, $fill_cells);
										}
										if (isset($save_data['title'])) {
											if (substr_count($save_data['title'], '_') >= 5) {
												$save_data['title'] = str_replace('_', ' ', $save_data['title']);
											}
											$title = trim($save_data['title']);
											$title = trim(str_ireplace(array(' (шт.)', 'Автодиски ', 'Диск колесный ', 'пр-во ', 'БЕЗ колпаков', 'задний', 'передний', '¶', '(1л)', '(2л)'), ' ', $title));
											$title = trim(preg_replace('/Арт[,.]?\s*[0-9A-z]+/iu', ' ', $title));
											$title = trim(preg_replace('/Арт[,.]?\s*[А-яA-z][0-9]+/iu', '', $title));
										}
										if (isset($save_data['model'])) {
											$save_data['model'] = trim(str_ireplace(array(' (шт.)', 'Автодиски ', 'Диск колесный ', 'пр-во ', 'БЕЗ колпаков', 'Задний', 'Передний'), ' ', $save_data['model']));
										}
										//debug($save_data);
										//exit();
										// find material
										if (!isset($save_data['color']) && isset($title)) {
											foreach ($product_materials as $key) {
												if (preg_match('/(\s|^)' . preg_quote($key, '/') . '(\s|$)/iu', $title, $mathces)) {
													//$title = trim(preg_replace('/\b' . preg_quote(trim($mathces[0]), '/') . '\b/iu', ' ', $title));
													$save_data['color'] = $key;
													break;
												}
											}
										}
										if (!isset($save_data['color']) && isset($save_data['model'])) {
											foreach ($product_materials as $key) {
												if (preg_match('/\b' . preg_quote($key, '/') . '\b/iu', $save_data['model'], $mathces)) {
													//$save_data['model'] = trim(preg_replace('/\b' . preg_quote(trim($mathces[0]), '/') . '\b/iu', ' ', $save_data['model']));
													$save_data['color'] = $key;
													break;
												}
											}
										}
										// find brand
										if (!isset($save_data['brand']) && isset($title)) {
											$brand_title = trim($this->_clean_text($title));
											foreach ($brands as $brand => $brand_id) {
												if (preg_match('/\b' . preg_quote($brand, '/') . '\b/u', $brand_title, $mathces)) {
													$title = trim(preg_replace('/' . preg_quote(trim($mathces[0]), '/') . '/iu', '', $title));
													$save_data['brand'] = trim($mathces[0]);
													break;
												}
											}
										}
										if (isset($save_data['brand'])) {
											if (mb_strtolower($save_data['brand']) == 'кик') {
												$title = trim(preg_replace('/\(.+?\)/ui', '', $title));
												$title = trim(preg_replace('/\(кс.+?\)/ui', '', $title));
											}
											elseif (mb_strtolower($save_data['brand']) == 'ifree') {
												$title = trim(preg_replace('/\(кс.+?\)/ui', '', $title));
											}
										}
										//debug($title);exit();
										if (isset($save_data['size1'])) {
											// 14  5x100/114,3
											if (preg_match('/^(R\-)?([0-9\.\,]+)\s+([0-9\,\/x\.]+)$/', $save_data['size1'], $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3];
											}
											// R13*5.5J
											elseif (preg_match('/R([0-9]+)\*([0-9\.]+)/', $save_data['size1'], $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['dia'] = $mathces[2];
											}
											// 16x6,5
											elseif (preg_match('/([0-9\,]+)x([0-9\,]+)/', $save_data['size1'], $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['dia'] = $mathces[2];
											}
											// 8,5X20
											elseif (preg_match('/([0-9\,]+)X([0-9\,]+)/', $save_data['size1'], $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['dia'] = $mathces[2];
											}
											// 20х8
											elseif (preg_match('/([0-9\,]+)х([0-9\,]+)/', $save_data['size1'], $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['dia'] = $mathces[2];
											}
										}
										// PCD4*98
										if (isset($save_data['size2'])) {
											if (preg_match('/(PCD)?([0-9]+)\*([0-9\.]+)/', $save_data['size2'], $mathces)) {
												$save_data['pcd'] = $mathces[2] . 'x' . $mathces[3];
											}
										}
										// 4*98
										if (isset($save_data['pcd2']) && !empty($save_data['pcd2'])) {
											//debug($save_data);
											$pcd_parts = explode('*', $save_data['pcd2']);
											if (isset($pcd_parts[1]) && isset($save_data['pcd'])) {
												$save_data['pcd'] .= '/' . $pcd_parts[1];
											}
											//debug($save_data);
											//exit();
										}
										// ET35 DIA 73.1
										if (isset($save_data['size3'])) {
											if (preg_match('/ET([0-9,\.]+)\sDIA\s([0-9\.]+)/', $save_data['size3'], $mathces)) {
												$save_data['et'] = $mathces[1];
												$save_data['hub'] = $mathces[2];
											}
										}
										if ($i == 16) {
											//debug($title);
											//exit();
										}
										if ((!isset($save_data['radius']) || !isset($save_data['pcd']) || !isset($save_data['dia']) || !isset($save_data['et']) || !isset($save_data['hub'])) && isset($title)) {
											// 15/5*100-114,3/40  6.5J  h 69.1
											if (preg_match('/([0-9]+)\/([0-9]\*[0-9,]+\-[0-9,]+)\/([0-9\.]+)\s+([0-9A-z\.]+)\s+h\s+([0-9\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2];
												$save_data['dia'] = $mathces[4];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[5];
											}
											//16/5*100/40  7.0J  h 69.1
											elseif (preg_match('/([0-9]+)\/([0-9]\*[0-9,]+)\/([0-9\.]+)\s+([0-9A-z\.]+)\s+h\s+([0-9\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2];
												$save_data['dia'] = $mathces[4];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[5];
											}
											//13 4/98 ET35 DIA58,6 H-113 HPT Racing Wheels
											elseif (preg_match('/([0-9]+)\s([0-9]+\/[0-9,]+)\sET([0-9\.]+)\sDIA([0-9,]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2];
												$save_data['hub'] = $mathces[4];
												$save_data['et'] = $mathces[3];
												//$save_data['hub'] = $mathces[5];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('1');
											}
											//14 8/98-100 ET35 DIA67,1 H-345 HS Racing Wheels
											elseif (preg_match('/([0-9]+)\s([0-9]+\/[0-9,]+\-[0-9,]+)\sET([0-9\.]+)\sDIA([0-9,]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2];
												$save_data['hub'] = $mathces[4];
												$save_data['et'] = $mathces[3];
												//$save_data['hub'] = $mathces[5];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('2');
											}
											//20х8,5     5/112/50/66.6  Replica Mercedes A-F803 S
											elseif (preg_match('/([0-9]+)х([0-9,]+)\s+([0-9]+)\/([0-9\.,-]+)\/([0-9]+)\/([0-9\.,]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['dia'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('3');
											}
											// 'Аркада Нова Алмаз  5,5*14 ЕТ18 4*108 67,1 черный Арт 5791';
											elseif (preg_match('/([0-9,]+)\*([0-9,\.]+)\s+ЕТ\s?([0-9,\.]+)\s+([0-9\.]+)\*([0-9,\.\/]+)\s+([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('4');
											}
											// 'Имола  6,5*15 ЕТ35  5*100 DIA 67,1сильвер  Арт. 4706';
											elseif (preg_match('/([0-9,]+)\*([0-9,\.]+)\s+ЕТ\s?([0-9,\.]+)\s+([0-9\.]+)\*([0-9,\.\/]+)\s+DIA\s+([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('5');
											}
											// 7,5x17 159  AL37 W237 5x98 35 58,1 SILVER
											elseif (preg_match('/([0-9,]+)x([0-9,\.]+)(.+?)([0-9\.]+)x([0-9,\.\/]+)\s+([0-9,\.]+)\s+([0-9,\.]+).+?/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[6];
												$save_data['hub'] = $mathces[7];
												$title = trim($mathces[3]);
											}
											// 'Андорра (КС496-0?) 6x15 ЕТ 45 5x100  67,1 алмаз аргентум Арт.11696';
											elseif (preg_match('/([0-9,]+)х([0-9,\.]+)\s+ЕТ\s?([0-9,\.]+)\s+([0-9\.]+)х([0-9,\.\/]+)\s+([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('6');
											}
											// 'Baretta 305 5.5x13 ET30 4x98 67.1 S';
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+ET\s?([0-9,\.]+)\s+([0-9\.]+)x([0-9,\.\/]+)\s+([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('6');
											}
											// 'Luxury 306 5.5x13 ET30 4x98  DIA67.1 B';
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+ET\s?([0-9,\.]+)\s+([0-9\.]+)x([0-9,\.\/]+)\s+DIA([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('6');
											}
											//Диксон -оригинал  7х16 ЕТ 20  5х120 x 72,6 алмаз графит Арт.r 4762
											elseif (preg_match('/([0-9,]+)х([0-9,\.]+)\s+ЕТ\s?([0-9,\.]+)\s+([0-9\.]+)х([0-9,\.\/]+)\s+x\s?([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['dia'] = $mathces[1];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('7');
											}
											// 7,0x16 FLORENCE AU33 W533 5x100/112 35 57,1 SILVER
											// 7,5x17 159 Misano AL37 W237 5x98 35 58,1 SILVER
											elseif (preg_match('/([0-9,]+)x([0-9,]+)\s(.+?)\s([0-9]+)x([0-9,\/]+)\s([0-9,]+)\s([0-9,]+)/', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['et'] = $mathces[6];
												$save_data['hub'] = $mathces[7];
												$title = trim(str_ireplace($mathces[0], $mathces[3], $title));
												//debug('8');
											}
											// 13" 4*100 5,0 Et35 D67,1  -320 BPBlu
											elseif (preg_match('/([0-9]+)\" ([0-9]+)\*([0-9,\/]+) ([0-9,]+) Et\-?([0-9,]+) D([0-9,]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2] . 'x' . $mathces[3];
												$save_data['dia'] = $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('9');
											}
											//R-13  4x98  j5.5 et35   &58,5
											elseif (preg_match('/R-([0-9,]+)\s+([0-9,]+)x([0-9\/,]+) \s+j([0-9.]+)\s+et([0-9,-]+)\s+\&([0-9,]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2] . 'x' . $mathces[3];
												$save_data['dia'] = $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('10');
											}
											// R22 5x130 50 9.5J h 71.6 RX SUV GM/P
											elseif (preg_match('/R([0-9,]+)\s+([0-9,\.]+)x([0-9\/,\.]+)\s+([0-9\.]+)\s([0-9\.]+)J\sh\s([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2] . 'x' . $mathces[3];
												$save_data['dia'] = $mathces[5];
												$save_data['et'] = $mathces[4];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
												//debug('11');
											}
											//STW-042 HB 4x100 ET35 67,1 4.5Jx13H2
											elseif (preg_match('/([0-9]+)x([0-9,\+]+).+?ET\s*([0-9]+)\s+([0-9,]+)\s([0-9\.]+)Jx([0-9,]+)H[0-9]/', $title, $mathces)) {
												$save_data['dia'] = $mathces[5];
												$save_data['radius'] = $mathces[6];
												$save_data['pcd'] = $mathces[1] . 'x' . $mathces[2];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[4];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// 17,5х6,00 10х225 ET 121,5 DIA176 (Hayes Lemmerz)
											elseif (preg_match('/([0-9,]+)х([0-9,]+)\s([0-9]+)х([0-9,]+)\sET\s([0-9\,]+)\sDIA\s*([0-9,]+)/i', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['dia'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// AEZ 6,5x15 4/100/38/60,1 Raver ARL2 (Nano)
											elseif (preg_match('/([0-9,]+)x([0-9,]+)\s([0-9]+)\/([0-9,]+)\/([0-9,]+)\/([0-9,]+)/i', $title, $mathces)) {
												$save_data['radius'] = $mathces[2];
												$save_data['dia'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// 13" 4*100 5.5Jx13H2 ET35 67.1 GIANT" GT2027 S4
											elseif (preg_match('/([0-9,]+)"\s+([0-9,]+)\*([0-9\.,\/;]+)\s+([0-9\.,]+)J*x([0-9]+)H*2*\s+ET-*\s*([0-9]+)\sD*([0-9\.,]+)/i', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2] . 'x' . $mathces[3];
												$save_data['dia'] = $mathces[4];
												$save_data['et'] = $mathces[6];
												$save_data['hub'] = $mathces[7];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// 16" 5*114,3 7,0" Et40 73,1 WM 265 C4
											elseif (preg_match('/([0-9,]+)"\s+([0-9,]+)\*([0-9\.,\/;]+)\s+([0-9\.,]+)"\s+ET-*\s*([0-9]+)\sD*([0-9\.,]+)/i', $title, $mathces)) {
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[2] . 'x' . $mathces[3];
												$save_data['dia'] = $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// DISLA  Luxury 306 S 4*100 5,5*13 30 67,1
											elseif (preg_match('/([0-9,]+)\*([0-9,\.]+)\s([0-9\/,\.]+)\*([0-9\.]+)\s([0-9\.]+)\s([0-9,\.]+)/', $title, $mathces)) {
												$save_data['radius'] = $mathces[4];
												$save_data['pcd'] = $mathces[1] . 'x' . $mathces[2];
												$save_data['dia'] = $mathces[3];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											//  Каскад 5,5х14 ЕТ 35 4х100 4x114,3 67,1 блэк платинум Арт. A3691
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\sЕТ\s([0-9,\.]+)\s([0-9,\.]+)х([0-9,\.]+)\s([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5] . '/' . $mathces[7];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[8];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											//  Турнео (КС373-06) 5х13 ЕТ 35 3х98 x 58,5 блэк платинум Арт.6045
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\sЕТ\s([0-9,\.]+)\s([0-9,\.]+)х([0-9,\.]+)\s*x\s*([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// iFree Фриланс (КС520-00) 5,5x13 ЕТ 35 4x98 58,5 Айс Арт,023900
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\sЕТ\s([0-9,\.]+)\s([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// Аркада Нова  5,5*13 ЕТ25 4*98 DIA 58,6 блэк платинум Арт. Х0550
											elseif (preg_match('/([0-9,\.]+)\*([0-9,\.]+)\sЕТ\s*([0-9,\.]+)\s([0-9,\.]+)\*([0-9,\.]+)\sDIA\s([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// Нега 5,5х13 ЕТ45 4х100 DIA 67,1 блэк платинум  Арт. 1470
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\sЕТ\s*([0-9,\.]+)\s([0-9,\.]+)х([0-9,\.]+)\sDIA\s([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[4] . 'x' . $mathces[5];
												$save_data['et'] = $mathces[3];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// 6х14 4х100 ЕТ45 67,1
											// 5.5x13 4х98 ЕТ35 58.6
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\s+([0-9,\.]+)х([0-9,\.]+)\s+ET([0-9,\.]+)\s+([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// different et and x (
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)х([0-9,\.]+)\s+ЕТ([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// different et and x (
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\s+([0-9,\.]+)х([0-9,\.]+)\s+ЕТ([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// different et and x (
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// different et and x (
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)х([0-9,\.]+)\s+ET([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// different et and x (
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)x([0-9,\.]+)\s+ЕТ([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// NZ SH662 7x17 5x105 ET 42 D56.6 SF 9129223
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)x([0-9,\.]+)\s+ET\s?([0-9,\.]+)\s+D([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											// 6.5x15 5x108 ET38 DIA73.1 JT 2027 MS (шт.)
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)x([0-9,\.]+)\sET([0-9,\.]+)\sDIA([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											//6.0x14 4*100 ET35 DIA67.1 SM-890 HS (шт.)
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)\*([0-9,\.]+)\s+ET([0-9,\.]+)\s+DIA([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[1];
												$save_data['radius'] = $mathces[2];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											//  Диск колесный 14х5,5 4x100 Et 39 DIA 56,56 GEELY MK (пр-во КрКЗ)
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\s([0-9,\.]+)x([0-9,\.]+)\sEt\s([0-9,\.]+)\sDIA\s([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\/([0-9,\.]+)x([0-9,\.]+)\sET([0-9,\.]+)\sD([0-9,\.]+)/i', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)x([0-9,\.]+)\sET([0-9,\.]+)\sD([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)x([0-9,\.]+)\sпш\sET([0-9,\.]+)\sD([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+);\s+([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+);\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\/([0-9,\.]+)x([0-9,\.]+)\sD([0-9,\.]+)\sET([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[6];
												$save_data['hub'] = $mathces[5];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+);\s([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\s([0-9,\.]+)\/([0-9,\.]+)\s+ET([0-9,\.]+)\sD([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\sPCD([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+)\sDIA([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)\/([0-9,\.]+)\s+ET([0-9,\.]+)\sd-([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s([0-9,\.]+)\/([0-9,\.]+)\s+ET([0-9,\.]+)\sd([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+);\s+([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+)\s+([0-9,\.]+)x([0-9,\.]+)\s+ЕТ([0-9,\.]+)\s+d([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+);\s+([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+)\s+d([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)x([0-9,\.]+);\s+([0-9,\.]+)x([0-9,\.]+)\s+ET\s([0-9,\.]+)\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)х([0-9,\.]+)\s+PCD([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+)\s+DIA\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
											elseif (preg_match('/([0-9,\.]+)\sx\s([0-9,\.]+);\s+([0-9,\.]+)x([0-9,\.]+)\s+ET([0-9,\.]+);?\s+([0-9,\.]+)/ui', $title, $mathces)) {
												$save_data['dia'] = $mathces[2];
												$save_data['radius'] = $mathces[1];
												$save_data['pcd'] = $mathces[3] . 'x' . $mathces[4];
												$save_data['et'] = $mathces[5];
												$save_data['hub'] = $mathces[6];
												$title = trim(str_ireplace($mathces[0], ' ', $title));
											}
										}
										if (isset($save_data['pcd'])) {
											$save_data['pcd'] = str_replace(array('-', '*', ',', '/'), array('/', 'x', '.', 'x'), $save_data['pcd']);
										}
										if (isset($save_data['pcd'])) {
											if (substr_count($save_data['pcd'], 'x') > 1) {
												$parts = explode('x', $save_data['pcd']);
												$save_data['pcd'] = $parts[0] . 'x' . implode('/', array_slice($parts, 1));
											}
											$parts = explode('x', $save_data['pcd']);
											if (count($parts) > 1) {
												if ($parts[0] == 8) {
													$save_data['pcd'] = '4x' . implode('/', array_slice($parts, 1));
												}
												elseif ($parts[0] == 10) {
													$save_data['pcd'] = '5x' . implode('/', array_slice($parts, 1));
												}
											}
										}
										if (isset($save_data['hub'])) {
											$save_data['hub'] = number_format(floatval(str_replace(',', '.', $save_data['hub'])), 1, '.', '');
										}
										if (isset($save_data['et'])) {
											$save_data['et'] = str_replace(array('et', 'ET'), '', $save_data['et']);
											$save_data['et'] = number_format(floatval(str_replace(',', '.', $save_data['et'])), 1, '.', '');
										}
										if (isset($save_data['stock_count'])) {
											$save_data['stock_count'] = intval(trim(preg_replace('/[^0-9\.,]/', '', $save_data['stock_count'])));
										}
										if (isset($save_data['price'])) {
											$save_data['price'] = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $save_data['price']))));
										}
										if (isset($save_data['dia'])) {
											$save_data['dia'] = floatval(str_ireplace(',', '.', trim(preg_replace('/[^0-9\.,]/', '', $save_data['dia']))));
										}
										if (isset($save_data['brand']) && isset($title)) {
											$title = trim(preg_replace('/\b\(' . $save_data['brand'] . '\)\b/ui', '', $title, 1));
											$title = trim(preg_replace('/\b' . $save_data['brand'] . '\b/ui', ' ', $title, 1));
										}
										if ($kik && !isset($save_data['brand'])) {
											$save_data['brand'] = 'кик';
										}
										if ($i == 566) {
											
											//debug($save_data);exit();
										}
										//debug($save_data);
										//debug($title);
										//exit();
										if (isset($save_data['brand'])) {
											$save_data['brand'] = str_ireplace(array(' $', ' ГРН'), '', $save_data['brand']);
											$save_data['brand'] = $this->_clean_text($save_data['brand']);
											if (isset($brands[$save_data['brand']])) {
												$save_data['brand_id'] = $brands[$save_data['brand']];
												// find model
												if (!isset($save_data['model']) && isset($title)) {
													$save_data['model'] = $title;
												}
												if (isset($save_data['model'])) {
													$save_data['model'] = trim($this->_clean_text($save_data['model'], false));
													if (isset($save_data['color']) && !empty($save_data['color'])) {
														$model = $save_data['model'];
														$color = trim($this->_clean_text($save_data['color'], false));
														if (!empty($model) && !empty($color) && substr_count($model, $color) == 0) {
															$model .= ' ' . strtolower($save_data['color']);
														}
														else {
															$parts = explode(' ' . $color, $model);
															if (isset($parts[1]) && $parts[1] != '') {
																$model = $parts[0] . $color;
															}
														}
														if (isset($models[$save_data['brand_id']][$model])) {
															$save_data['model_id'] = $models[$save_data['brand_id']][$model];
															$save_data['model'] = $model;
														}
														else {
															$model_id = md5($model);
															$models_by_id[$model_id] = $model;
															$models[$save_data['brand_id']][$model] = $model_id;
															$save_data['model_id'] = $model_id;
														}
													}
													else {
														if (isset($models[$save_data['brand_id']][$save_data['model']])) {
															$save_data['model_id'] = $models[$save_data['brand_id']][$save_data['model']];
														}
														else {
															$model_id = md5($save_data['model']);
															$models_by_id[$model_id] = $save_data['model'];
															$models[$save_data['brand_id']][$save_data['model']] = $model_id;
															$save_data['model_id'] = $model_id;
														}
													}
												}
											}
										}
										if (isset($save_data['brand_id']) && isset($save_data['model_id']) && isset($save_data['radius']) && isset($save_data['pcd']) && isset($save_data['dia']) && isset($save_data['et']) && isset($save_data['hub'])) {
											$products[] = $save_data;
											$total_converted_rows ++;
										}
										else {
											$not_founded_fields = array();
											foreach ($required_fields as $field) {
												if (!isset($save_data[$field])) {
													if ($field == 'model_id') {
														if (isset($save_data['model']) && !empty($save_data['model'])) {
															$not_founded_fields[] = __d('admin_import', 'reqired_field_model', $save_data['model']);
														}
														else {
															$not_founded_fields[] = __d('admin_import', 'reqired_field_' . $field);
														}
													}
													else {
														$not_founded_fields[] = __d('admin_import', 'reqired_field_' . $field);
													}
												}
											}
											$errors[] = __d('admin_import', 'convert_error', $sheet_number + 1, $i, implode(', ', $not_founded_fields));
											$total_error_rows ++;
										}
										if ($sheet_number == 1) {
											//debug($save_data);
											//exit();
										}
										/*
										if ($i  == 15 && $sheet_number == 9) {
											debug($row);
											debug($save_data);
											debug($title);
											exit();
										}
										*/

									}
								}
							}
						}
						if (!empty($products)) {
							app::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel' . DS . 'PHPExcel.php'));
							$objPHPExcel = new PHPExcel();
							$i = 1;
							foreach ($products as $item) {
								//$item['pcd'] = str_replace('/', 'x', $item['pcd']);
								$pcd = explode('x', strtolower($item['pcd']));
								$model = $models_by_id[$item['model_id']];
								if (isset($item['color']) && !empty($item['color'])) {
									$color = trim($this->_clean_text($item['color'], false));
									if (substr_count($model, $color) == 0 && !$this->_has_color($model, $product_materials)) {
										$model .= ' ' . strtolower($item['color']);
									}
									else {
										$model = str_replace($color, $item['color'], $model);
									}
								}
								$sku = $brands_by_id[$item['brand_id']] . ' ' . $model . ' ' . $item['pcd'] . ' ' . $item['dia'] . ' ET ' . $item['et'] . ' Dia ' . $item['hub'];

								$objPHPExcel->setActiveSheetIndex(0)
											->setCellValueExplicit('A' . $i, $brands_by_id[$item['brand_id']])
											->setCellValueExplicit('B' . $i, $model)
											->setCellValueExplicit('C' . $i, $sku)
											->setCellValueExplicit('D' . $i, $item['dia'])
											->setCellValueExplicit('E' . $i, $item['radius'])
											->setCellValueExplicit('F' . $i, $pcd[1])
											->setCellValueExplicit('L' . $i, $pcd[0])
											->setCellValueExplicit('H' . $i, $item['et'])
											->setCellValueExplicit('I' . $i, $item['hub']);
								if (isset($item['price'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P' . $i, $item['price']);
								}
								if (isset($item['stock_count'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N' . $i, $item['stock_count']);
								}
								if (isset($item['color'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J' . $i, $item['color']);
								}
								if (isset($item['material'])) {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K' . $i, $item['material']);
								}
								$i ++;
							}
							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
							$filename = md5(uniqid(rand(), true)) . '.xls';
							$objWriter->save(WWW_ROOT . 'xls' . DS . $filename);
							$this->set('filename', $filename);
							$this->info($this->t('message_item_converted'));
						}
						else {
							$this->error($this->t('error_no_products_found'));
						}
						$stat = array(
							'total_rows_count' => $total_rows_count,
							'total_converted_rows' => $total_converted_rows,
							'total_sheets_count' => $total_sheets_count,
							'total_skipped_rows' => $total_skipped_rows,
							'total_error_rows' => $total_error_rows
						);
						$this->set('errors', $errors);
						$this->set('stat', $stat);
						//$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_convert'));
					}
					else {
						$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
					}
				}
				else {
					$this->Import->invalidate('file', __d('admin_import', 'error_bad_file'));
				}
			}
			else {
				$this->error($this->t('error_item_not_converted'));
			}
		}
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_convert_disks'));
		$this->render('admin_convert');
	}
	private function _has_color($title, $colors) {
		foreach ($colors as $key) {
			if (preg_match('/(\s|^)' . preg_quote($key, '/') . '(\s|$)/iu', $title, $mathces)) {
				return true;
			}
		}
		return false;
	}
	private function _clean_text($text, $only_alpha = true) {
		$regex = '/[^0-9a-zА-я ]/u';
		if ($only_alpha) {
			$regex = '/[^a-zА-я ]/u';
		}
		$ret = str_replace('*', ' ', mb_strtolower(trim($text)));
		$ret = preg_replace($regex, '', $ret);
		$ret = preg_replace('/\s+/', ' ', $ret);
		return $ret;
	}
}
function cmp($a, $b) {
	$a_len = mb_strlen($a);
	$b_len = mb_strlen($b);
	if ($a_len == $b_len) {
		return 0;
	}
	return ($a_len > $b_len) ? -1 : 1;
}
