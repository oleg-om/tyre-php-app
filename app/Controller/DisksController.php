<?php

class DisksController extends AppController
{
    public $uses = array();
    public $layout = 'inner';
    public $paginate = array();

    public $prod = array('в наличии' => 1, 'под заказ' => 0);

    public $filter_fields = array('Product.id' => 'int', 'Product.brand_id' => 'int', 'Product.model_id' => 'int', 'Product.sku' => 'text', 'Product.supplier_id' => 'int');
    public $model = 'Product';
    public $submenu = 'products';
    public $conditions = array('Product.category_id' => 2);

    public function _list()
    {
        parent::_list();
        $this->loadModel('Supplier');
        $this->set('suppliers', $this->Supplier->find('list', array('fields' => array('Supplier.id', 'Supplier.title'), 'order' => array('Supplier.title' => 'asc'))));
        $this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 2))));
        if (isset($this->request->data['Product']['brand_id'])) {
            $this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
        } else {
            $this->set('models', array('' => __d('admin_common', 'list_all_items')));
        }
        $this->set('all_models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'order' => array('BrandModel.title' => 'asc'), 'conditions' => array('BrandModel.category_id' => 2))));
    }

    public function _edit($id)
    {
        $title = parent::_edit($id);
        $this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 2))));
        if (isset($this->request->data['Product']['brand_id'])) {
            $this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
        } else {
            $this->set('models', array('' => __d('admin_common', 'list_any_items')));
        }
        $this->set('auto', $this->{$this->model}->auto);
        $this->set('materials', $this->BrandModel->materials);
        return $title;
    }

    public function admin_apply()
    {
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

    public function admin_stockon($id = 0)
    {
        $this->_stock($id, 1);
    }

    public function admin_stockoff($id = 0)
    {
        $this->_stock($id, 0);
    }

    private function _stock($id, $state)
    {
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
        } else {
            $this->set('status', abs($state - 1));
        }
        $this->render(false);
    }

    public function admin_clear()
    {
        $this->loadModel($this->model);
        // Отключаем пересчет счетчиков в afterDelete для ускорения массового удаления
        Configure::write('Product.skip_recount_on_delete', true);
        $this->{$this->model}->deleteAll($this->conditions, true, true);
        Configure::write('Product.skip_recount_on_delete', false);
        // Обнуляем счетчики одним запросом после удаления
        $this->{$this->model}->query('UPDATE brands SET products_count=0,active_products_count=0 WHERE category_id=2');
        $this->{$this->model}->query('UPDATE brand_models SET products_count=0,active_products_count=0 WHERE category_id=2');
        $this->info($this->t('message_data_cleared'));
        $url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
        $this->redirect($url);
    }

    public function admin_clear_supplier()
    {
        $this->loadModel($this->model);
        $supplier_id = $this->request->query['Product_supplier_id'];

        if (!empty($supplier_id)) {
            $this->conditions['Product.supplier_id'] = $supplier_id;
            // Отключаем пересчет счетчиков для ускорения массового удаления
            Configure::write('Product.skip_recount_on_delete', true);
            $this->{$this->model}->deleteAll($this->conditions, true, true);
            Configure::write('Product.skip_recount_on_delete', false);
            $this->info($this->t('message_supplier_data_cleared'));
        } else {
            $this->error($this->t('message_fill_supplier'));
        }

        $url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
        $this->redirect($url);
    }


    function sett_var($var)
    {
        $this->loadModel('Settings');
        $sett = $this->Settings->find('all', array(
            'fields' => array('Settings.variable', 'Settings.value'),
            'conditions' => array(
                'or' => array(
                    array('Settings.variable' => $var),
                )
            )
        ));
        //print_r($sett[]);
        return $sett[0]['Settings']['value'];

    }


    public function check_truck($auto)
    {
        $is_truck_page = $this->request->query['auto'] == 'trucks' || $this->request->query['auto'] == 'agricultural' || $this->request->query['auto'] == 'special' || $this->request->query['auto'] == 'loader';

        $path = 'disks';
        if ($is_truck_page) {
            $path = 'truck-disks';
        }

        if (!empty($auto)) {
            if ($auto === 'trucks' || $auto === 'agricultural' || $auto === 'special' || $auto === 'loader') {
                $path = 'truck-disks';
            }
        }

        return array('path' => $path);
    }


    public function index()
    {
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

        // modification
        $this->setModification();

        /*
        if($this->sett_var('SHOW_DISKS_IMG_TOVAR')==1):

            //'Product.filename !=' => ''
            $conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
        else:
            $conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
        endif;
        */


        $conditions = array('Product.is_active' => 1, 'Product.category_id' => 2, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);

//        if ($this->check_truck($this->request->query['auto'])['path'] === 'truck-wheels') {
//
//        } else {
//            $conditions['Product.auto'] = 'cars';
//        }

        if (isset($this->request->query['hub_from']) && !empty($this->request->query['hub_from'])) {
            $hub = floatval(str_replace(',', '.', $this->request->query['hub_from']));
            if ($hub > 0) {
                $conditions['Product.hub >='] = $hub;
            }
        }
        if (isset($this->request->query['hub_to']) && !empty($this->request->query['hub_to'])) {
            $hub = floatval(str_replace(',', '.', $this->request->query['hub_to']));
            if ($hub > 0) {
                $conditions['Product.hub <='] = $hub;
            }
        }

        if (isset($this->request->query['width_from']) && isset($this->request->query['width_to'])) {
            $this->Product->virtualFields['width_number'] = 'CONVERT(size3,DECIMAL(5,1))';
        }

        if (isset($this->request->query['width_from']) && !empty($this->request->query['width_from'])) {
            $width = floatval(str_replace(',', '.', $this->request->query['width_from']));
            if ($width > 0) {
                $conditions['Product.width_number >='] = $width;
            }
        }

        if (isset($this->request->query['width_to']) && !empty($this->request->query['width_to'])) {
            $width = floatval(str_replace(',', '.', $this->request->query['width_to']));
            if ($width > 0) {
                $conditions['Product.width_number <='] = $width;
            }
        }

        if (isset($this->request->query['stock_place']) && $this->request->query['stock_place'] != '') {
            $conditions['Product.count_place_' . $this->request->query['stock_place'] . ' >='] = 1;
        }

        if (empty($this->request->query['size1']) && empty($this->request->query['size3']) && empty($this->request->query['size2']) && empty($this->request->query['et_from']) && empty($this->request->query['et_to']) && empty($this->request->query['hub_from']) && empty($this->request->query['hub_to']) && empty($this->request->query['hub']) && empty($this->request->query['material'])
            && (!isset($this->request->query['auto']) || empty($this->request->query['auto']) || $this->request->query['auto'] === 'cars')) {
            $conditions['Product.size1'] = 18;
        }

        if ($this->request->query['p1'] == 1 || $this->request->query['p2'] == 1 || $this->request->query['p3'] == 1) {
            if (isset($this->request->query['p1']) && $this->request->query['p1'] == 1) {
                $conditions['OR']['Product.p1'] = 1;
            }
            if (isset($this->request->query['p2']) && $this->request->query['p2'] == 1) {
                $conditions['OR']['Product.p2'] = 1;
            }
            if (isset($this->request->query['p3']) && $this->request->query['p3'] == 1) {
                $conditions['OR']['Product.p3'] = 1;
            }
        }

        if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
            $conditions['Product.auto'] = $this->request->query['auto'];
        } else {
            $conditions['Product.auto'] = 'cars';
        }

        $this->request->data['Product'] = $this->request->query;
        $mode = 'block';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $this->request->data['Product']['mode'] = $mode;
        $this->set('mode', $mode);
        if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id']) && strpos($this->request->query['brand_id'], ',') === false) {
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

        if (isset($this->request->query['brand_id']) && strpos($this->request->query['brand_id'], ',') !== false) {
            $conditions['Product.brand_id'] = explode(',', $this->request->query['brand_id']);
        }

        $product_conditions = $conditions = $this->get_conditions($conditions);

        $this->set('filter', array_filter($this->request->query));
        $material_condition = '';
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

        $product_ids = implode(", ", array_keys($model_ids));
        if (empty($product_ids)) {
            $product_ids = 0;
        }


        if (isset($this->request->query['in_stock'])) {
            if ($this->request->query['in_stock'] == 1) {
                $conditions['Product.in_stock'] = 1;

            } elseif ($this->request->query['in_stock'] == 0) {
                $conditions['Product.in_stock'] = 0;
            } else {
                $conditions['Product.in_stock'] = array(0, 1);
            }
        } else {
            /*** select *****/
            $this->loadModel('Settings');
            $s = $this->Settings->find('all', array('conditions' => array('type' => 'radio', 'variable' => 'PRODUCTINSTOCK2', 'value' => 1)));
            if (isset($this->prod[$s[0]['Settings']['description']])):
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
                        'conditions' => ($conditions['Product.filename !='] = ''),
                        'order' => 'Product.price ASC'
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
            if ($this->sett_var('SHOW_DISKS_IMG') == 1)
                $product_conditions['BrandModel.filename !='] = '';
            $this->paginate['conditions'] = $product_conditions;
        } else {
            if ($this->sett_var('SHOW_DISKS_IMG_TOVAR') == 1)
                $model_conditions = array('BrandModel.category_id' => 1, 'BrandModel.is_active' => 1, 'BrandModel.category_id' => 2, 'BrandModel.id' => $model_ids, 'BrandModel.filename !=' => '');
            else    $model_conditions = array('BrandModel.category_id' => 1, 'BrandModel.is_active' => 1, 'BrandModel.category_id' => 2, 'BrandModel.id' => $model_ids);


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
        } else {
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

            $this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where `products`.`model_id`=`BrandModel`.`id`  AND `products`.`id` IN (' . $product_ids . '))';

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
        } else {
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
            if ($m['Product'][0]['price'] == 0):
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
        $path = $this->check_truck($this->request->query['auto'])['path'];
        $this->set('active_menu', $path);
        $this->set('sort', $sort);
        $this->set('show_left_filter', true);
        $this->set('additional_js', array('lightbox', 'slider', 'functions'));
        $this->set('additional_css', array('lightbox', 'jquery-ui-1.9.2.custom.min'));
    }


    public function brand($slug)
    {
//		echo"******";
        $this->category_id = 2;
        $mode = 'block';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $this->set('mode', $mode);
        $sort = 'price_asc';
        $auto = 'cars';
        if (isset($this->request->query['sort']) && in_array($this->request->query['sort'], array('name', 'price_asc', 'price_desc'))) {
            $sort = $this->request->query['sort'];
        }
        if ($mode == 'table') {
            $sort_orders = array(
                'price_asc' => array('Product.price' => 'ASC'),
                'price_desc' => array('Product.price' => 'DESC'),
                'name' => array('BrandModel.full_title' => 'ASC'),
            );
        } else {
            $sort_orders = array(
                'price_asc' => array('BrandModel.low_price' => 'ASC'),
                'price_desc' => array('BrandModel.low_price' => 'DESC'),
                'name' => array('BrandModel.full_title' => 'ASC'),
            );
        }

        // modification
        $this->setModification();

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
                    } elseif ($new_brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
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


            if ($this->sett_var('SHOW_DISKS_IMG') == 1)
                $models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.filename !=' => ''), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
            else    $models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));


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

            if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
                $conditions['Product.auto'] = $this->request->query['auto'];
            } else {
                $conditions['Product.auto'] = 'cars';
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


            if (isset($this->request->query['p1']) && $this->request->query['p1'] == 1) {
                $conditions['Product.p1'] = 1;
            }
            if (isset($this->request->query['p2']) && $this->request->query['p2'] == 1) {
                $conditions['Product.p2'] = 1;
            }
            if (isset($this->request->query['p3']) && $this->request->query['p3'] == 1) {
                $conditions['Product.p3'] = 1;
            }


            if (isset($this->request->query['in_stock'])) {
                //echo"-----------".$this->request->query['in_stock'];
                //$conditions['Product.in_stock'] = $this->request->query['in_stock'];

                if ($this->request->query['in_stock'] == 1) {
                    $conditions['Product.in_stock'] = 1;
                } elseif ($this->request->query['in_stock'] == 0) {
                    $conditions['Product.in_stock'] = 0;
                } else {
                    $conditions['Product.in_stock'] = array(0, 1);
                }
            } else {

                /*** select *****/
                $this->loadModel('Settings');
                $s = $this->Settings->find('all', array('conditions' => array('type' => 'radio', 'variable' => 'PRODUCTINSTOCK2', 'value' => 1)));
                if (isset($this->prod[$s[0]['Settings']['description']])):
                    $this->request->query['in_stock'] = $this->prod[$s[0]['Settings']['description']];
                    $conditions['Product.in_stock'] = $this->request->query['in_stock'];
                else:
                    $this->request->query['in_stock'] = 2;
                endif;
                /*** select *****/

            }

            $material_condition = '';
            if (isset($conditions['BrandModel.material'])) {
                $material_condition = $conditions['BrandModel.material'];
                unset($conditions['BrandModel.material']);
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
            if (isset($this->request->query['stock_place']) && $this->request->query['stock_place'] != '') {
                $conditions['Product.count_place_' . $this->request->query['stock_place'] . ' >='] = 1;
            }
            $product_conditions = $conditions;

            //$product_conditions['Product.filename !='] = '';

            $model_ids = $this->Product->find('list', array(
                'fields' => array('Product.model_id'),
                'conditions' => $product_conditions
            ));

            $product_ids = implode(", ", array_keys($model_ids));
            if (empty($product_ids)) {
                $product_ids = 0;
            }
            $this->BrandModel->bindModel(
                array(
                    'belongsTo' => array(
                        'Brand'
                    ),
                    'hasMany' => array(
                        'Product' => array(
                            'foreignKey' => 'model_id',
                            'conditions' => $conditions,
                            'order' => array('Product.price' => 'asc', 'Product.size1' => 'asc', 'Product.size2' => 'asc', 'Product.hub' => 'asc')
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
                    $auto = $model['Product']['auto'];

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
            } else {
                $breadcrumbs[] = array(
                    'url' => null,
                    'title' => $brand['Brand']['title']
                );

//				print_r($conditions);

                if (count($conditions) == 4) {
                    if ($this->sett_var('SHOW_DISKS_IMG') == 1)
                        $model_conditions = array('BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.filename !=' => '');
                    else    $model_conditions = array('BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id']);
                } else {
                    if ($this->sett_var('SHOW_DISKS_IMG') == 1)
                        $model_conditions = array('BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.id' => $model_ids, 'BrandModel.filename !=' => '');
                    else    $model_conditions = array('BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.id' => $model_ids);
                }

                if (!empty($material_condition)) {
                    $model_conditions['BrandModel.material'] = $material_condition;
                }

                if (isset($this->request->query['material']) && !empty($this->request->query['material'])) {
                    $model_conditions['BrandModel.material'] = $this->request->query['material'];
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

                    if ($this->sett_var('SHOW_DISKS_IMG') == 1)
                        $product_conditions['BrandModel.filename !='] = '';
                    //$product_conditions['Product.filename !='] = '';
                    $this->paginate['conditions'] = $product_conditions;
                    $models = $this->paginate('Product');
                } else {
                    $this->BrandModel->virtualFields['low_price'] = '(select min(products.price) from `products` where `products`.`model_id`=`BrandModel`.`id` AND `products`.`id` IN (' . $product_ids . '))';
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
            $path = $this->check_truck($auto)['path'];
            $this->set('active_menu', $path);
            $this->set('additional_js', array('lightbox', 'slider', 'functions'));
            $this->set('additional_css', array('lightbox', 'jquery-ui-1.9.2.custom.min'));
            $this->render($render);
        } else {
            $this->response->statusCode(404);
            $this->response->send();
            $this->render(false);
            return;
        }
    }

    public function view($slug, $id)
    {
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
                    } elseif ($this->request->query['in_stock'] == 0) {
                        $conditions['Product.in_stock'] = 0;
                        $has_params = true;
                    }
                } else {
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
                                'order' => 'Product.price ASC'
                            )
                        )
                    ),
                    false
                );
                $model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $product['BrandModel']['id'])));

                if (!empty($model)) {
                    $auto = $model['Product'][0]['auto'];
                }
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
                $path = $this->check_truck($auto)['path'];
                $this->set('active_menu', $path);
                $this->set('show_left_menu', false);
            } else {
                $this->response->statusCode(404);
                $this->response->send();
                $this->render(false);
                return;
            }
        } else {
            $this->response->statusCode(404);
            $this->response->send();
            $this->render(false);
            return;
        }
    }

    private function get_conditions($conditions)
    {
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
        if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
            $conditions['Product.auto'] = $this->request->query['auto'];
        } else {
            $conditions['Product.auto'] = 'cars';
        }

        if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
            $conditions['Product.size3'] = $this->request->query['size3'];
        }
        if (isset($this->request->query['in_stock'])) {
            if ($this->request->query['in_stock'] == 1) {
                $conditions['Product.in_stock'] = 1;
            } elseif ($this->request->query['in_stock'] == 0) {
                $conditions['Product.in_stock'] = 0;
            }
        } else {
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
//        print_r(json_encode($conditions));
        return $conditions;
    }

    public function set_filter()
    {
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


    public function popular()
    {
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
        foreach ($select as $val):
            $select2[$val['Settings']['variable']][$val['Settings']['description']] = $val['Settings']['value'];
            if ($val['Settings']['variable'] == 'PRODUCTINSTOCK' && $val['Settings']['value'] == 1 && !empty($this->prod[$val['Settings']['description']])):
                $conditions['hasMany']['Product']['conditions'] = array('Product.in_stock' => $this->prod[$val['Settings']['description']]);
            endif;
        endforeach;
        $this->set('select', $select2);
        /*** select *****/
        /*** Выборка *****/
        $this->BrandModel->bindModel($conditions, false);
        $new = $this->BrandModel->find('all', array('limit' => 3, 'conditions' => array('BrandModel.new' => 1, 'BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0')));
        $popular = $this->BrandModel->find('all', array('limit' => 3, 'conditions' => array('BrandModel.popular' => 1, 'BrandModel.category_id' => 2, 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0')));
        /*** Выборка *****/

        $this->set('active_menu', 'disks');
        $this->set('show_left_menu', true);
        $this->set('new', $new);
        $this->set('popular', $popular);
    }

    function setModification()
    {
        $modification_slug = '';
        if ($this->Session->check('car_modification_slug')) {
            $modification_slug = $this->Session->read('car_modification_slug');
        }
        if (isset($this->request->query['modification']) && !empty($this->request->query['modification'])) {
            $modification_slug = $this->request->query['modification'];
        }
        if ($modification_slug) {
            $diameter = $this->request->query['diameter'];

            $this->loadModel('CarWheels');
            $this->loadModel('CarBrand');
            $this->loadModel('CarModel');
            $this->loadModel('CarGeneration');
            $this->loadModel('CarModification');

            $car_modification = $this->CarModification->find('first', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.slug' => $modification_slug)));
            $car_generation = $this->CarGeneration->find('first', array('conditions' => array('CarGeneration.is_active' => 1, 'CarGeneration.slug' => $car_modification['CarModification']['generation_slug'])));
            $car_model = $this->CarModel->find('first', array('conditions' => array('CarModel.is_active' => 1, 'CarModel.slug' => $car_generation['CarGeneration']['model_slug'])));
            $car_brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.slug' => $car_model['CarModel']['brand_slug'])));

            $this->set('car_modification', $car_modification);
            $this->set('car_generation', $car_generation);
            $this->set('car_model', $car_model);
            $this->set('car_brand', $car_brand);
            $this->set('modification_slug', $modification_slug);

            if (!empty($this->request->query['material'])) {
                $material = $this->request->query['material'];
                $this->set('material', $material);
            }

            $car_factory_sizes = $this->CarWheels->find('all', array('conditions' => array('CarWheels.modification_slug' => $modification_slug, 'CarWheels.factory' => 1)));

            if (!empty($car_factory_sizes[0])) {
                $factory_pcd = $car_factory_sizes[0]['CarWheels']['front_axle_pcd'];
            }

            $car_tuning_sizes = $this->CarWheels->find('all', array('conditions' => array('CarWheels.modification_slug' => $modification_slug, 'CarWheels.factory' => 0)));
            if (!empty($factory_pcd)) {
                $car_tuning_sizes = $this->CarWheels->find('all', array('conditions' => array('CarWheels.modification_slug' => $modification_slug, 'CarWheels.factory' => 0, 'CarWheels.front_axle_pcd' => $factory_pcd)));
            }

            $this->set('car_image', $car_generation['CarGeneration']['image_default']);

            // get diameters
            $car_diameters = array();
            foreach ($car_factory_sizes as $car_size) {
                $car_diameters[] = 'R' . $car_size['CarWheels']['front_axle_diameter'];
            }
            foreach ($car_tuning_sizes as $car_size) {
                $car_diameters[] = 'R' . $car_size['CarWheels']['front_axle_diameter'];
            }


            $this->set('car_diameters', array_unique($car_diameters));

//             if no sizes in query url use first factory size
            if (empty($this->request->query['size1']) && empty($this->request->query['size2']) && empty($this->request->query['et_from'])
                && empty($this->request->query['et_to']) && empty($this->request->query['hub_from']) && empty($diameter)
            ) {
                // check count
                $sizes = array($car_factory_sizes[0], $car_tuning_sizes[0], $car_factory_sizes[1], $car_tuning_sizes[1]);
                $sizes_count = array();

                // Убеждаемся, что Product загружен
                if (empty($this->Product)) {
                    $this->loadModel('Product');
                }
                
                $this->Product->virtualFields['width_number'] = 'CONVERT(size3,DECIMAL(5,1))';
                foreach ($sizes as $key => $size_item) {
                    // Пропускаем пустые элементы
                    if (empty($size_item) || empty($size_item['CarWheels'])) {
                        $sizes_count[$key] = 0;
                        continue;
                    }
                    
                    $item = $size_item['CarWheels'];
                    $count_filter = array('Product.size1' => $item['front_axle_diameter']);
                    $count_filter['Product.category_id'] = 2;
                    $count_filter['or'] = 'Product.size2 LIKE "' . $item['front_axle_pn'] . 'x%/' . $item['front_axle_pcd'] . '"';
                    $count_filter['Product.et >='] = $item['front_axle_et_min'];
                    $count_filter['Product.et <='] = $item['front_axle_et_max'];
                    $count_filter['Product.hub >='] = $item['front_axle_co_min'];
                    $count_filter['Product.hub <='] = $item['front_axle_co_max'];
                    $count_filter['Product.width_number >='] = $item['front_axle_width_min'];
                    $count_filter['Product.width_number <='] = $item['front_axle_width_max'];

                    $product_count = $this->Product->find('count', array('conditions' => $count_filter));
                    $sizes_count[$key] = $product_count;
                }

                // get the highest count
                $max_count = max($sizes_count);

                // find the key of the product with the highest price
                $product_key = array_search($max_count, $sizes_count);

                $item = $sizes[$product_key]['CarWheels'];
                //
                $filter = array('size1' => $item['front_axle_diameter'], 'size2' => $item['front_axle_pn'] . 'x' . $item['front_axle_pcd'], 'et_from' => $item['front_axle_et_min'], 'et_to' => $item['front_axle_et_max'], 'hub_from' => strval($item['front_axle_co_min']), 'hub_to' => strval($item['front_axle_co_max']), 'in_stock4' => 0, 'in_stock' => 2, 'width_from' => $item['front_axle_width_min'], 'width_to' => $item['front_axle_width_max'], 'modification' => $item['modification_slug'], 'diameter' => 'R' . $item['front_axle_diameter'], 'material' => $material);

                $this->set('car_factory_sizes', $car_factory_sizes);
                $this->set('car_tuning_sizes', $car_tuning_sizes);

                $this->redirect(array('controller' => 'disks', 'action' => 'index', '?' => $filter));
            }

            // if paginate with diameter
            if (!empty($diameter)) {
                function filterDiameters($val)
                {
                    return function ($item) use ($val) {
                        if (strpos('R' . $item['CarWheels']['front_axle_diameter'], $val) !== FALSE) {
                            return 1;
                        } else {
                            return 0;
                        }
                    };
                }

                $filteredFactoryTyres = array_filter($car_factory_sizes, filterDiameters($diameter));
                $filteredTuningTyres = array_filter($car_tuning_sizes, filterDiameters($diameter));

                $this->set('car_factory_sizes', $filteredFactoryTyres);
                $this->set('car_tuning_sizes', $filteredTuningTyres);


                if (empty($this->request->query['size1']) && empty($this->request->query['size2']) && empty($this->request->query['et_from'])
                    && empty($this->request->query['et_to']) && empty($this->request->query['hub_from'])) {

                    if (!empty($filteredFactoryTyres)) {
                        $first_size = array_values($filteredFactoryTyres)[0];
                    } else {
                        $first_size = array_values($filteredTuningTyres)[0];
                    }

                    // getDiskParams
                    $item = $first_size['CarWheels'];
                    $filter = array('size1' => $item['front_axle_diameter'], 'size2' => $item['front_axle_pn'] . 'x' . $item['front_axle_pcd'], 'et_from' => $item['front_axle_et_min'], 'et_to' => $item['front_axle_et_max'], 'hub_from' => strval($item['front_axle_co_min']), 'hub_to' => strval($item['front_axle_co_max']), 'in_stock4' => 0, 'in_stock' => 2, 'width_from' => $item['front_axle_width_min'], 'width_to' => $item['front_axle_width_max'], 'modification' => $item['modification_slug'], 'diameter' => $diameter, 'material' => $material);

                    // redirect with sizes
                    $this->redirect(array('controller' => 'disks', 'action' => 'index', '?' => $filter));
                }


            }


            $this->set('size1', $this->request->query['size1']);
            $this->set('size2', $this->request->query['size2']);
            if (!empty($this->request->query['size3'])) {
                $this->set('size3', $this->request->query['size3']);
            }
        }
    }
}
