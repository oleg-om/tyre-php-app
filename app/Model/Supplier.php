<?php

class Supplier extends AppModel
{
    public $name = 'Supplier';
    public $validationDomain = 'admin_suppliers';
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'delivery_time_from' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_station_id_empty'
            ),
        ),
        'delivery_time_to' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_station_id_empty'
            ),
        ),
        'prefix' => array()
    );

    public $tmp_data = null;

    public function __construct()
    {
        parent::__construct();
        $this->virtualFields['is_deletable'] = 1;
    }

    public function beforeDelete($cascade = true)
    {
        if (parent::beforeDelete()) {
            $Product = ClassRegistry::init('Product');

            $affected_brands = $Product->find('all', array(
                'conditions' => array('Product.supplier_id' => $this->id),
                'fields' => array('DISTINCT Product.brand_id'),
            ));
            $affected_models = $Product->find('all', array(
                'conditions' => array('Product.supplier_id' => $this->id),
                'fields' => array('DISTINCT Product.model_id'),
            ));

            $this->tmp_data = array(
                'brand_ids' => array_values(array_filter(array_unique(array_map(function($p) { return $p['Product']['brand_id']; }, $affected_brands)))),
                'model_ids' => array_values(array_filter(array_unique(array_map(function($p) { return $p['Product']['model_id']; }, $affected_models)))),
            );

            return true;
        }
        return false;
    }

    public function afterDelete()
    {
        $Product = ClassRegistry::init('Product');

        Configure::write('Product.skip_recount_on_delete', true);
        $Product->deleteAll(array('Product.supplier_id' => $this->id), true, true);
        Configure::write('Product.skip_recount_on_delete', false);

        if (!empty($this->tmp_data['brand_ids'])) {
            $Brand = ClassRegistry::init('Brand');
            $Brand->recountProducts($this->tmp_data['brand_ids']);
            $Brand->recountModels($this->tmp_data['brand_ids']);
        }
        if (!empty($this->tmp_data['model_ids'])) {
            $BrandModel = ClassRegistry::init('BrandModel');
            $BrandModel->recountProducts($this->tmp_data['model_ids']);
        }

        Cache::delete('brands_1', 'long');
        Cache::delete('brands_2', 'long');
        Cache::delete('brands_3', 'long');
        Cache::delete('import_brands_1', 'long');
        Cache::delete('import_brands_2', 'long');
        Cache::delete('import_brands_by_id_1', 'long');
        Cache::delete('import_brands_by_id_2', 'long');
        Cache::delete('import_models_1', 'long');
        Cache::delete('import_models_2', 'long');
        Cache::delete('import_models_by_id_1', 'long');
        Cache::delete('import_models_by_id_2', 'long');

        return true;
    }
}
