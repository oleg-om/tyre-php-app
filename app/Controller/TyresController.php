<?php
class TyresController extends AppController {
    public $uses = array();
    public $layout = 'inner';
    public $paginate = array();

    public $prod=array('в наличии'=>1,'под заказ'=>0);

    public $season=array('SHOW_TYRES_VSE_SAMER'=>'summer','SHOW_TYRES_VSE_WINTER'=>'winter','SHOW_TYRES_VSE_VSE'=>'all');

    public $filter_fields = array('Product.id' => 'int', 'Product.brand_id' => 'int', 'Product.model_id' => 'int', 'Product.sku' => 'text', 'Product.supplier_id' => 'int');
    public $model = 'Product';
    public $submenu = 'products';
    public $conditions = array('Product.category_id' => 1);
    public function _list() {
        parent::_list();
        $this->loadModel('Supplier');
        $this->set('suppliers', $this->Supplier->find('list', array('fields' => array('Supplier.id', 'Supplier.title'), 'order' => array('Supplier.title' => 'asc'))));
        $this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 1))));
        if (isset($this->request->data['Product']['brand_id'])) {
            $this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
        }
        else {
            $this->set('models', array('' => __d('admin_common', 'list_all_items')));
        }
        $this->set('all_models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'order' => array('BrandModel.title' => 'asc'), 'conditions' => array('BrandModel.category_id' => 1))));
    }
    public function _edit($id) {
        $title = parent::_edit($id);
        $this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 1))));
        if (isset($this->request->data['Product']['brand_id'])) {
            $this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
        }
        else {
            $this->set('models', array('' => __d('admin_common', 'list_any_items')));
        }
        $this->set('seasons', $this->{$this->model}->seasons);
        $this->set('auto', $this->{$this->model}->auto);
        $this->set('stud', $this->{$this->model}->stud);
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
        $this->{$this->model}->query('UPDATE brands SET products_count=0,active_products_count=0 WHERE category_id=1');
        $this->{$this->model}->query('UPDATE brand_models SET products_count=0,active_products_count=0 WHERE category_id=1');
        $this->info($this->t('message_data_cleared'));
        $url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
        $this->redirect($url);
    }



    function auto() {

        $this->loadModel('Product');
        $temp_cond=array('Product.category_id'=>1,'Product.is_active'=>1,'Product.price > '=>0,'Product.stock_count > '=>0);
        /*
        Array (
        [Product.category_id] => 1
        [Product.is_active] => 1
        [Product.price > ] => 0
        [Product.stock_count > ] => 0
        */
        //[AND] => Array ( [Product.auto !=] => Array ( [0] => trucks [1] => agricultural [2] => special ) ) )

        if(empty($this->request->query['auto'])):
            //$temp_cond['AND'] = array('Product.auto !=' => array('trucks','agricultural','special'));
            $temp_cond['AND'] = array('Product.auto !=' => array('trucks','special'));
        else:
            $temp_cond['Product.auto'] = $this->request->query['auto'];
        endif;


        $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));

        $tyre_size1 = array();
        foreach ($products as $item) {
            $size = number_format(str_replace(',', '.', $item['Product']['size1']), 2, '.', '');
            $size = str_replace('.00', '', $size);
            $tyre_size1[$size] = $size;
        }
        natsort($tyre_size1);
        unset($tyre_size1[0]);

        echo json_encode($tyre_size1);
        exit();
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






    public function index(){

        $mode = 'block';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $this->request->data['Product']['mode'] = $mode;
        $this->set('mode', $mode);
        $auto = 'cars';
        $this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->loadModel('Product');
        $limit = 30;
        if (isset($this->request->query['limit']) && in_array($this->request->query['limit'], array('10', '20', '30', '50'))) {
            $limit = $this->request->query['limit'];
        }
        $this->paginate['limit'] = $limit;
        $this->set('limit', $limit);

        $conditions = array('Product.is_active' => 1, 'Product.category_id' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);

        $this->request->data['Product'] = $this->request->query;

        if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
            if (!is_array($this->request->query['brand_id'])) {
                $brand_id = intval($this->request->query['brand_id']);
                if ($brand_id != 0) {
                    $this->loadModel('Brand');
                    if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
                        $this->redirect(array('controller' => 'tyres', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $this->request->query));
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

        //print_r($conditions);



        $product_conditions = $conditions = $this->get_conditions($conditions);

        $show_size = false;
        if (isset($conditions['Product.size1']) && isset($conditions['Product.size2']) && isset($conditions['Product.size3'])) {
            $show_size = true;
        }
        $this->set('has_params', true);
        $this->set('show_size', $show_size);
        $this->set('filter', array_filter($this->request->query));
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





        $models = $this->Product->find('all', array(
            'fields' => array('Product.model_id', 'Product.id', 'Product.price'),
            'conditions' => $conditions,
            'order' => 'Product.price ASC'
        ));
        //print_r($models);





        $model_ids = array();
        foreach ($models as $model) {
            if (!in_array($model['Product']['model_id'], $model_ids)) {
                $model_ids[$model['Product']['id']] = $model['Product']['model_id'];
            }
        }

        $product_ids =  implode(", ", array_keys($model_ids));
        if (empty($product_ids)) {$product_ids = 0;}
        $this->BrandModel->bindModel(
            array(
                'belongsTo' => array(
                    'Brand'
                )
            ),
            false
        );
        unset($conditions['Product.price >=']);
        unset($conditions['Product.price <=']);
        $prices = $this->Product->find('first', array(
            'fields' => array('MAX(Product.price) AS max', 'MIN(Product.price) AS min'),
            'conditions' => $conditions
        ));


        $this->_filter_params($conditions);
        $this->_filter_by_auto_test($conditions);
        $this->set('price_from', floor($prices[0]['min']));
        $this->set('price_to', ceil($prices[0]['max']));

        if ($mode == 'table') {
            $this->paginate['conditions'] = $product_conditions;
        }
        else {

            $model_conditions = array('BrandModel.category_id' => 1,'BrandModel.is_active' => 1, 'BrandModel.id' => $model_ids);

            if($this->sett_var('SHOW_TYRES_IMG_TOVAR')==1):
                $model_conditions['BrandModel.filename !='] = '';
            endif;
            $this->paginate['conditions'] = $model_conditions;
        }
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
            $this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where `products`.`model_id`=`BrandModel`.`id` AND `products`.`id` IN ('.$product_ids.'))';
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



            foreach ($models as $i => $model) {
                $models[$i]['Product'] = array();
                $cond = $conditions;
                $cond['Product.model_id'] = $model['BrandModel']['id'];
                if ($products = $this->Product->find('all', array('conditions' => $cond, 'order' => 'Product.price ASC'))) {
                    foreach ($products as $product) {
                        $models[$i]['Product'][] = $product['Product'];
                    }
                }
            }
            //print_r($models);
            //exit();
        }

        //print_r($models);
        //exit();
        if (isset($this->request->data['Product']['brand_id']) && !empty($this->request->data['Product']['brand_id'])) {
            $brand_models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
            $this->set('brand_models', $brand_models);
        }

        //print_r($this->request->query['season']);

        //echo"---".count($models);
        /*
            if($this->sett_var('SHOW_TYRES_IMG_TOVAR')==1):
                    $cond['Product.filename !='] = '';
        endif;
        foreach ($models as $i => $model)
        print_r($models);
        */


        $this->set('models', $models);

        $meta_title = '';
        $meta_keywords = '';
        $meta_description = '';
        $title = 'Шины';

        if ($auto == 'trucks') {
            $title = 'Грузовые шины';
            $meta_title = 'Купить грузовые шины Керчь, Феодосия, шинный центр Авто Дом';
            $meta_keywords = 'Купить, грузовые шины, Керчь, Феодосия, шинный центр Авто Дом';
            $meta_description = 'Шинный центр Авто Дом предлагает купить недорого грузовые шины для любых марок автомобиле в Керчи и Феодосии по самым лучшим ценам';
        }
        elseif ($auto == 'agricultural') {
            $title = 'Сельхоз шины';
        } elseif ($auto == 'cars') {
            $title = 'Легковые шины';
        }
        $breadcrumbs = array();
        $breadcrumbs[] = array(
            'url' => null,
            'title' => $title
        );
        $this->set('breadcrumbs', $breadcrumbs);
        $this->setMeta('title', $meta_title);
        $this->setMeta('keywords', $meta_keywords);
        $this->setMeta('description', $meta_description);
        $this->set('active_menu', 'tyres');
        $this->set('show_left_filter', true);
        $this->set('current_auto', $auto);
        $this->set('sort', $sort);
        $this->set('additional_js', array('lightbox', 'slider', 'functions'));
        $this->set('additional_css', array('lightbox', 'jquery-ui-1.9.2.custom.min'));
    }



    public function brand($slug) {


        $mode = 'list';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $this->set('mode', $mode);
        $auto = 'cars';
        $this->loadModel('Brand');
        if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.is_active' => 1, 'Brand.category_id' => 1, 'Brand.slug' => $slug)))) {
            if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
                $brand_id = intval($this->request->query['brand_id']);
                if ($brand['Brand']['id'] != $brand_id) {
                    if ($brand_id == 0) {
                        $filter = $this->request->query;
                        unset($filter['brand_id']);
                        unset($filter['model_id']);
                        $this->redirect(array('controller' => 'tyres', 'action' => 'index', '?' => $filter));
                        return;
                    }
                    elseif ($new_brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
                        $this->redirect(array('controller' => 'tyres', 'action' => 'brand', 'slug' => $new_brand['Brand']['slug'], '?' => $this->request->query));
                        return;
                    }

                }
            }
            $this->loadModel('BrandModel');
            $this->loadModel('Product');
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
            $conditions = array('Product.is_active' => 1, 'Product.brand_id' => $brand['Brand']['id'], 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
            $has_params = false;
            $limit = 30;
            if (isset($this->request->query['limit']) && in_array($this->request->query['limit'], array('10', '20', '30', '50'))) {
                $limit = $this->request->query['limit'];
            }
            $this->paginate['limit'] = $limit;
            $this->set('limit', $limit);
            $model_id = null;
            if (isset($this->request->query['model_id'])) {
                $model_id = intval($this->request->query['model_id']);
            }
            if (!empty($model_id)) {
                $conditions['Product.model_id'] = $model_id;
                $this->set('model_id', $model_id);
            }


            if (isset($this->request->query['season']) && !empty($this->request->query['season'])){
                //print_r($this->request->query['season']);
                //$this->get_conditions_season($conditions);
                //$conditions;
                //print_r($this->get_conditions_season($conditions));


                $this->loadModel('Settings');
                $sett = $this->Settings->find('all', array(
                    'fields' => array('Settings.variable','Settings.value'),
                    'conditions' => array(
                        'or' =>  array(
                            array('Settings.variable' => 'SHOW_TYRES_VSE_SAMER'),
                            array('Settings.variable' => 'SHOW_TYRES_VSE_WINTER')
                        )
                    )
                ));



                foreach($sett as $s):
                    if($this->season[$s['Settings']['variable']]==$this->request->query['season']&&$s['Settings']['value']==1):
                        if($this->request->query['season']=='all'):
                            $conditions[] = array(
                                'or' => array(
                                    array(
                                        'BrandModel.season IS NOT NULL',
                                        'BrandModel.season' => 'all'
                                    ),
                                    array(
                                        'BrandModel.season IS NULL',
                                        'Product.season' => 'all',
                                    )
                                )

                            );
                        else:
                            $conditions[] = array(
                                'or' => array(
                                    array(
                                        'BrandModel.season IS NOT NULL',
                                        'or'=>array(
                                            array('BrandModel.season' => $this->request->query['season']),
                                            array('BrandModel.season' => 'all')
                                        )),
                                    array(
                                        'BrandModel.season IS NULL',
                                        'or'=>array(
                                            array('Product.season' => $this->request->query['season']),
                                            array('Product.season' => 'all'),
                                        ))
                                )
                            );
                        endif;
                    elseif($this->season[$s['Settings']['variable']]==$this->request->query['season']):
                        $conditions[] = array(
                            'or' => array(
                                array(
                                    array('BrandModel.season IS NOT NULL'),
                                    array('BrandModel.season' => $this->request->query['season']),
                                ),
                                array(
                                    array('BrandModel.season IS NULL'),
                                    array('Product.season' => $this->request->query['season']),
                                )
                            )
                        );

                    endif;
                endforeach;




                /*
                print_r($sett);

                $conditions[] = array(
                    'or' => array(
                        array(
                            'BrandModel.season IS NOT NULL',
                            'BrandModel.season' => $this->request->query['season']
                        ),
                        array(
                            'BrandModel.season IS NULL',
                            'Product.season' => $this->request->query['season']
                        ),
                        array(
                            'BrandModel.season IS NOT NULL',
                            'BrandModel.season' => 'all'
                        ),
                        array(
                            'BrandModel.season IS NULL',
                            'Product.season' => 'all'
                        )
                    )
                );

                */






                $has_params = true;
            }

            if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
                $conditions[] = array(
                    'or' => array(
                        array(
                            'BrandModel.auto IS NOT NULL',
                            'BrandModel.auto' => $this->request->query['auto']
                        ),
                        array(
                            'BrandModel.auto IS NULL',
                            'Product.auto' => $this->request->query['auto']
                        )
                    )
                );
                $auto = $this->request->query['auto'];
                $has_params = true;
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
                //$this->request->query['in_stock'] = 1;
                //$conditions['Product.in_stock'] = 1;
                //$has_params = true;

                /*** select *****/
                $this->loadModel('Settings');
                $s = $this->Settings->find('all', array('conditions' => array('type' => 'radio','variable'=>'PRODUCTINSTOCK','value'=>1)));

                //echo"8888888";
                //print_r($s);

                if(isset($this->prod[$s[0]['Settings']['description']])):
                    $this->request->query['in_stock'] = $this->prod[$s[0]['Settings']['description']];
                    $conditions['Product.in_stock'] = $this->request->query['in_stock'];
                else:
                    $this->request->query['in_stock'] = 2;
                endif;
                /*** select *****/

            }



            if (isset($this->request->query['in_stock4']) && $this->request->query['in_stock4']) {
                $conditions['Product.stock_count >= '] = 4;
                $has_params = true;
            }
            if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
                $conditions['Product.size1'] = $this->_get_sizes($this->request->query['size1']);
                $has_params = true;
            }
            if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
                $conditions['Product.size2'] = $this->_get_sizes($this->request->query['size2']);
                $has_params = true;
            }
            if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
                $conditions['Product.size3'] = $this->_get_sizes($this->request->query['size3']);
                $has_params = true;
            }
            if (isset($this->request->query['stud']) && $this->request->query['stud']) {
                $conditions['Product.stud'] = 1;
                $has_params = true;
            }

            if (isset($this->request->query['axis']) && !empty($this->request->query['axis']) && $auto == 'trucks') {
                $conditions['Product.axis'] = $this->request->query['axis'];
                $has_params = true;

            }
            if (isset($this->request->query['price_from']) && !empty($this->request->query['price_from'])) {
                $conditions['Product.price >'] = intval($this->request->query['price_from']);
                $has_params = true;
            }
            if (isset($this->request->query['price_to']) && !empty($this->request->query['price_to'])) {
                $conditions['Product.price <='] = intval($this->request->query['price_to']);
                $has_params = true;
            }
            $this->set('has_params', $has_params);
            if (!$has_params) {
                $this->paginate['limit'] = 1200;
            }
            $product_conditions = $conditions;
            $show_size = false;
            if (isset($conditions['Product.size1']) && isset($conditions['Product.size2']) && isset($conditions['Product.size3'])) {
                $show_size = true;
            }
            $this->set('show_size', $show_size);

            $models = $this->Product->find('all', array(
                'fields' => array('Product.model_id', 'Product.id'),
                'conditions' => $conditions
            ));
            $model_ids = array();
            foreach ($models as $model) {
                if (!in_array($model['Product']['model_id'], $model_ids)) {
                    $model_ids[$model['Product']['id']] = $model['Product']['model_id'];
                }
            }
            $product_ids =  implode(", ", array_keys($model_ids));
            if (empty($product_ids)) {$product_ids = 0;}
            unset($conditions['Product.price >=']);
            unset($conditions['Product.price <=']);

            $prices = $this->Product->find('first', array(
                'fields' => array('MAX(Product.price) AS max', 'MIN(Product.price) AS min'),
                'conditions' => $conditions
            ));
            $this->set('price_from', floor($prices[0]['min']));
            $this->set('price_to', ceil($prices[0]['max']));
            $this->_filter_params($conditions);
            $this->_filter_by_auto_test($conditions);
            $this->BrandModel->bindModel(
                array(
                    'belongsTo' => array(
                        'Brand'
                    )
                ),
                false
            );

            $this->request->data['Product'] = $this->request->query;
            $this->request->data['Product']['mode'] = $mode;
            $this->request->data['Product']['brand_id'] = $brand['Brand']['id'];
            //$meta_title = 'Шины, купить зимнею летнею резину Керчь, Феодосия магазин шин Авто Дом';
            //$meta_keywords = 'шины, летняя резина, зимняя резина, Керчь, купить, магазин, Авто Дом, Феодосия';
            //$meta_description = 'Магазин Авто дом предлагает купить шины, зимнею летнею резину в Керчи, Феодосии у нас всегда самый большой выбор и замечательные цены.';
            $title = 'Легковые шины';
            $filter = array();
            if ($auto == 'trucks') {
                $title = 'Грузовые шины';
                $filter = array('auto' => $auto);
                $meta_title = 'Купить грузовые шины Керчь, Феодосия, шинный центр Авто Дом';
                $meta_keywords = 'Купить, грузовые шины, Керчь, Феодосия, шинный центр Авто Дом';
                $meta_description = 'Шинный центр Авто Дом предлагает купить недорого грузовые шины для любых марок автомобиле в Керчи и Феодосии по самым лучшим ценам';
            }
            elseif ($auto == 'agricultural') {
                $title = 'Сельхоз шины';
                $filter = array('auto' => $auto);
            }
            $breadcrumbs = array();
            $breadcrumbs[] = array(
                'url' => array('controller' => 'tyres', 'action' => 'index'),
                'title' => $title
            );
            $meta_title = !empty($brand['Brand']['meta_title']) ? $brand['Brand']['meta_title'] : $brand['Brand']['title'];
            $meta_keywords = $brand['Brand']['meta_keywords'];
            $meta_description = $brand['Brand']['meta_description'];
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
            $render = 'index';
            if (!empty($model_id)) {
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
                if ($model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $model_id)))) {
                    $breadcrumbs[] = array(
                        'url' => array('controller' => 'tyres', 'action' => 'brand', 'slug' => $slug, '?' => $filter),
                        'title' => $brand['Brand']['title']
                    );
                    $breadcrumbs[] = array(
                        'url' => null,
                        'title' => $model['BrandModel']['title']
                    );
                    $this->setLastModels($model);
                    $meta_title = (!empty($model['BrandModel']['meta_title']) ? $model['BrandModel']['meta_title'] : 'Шина ' . $model['Brand']['title'] . ' ' . $model['BrandModel']['title']);
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
                $model_conditions = array('BrandModel.category_id' => 1,'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.id' => $model_ids);
                if (!$has_params) {
                    unset($model_conditions['BrandModel.id']);
                    if ($this->sett_var('SHOW_TYRES_IMG')==1)
                        $model_conditions['BrandModel.filename != '] = '';
                }

                $this->paginate['conditions'] = $model_conditions;
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
                    $this->paginate['conditions'] = $product_conditions;
                    $models = $this->paginate('Product');
                }
                else {
                    //debug($this->paginate['conditions']);
                    $this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where `products`.`model_id`=`BrandModel`.`id` AND `products`.`id` IN ('.$product_ids.'))';
                    $models = $this->paginate('BrandModel');
                    foreach ($models as $i => $model) {
                        $models[$i]['Product'] = array();
                        $cond = $conditions;
                        $cond['Product.model_id'] = $model['BrandModel']['id'];
                        if ($products = $this->Product->find('all', array('conditions' => $cond, 'order' => 'Product.price ASC'))) {
                            foreach ($products as $product) {
                                $models[$i]['Product'][] = $product['Product'];
                            }
                        }
                    }
                }
                $brand_models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
                $this->set('brand_models', $brand_models);
                $this->set('models', $models);
                $this->set('show_left_filter', true);
            }
            $this->set('breadcrumbs', $breadcrumbs);

            $this->set('filter', array_filter($this->request->query));
            $this->set('brand_id', $brand['Brand']['id']);
            $this->setMeta('title', $meta_title);
            $this->setMeta('keywords', $meta_keywords);
            $this->setMeta('description', $meta_description);
            $this->set('sort', $sort);
            $this->set('brand', $brand);
            $this->set('active_menu', 'tyres');

            $this->set('current_auto', $auto);
            $this->set('additional_js', array('lightbox', 'functions', 'slider'));
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

        $this->loadModel('Brand');
        if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.is_active' => 1, 'Brand.category_id' => 1, 'Brand.slug' => $slug)))) {
            $this->loadModel('Product');
            $this->Product->bindModel(
                array(
                    'belongsTo' => array(
                        'BrandModel' => array(
                            'foreignKey' => 'model_id',
                        )
                    )
                ),
                false
            );
            if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.brand_id' => $brand['Brand']['id'], 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {

                $conditions = array('Product.is_active' => 1, 'Product.brand_id' => $product['Product']['brand_id'], 'Product.price > ' => 0, 'Product.stock_count > ' => 0);

                if (isset($this->request->query['season']) && !empty($this->request->query['season'])){
                    if (isset($this->request->query['upr_all']) && !empty($this->request->query['upr_all'])){
                        if (isset($this->request->query['upr_all']) && !empty($this->request->query['upr_all'])){
                            if ((( $this->request->query['upr_all'] == 1) AND ( $this->request->query['upr_all'] == 'summer'))
                                OR (( $this->request->query['upr_all'] == 2) AND ( $this->request->query['upr_all'] == 'winter'))){
                                $conditions[] = array(
                                    'or' => array(
                                        array('BrandModel.season IS NOT NULL','BrandModel.season' => $this->request->query['season']),
                                        array('BrandModel.season IS NULL','Product.season' => $this->request->query['season']),
                                        array('BrandModel.season IS NOT NULL','BrandModel.season' => 'all'),
                                        array('BrandModel.season IS NULL','Product.season' => 'all')
                                    )
                                );
                            }else{
                                $conditions[] = array(
                                    'or' => array(
                                        array('BrandModel.season IS NOT NULL','BrandModel.season' => $this->request->query['season']),
                                        array('BrandModel.season IS NULL','Product.season' => $this->request->query['season'])
                                    )
                                );
                            }
                        }else{
                            $conditions[] = array(
                                'or' => array(
                                    array('BrandModel.season IS NOT NULL','BrandModel.season' => $this->request->query['season']),
                                    array('BrandModel.season IS NULL','Product.season' => $this->request->query['season'])
                                )
                            );
                        }
                    }else{
                        $conditions[] = array(
                            'or' => array(
                                array('BrandModel.season IS NOT NULL','BrandModel.season' => $this->request->query['season']),
                                array('BrandModel.season IS NULL','Product.season' => $this->request->query['season'])
                            )
                        );
                    }
                }

                /*
                OR (
            (
                (`BrandModel`.`season` IS NOT NULL)
                AND (`BrandModel`.`season` = 'all')
            )
        )
        OR (
            (
                (`BrandModel`.`season` IS NULL)
                AND (`Product`.`season` = 'all')
            )
        )
                */

                if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
                    $conditions[] = array(
                        'or' => array(
                            array(
                                'BrandModel.auto IS NOT NULL',
                                'BrandModel.auto' => $this->request->query['auto']
                            ),
                            array(
                                'BrandModel.auto IS NULL',
                                'Product.auto' => $this->request->query['auto']
                            )
                        )
                    );
                    $auto = $this->request->query['auto'];
                }
                if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
                    $conditions['Product.size1'] = $this->_get_sizes($this->request->query['size1']);
                }
                if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
                    $conditions['Product.size2'] = $this->_get_sizes($this->request->query['size2']);
                }
                if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
                    $conditions['Product.size3'] = $this->_get_sizes($this->request->query['size3']);
                }
                if (isset($this->request->query['axis']) && !empty($this->request->query['axis']) && $auto == 'trucks') {
                    $conditions['Product.axis'] = $this->request->query['axis'];
                }
                $this->_filter_params($conditions);
                $this->_filter_by_auto_test($conditions);
                $this->request->data['Product'] = $this->request->query;

                $auto = $product['Product']['auto'];
                $this->set('seasons', $this->Product->seasons);
                $this->set('auto', $this->Product->auto);
                $title = 'Легковые шины';
                $filter = array();
                if ($auto == 'trucks') {
                    $title = 'Грузовые шины';
                    $filter = array('auto' => $auto);
                }
                elseif ($auto == 'agricultural') {
                    $title = 'Сельхоз шины';
                    $filter = array('auto' => $auto);
                }
                $this->loadModel('BrandModel');
                $models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
                $breadcrumbs = array();
                $breadcrumbs[] = array(
                    'url' => array('controller' => 'tyres', 'action' => 'index', '?' => $filter),
                    'title' => $title
                );
                $breadcrumbs[] = array(
                    'url' => array('controller' => 'tyres', 'action' => 'brand', 'slug' => $slug),
                    'title' => $brand['Brand']['title']
                );
                $breadcrumbs[] = array(
                    'url' => array('controller' => 'tyres', 'action' => 'brand', 'slug' => $slug, '?' => array('model_id' => $product['Product']['model_id'])),
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
                $this->set('breadcrumbs', $breadcrumbs);
                $this->set('additional_js', array('lightbox'));
                $this->set('additional_css', array('lightbox'));
                $this->set('models', $models);
                $this->set('brand_id', $brand['Brand']['id']);
                $this->set('model_id', $product['Product']['model_id']);
                $this->setMeta('title', $product['Product']['sku']);
                $this->setMeta('keywords', $product['BrandModel']['meta_keywords']);
                $this->setMeta('description', $product['BrandModel']['meta_description']);
                $this->set('brand', $brand);
                $this->set('product', $product);
                $this->set('active_menu', 'tyres');
                $this->set('current_auto', $auto);
                $this->set('show_left_menu', false);
            }
            else {
//                $this->response->statusCode(404);
//                $this->response->send();
//   echo $this->request;
                $this->redirect($slug);
//                $this->render(false);
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





    private function get_conditions_season($conditions){



        /******* настройки летние, зимние и всесезонные шины ********/
        $this->loadModel('Settings');
        $sett = $this->Settings->find('all', array(
            'fields' => array('Settings.variable','Settings.value'),
            'conditions' => array(
                'or' =>  array(
                    array('Settings.variable' => 'SHOW_TYRES_VSE_SAMER'),
                    array('Settings.variable' => 'SHOW_TYRES_VSE_WINTER')
                )
            )
        ));
        //$sett[]['Settings']=array('variable'=>'SHOW_TYRES_VSE_VSE','value'=>0);

        foreach($sett as $s):
            if($this->season[$s['Settings']['variable']]==$this->request->query['season']&&$s['Settings']['value']==1):
                if($this->request->query['season']=='all'):
                    $conditions[] = array(
                        'or' => array(
                            array(
                                'BrandModel.season IS NOT NULL',
                                'BrandModel.season' => 'all'
                            ),
                            array(
                                'BrandModel.season IS NULL',
                                'Product.season' => 'all',
                            )
                        )

                    );
                else:
                    $conditions[] = array(
                        'or' => array(
                            array(
                                'BrandModel.season IS NOT NULL',
                                'or'=>array(
                                    array('BrandModel.season' => $this->request->query['season']),
                                    array('BrandModel.season' => 'all')
                                )),
                            array(
                                'BrandModel.season IS NULL',
                                'or'=>array(
                                    array('Product.season' => $this->request->query['season']),
                                    array('Product.season' => 'all'),
                                ))
                        )
                    );
                endif;
            elseif($this->season[$s['Settings']['variable']]==$this->request->query['season']):

                $conditions[] = array(
                    'or' => array(
                        array(
                            array('BrandModel.season IS NOT NULL'),
                            array('BrandModel.season' => $this->request->query['season']),
                        ),
                        array(
                            array('BrandModel.season IS NULL'),
                            array('Product.season' => $this->request->query['season']),
                        )
                    )
                );
            endif;
        endforeach;

        if($this->request->query['season']=='all'):
            $conditions[] = array(
                'or' => array(
                    array(
                        array('BrandModel.season IS NOT NULL'),
                        array('BrandModel.season' => $this->request->query['season']),
                    ),
                    array(
                        array('BrandModel.season IS NULL'),
                        array('Product.season' => $this->request->query['season']),
                    )
                ));
        endif;
        //print_r($conditions);
        //exit();


        /******* настройки летние, зимние и всесезонные шины ********/




        /*if(isset($this->request->query['upr_all']) && !empty($this->request->query['upr_all']))
        {
        $conditions[] = array(
            'or' => array(
                array(
                    'BrandModel.season IS NOT NULL',
                    'BrandModel.season' => $this->request->query['season']
                ),
                array(
                    'BrandModel.season IS NULL',
                    'Product.season' => $this->request->query['season']
                ),
                        array(
                            'BrandModel.season IS NOT NULL',
                            'BrandModel.season' => 'all'
                        ),
                        array(
                            'BrandModel.season IS NULL',
                            'Product.season' => 'all'
                        )
            )
        );

        }
    else
        {
            $conditions[] = array(
            'or' => array(
                array(
                    'BrandModel.season IS NOT NULL',
                    'BrandModel.season' => $this->request->query['season']
                ),
                array(
                    'BrandModel.season IS NULL',
                    'Product.season' => $this->request->query['season']
                )
            )
        );

        }*/

        //print_r($conditions);
        //exit();

        if (is_array($this->request->query['season'])) {
            if (count($this->request->query['season']) == 1) {
                $this->request->data['Product']['season'] = $this->request->query['season'][0];
            } else {
                unset($this->request->data['Product']['season']);
            }
        }

        return $conditions;
    }





    private function get_conditions($conditions){
        if(isset($this->request->query['season'])&&!empty($this->request->query['season'])){
            $conditions[] = $this->get_conditions_season($conditions);
        }





        $auto = '';
        if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
            $conditions[] = array(
                'or' => array(
                    array(
                        'BrandModel.auto IS NOT NULL',
                        'BrandModel.auto' => $this->request->query['auto']
                    ),
                    array(
                        'BrandModel.auto IS NULL',
                        'Product.auto' => $this->request->query['auto']
                    )
                )
            );
            $auto = $this->request->query['auto'];
            if (is_array($this->request->query['auto'])) {
                if (count($this->request->query['auto']) == 1) {
                    $this->request->data['Product']['auto'] = $this->request->query['auto'][0];
                } else {
                    unset($this->request->data['Product']['auto']);
                }
            }
        }
        if (isset($this->request->query['stud']) && $this->request->query['stud']) {
            $conditions['Product.stud'] = 1;
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
        if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
            $conditions['Product.size1'] = $this->_get_sizes($this->request->query['size1']);
        }
        if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
            $conditions['Product.size2'] = $this->_get_sizes($this->request->query['size2']);
        }
        if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
            $conditions['Product.size3'] = $this->_get_sizes($this->request->query['size3']);
        }
        if (isset($this->request->query['stud']) && $this->request->query['stud']) {
            $conditions['Product.stud'] = 1;
        }
        if (isset($this->request->query['axis']) && !empty($this->request->query['axis']) && $auto == 'trucks') {
            $conditions['Product.axis'] = $this->request->query['axis'];
        }
        if (isset($this->request->query['price_from']) && !empty($this->request->query['price_from'])) {
            $conditions['Product.price >='] = intval($this->request->query['price_from']);
        }
        if (isset($this->request->query['price_to']) && !empty($this->request->query['price_to'])) {
            $conditions['Product.price <='] = intval($this->request->query['price_to']);
        }




        //print_r($conditions);


        return $conditions;
    }
    private function _get_sizes($size) {
        if (substr_count($size, '.') > 0) {
            $sizes = array(
                $size,
                str_replace('.', ',', $size)
            );
            $parts = explode('.', $size);
            if (strlen($parts[1]) == 2 && substr($parts[1], 1) == '0') {
                $new_size = substr($size, 0, -1);
                $sizes[] = $new_size;
                $sizes[] = str_replace('.', ',', $new_size);
            }
            elseif (strlen($parts[1]) == 1) {
                $new_size = $size . '0';
                $sizes[] = $new_size;
                $sizes[] = str_replace('.', ',', $new_size);
            }
            return $sizes;
        }
        else {
            return $size;
        }
    }
    public function set_filter() {
        Configure::write('debug', 0);
        $conditions = array('Product.is_active' => 1, 'Product.category_id' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
        $conditions = $this->get_conditions($conditions);
        if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
            $brand_id = intval($this->request->query['brand_id']);
            if ($brand_id != 0) {
                $conditions['Product.brand_id'] = $this->request->query['brand_id'];
            }
        }
        $result = $this->_filter_params($conditions);
        echo json_encode($result);
        $this->layout = false;
        $this->render(false);
    }

    protected function _filter_by_auto_test($filter_conditions) {
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
        unset($filter_conditions['Product.model_id']);
        //$tyre_size1 = Cache::read('tyre_size1', 'long');
        $conditions = array('Product.category_id' => 1, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
//        if (CONST_DISABLE_FILTERS == '0') {
//            if ($filter_conditions) {
//                $conditions = $filter_conditions;
//            }
//        }


        if (empty($tyre_size1)) {

            $temp_cond = $conditions;
            unset($temp_cond['Product.size1']);

            //*********** Вывод в фильтре кроме .... при выборе auto => все
            if(empty($this->request->query['auto'])):
                //$temp_cond['AND'] = array('Product.auto !=' => array('trucks','agricultural','special'));
                $temp_cond['AND'] = array('Product.auto !=' => array('trucks','special'));
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все

            //print_r($temp_cond);
            $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));

            $tyre_size1 = array();
            foreach ($products as $item) {
                $size = number_format(str_replace(',', '.', $item['Product']['size1']), 2, '.', '');
                $size = str_replace('.00', '', $size);
                $tyre_size1[$size] = $size;
            }
            natsort($tyre_size1);
            unset($tyre_size1[0]);

            //	print_r($tyre_size1);

            Cache::write('tyre_size1', $tyre_size1, 'long');
        }
        //$tyre_size2 = Cache::read('tyre_size2', 'long');
        if (empty($tyre_size2)) {
            $temp_cond = $conditions;
            unset($temp_cond['Product.size2']);
            $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size2', 'order' => 'Product.size2'));
            $tyre_size2 = array();
            foreach ($products as $item) {
                $size = number_format(floatval(str_replace(',', '.', $item['Product']['size2'])), 1, '.', '');
                if (!empty($size) && $size != '') {
                    $size = str_replace('.0', '', $size);
                    $tyre_size2[$size] = $size;
                }
            }
            natsort($tyre_size2);
            unset($tyre_size2[0]);
            Cache::write('tyre_size2', $tyre_size2, 'long');
        }

        //$tyre_size3 = Cache::read('tyre_size3', 'long');
        if (empty($tyre_size3)) {
            $temp_cond = $conditions;
            unset($temp_cond['Product.size3']);
            $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size3', 'order' => 'Product.size3'));
            $tyre_size3 = array();
            foreach ($products as $item) {
                $numeric_size = str_replace(',', '.', $item['Product']['size3']);
                if (is_numeric($numeric_size)) {
                    $size = number_format(str_replace(',', '.', $item['Product']['size3']), 1, '.', '');
                    if (!empty($size) && $size != '') {
                        $size = str_replace('.0', '', $size);
                        $tyre_size3[$size] = $size;
                    }
                }
                else {
                    $size = trim($item['Product']['size3']);
                    if (!empty($size) && $size != '') {
                        $tyre_size3[$size] = $size;
                    }
                }
            }
            natsort($tyre_size3);
            unset($tyre_size3[0]);
            Cache::write('tyre_size3', $tyre_size3, 'long');
        }



        if (empty($auto)) {
            //print_r($conditions);

            $temp_cond = $conditions;
            foreach ($temp_cond as $i => $cond) {
                if (is_array($cond) && isset($cond['or']) && isset($cond['or'][0]['BrandModel.auto'])) {
                    unset($temp_cond[$i]);
                    break;
                }
            }

            $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT(IF(BrandModel.auto IS NULL,Product.auto,BrandModel.auto)) AS auto', 'order' => 'Product.auto'));
            $auto = array();
            foreach ($products as $item) {
                if (isset($this->Product->auto[$item[0]['auto']])) {
                    $auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];
                }
            }
            //print_r($auto);
        }

        $tyre_axis = array();
        $temp_cond = $conditions;
        unset($temp_cond['Product.axis']);
        $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.axis', 'order' => 'Product.axis'));
        foreach ($products as $item) {
            $axis = trim($item['Product']['axis']);
            if (!empty($axis) && $axis != '') {
                $tyre_axis[$item['Product']['axis']] = $item['Product']['axis'];
            }
        }

        $temp_cond = $conditions;
        $temp_cond['Product.stud'] = 1;
        $stud = $this->Product->find('count', array('conditions' => $temp_cond));


        $temp_cond = $conditions;
        $temp_cond['Product.in_stock'] = 1;
        $in_stock = $this->Product->find('count', array('conditions' => $temp_cond));


        $temp_cond = $conditions;
        $temp_cond['Product.stock_count >= '] = 4;
        $in_stock4 = $this->Product->find('count', array('conditions' => $temp_cond));

        unset($conditions['Product.brand_id']);
        $brands = $this->Product->find('all', array(
            'fields' => array('Product.brand_id'),
            'conditions' => $conditions
        ));
        $brand_ids = array();
        foreach ($brands as $brand) {
            if (!in_array($brand['Product']['brand_id'], $brand_ids)) {
                $brand_ids[] = $brand['Product']['brand_id'];
            }
        }
        $brand_conditions = array('Brand.category_id' => $this->category_id, 'Brand.is_active' => 1, 'Brand.active_products_count > 0');
        $brand_conditions['Brand.id'] = $brand_ids;
        $this->loadModel('Brand');
        $brands = $this->Brand->find('list', array('order' => array('Brand.title' => 'asc'), 'conditions' => $brand_conditions, 'fields' => array('Brand.id', 'Brand.title')));

        if ($this->request->is('ajax')) {
            $result = array(
                'size1' => $tyre_size1,
                'size2' => $tyre_size2,
                'size3' => $tyre_size3,
                'auto' => $auto,
            );
            return $result;
        } else {
            $this->set('tyre_size1', $tyre_size1);
            $this->set('tyre_size2', $tyre_size2);
            $this->set('tyre_size3', $tyre_size3);
            $this->set('filter_auto', $auto);
        }
    }





    public function popular() {
        $this->loadModel('Page');
        if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'tyres')))) {
            $this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
            $this->setMeta('keywords', $page['Page']['meta_keywords']);
            $this->setMeta('description', $page['Page']['meta_description']);
            $this->set('page', $page);
        }
        $this->category_id = 1;
        $this->_filter_params();
        $this->loadModel('Product');
        $this->loadModel('BrandModel');

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
        $this->loadModel('Settings');
        $select = $this->Settings->find('all', array('conditions' => array('type' => 'radio')));
        //$select = $this->Settings->find('all');

        //echo"-------";
        //print_r($select);


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
        $new = $this->BrandModel->find('all',
            array(
                'limit' => 3,
                'conditions' => array(
                    'BrandModel.new' => 1,
                    'BrandModel.category_id' => 1,
                    'BrandModel.is_active' => 1,
                    'BrandModel.active_products_count > 0'
                )
            )
        );
        $popular = $this->BrandModel->find('all', array('limit' => 3, 'conditions' => array('BrandModel.popular' => 1, 'BrandModel.category_id' => 1, 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0')));
        /*** Выборка *****/


        $this->set('new', $new);
        $this->set('popular', $popular);
        $this->set('active_menu', 'tyres');
        $this->set('show_left_menu', true);
    }
}