<?php
class SitemapController extends AppController {
    public $uses = array();
    public $layout = 'xml';
    public $paginate = array(
        'order' => array(
            'Product.title' => 'asc'
        )
    );
    public $filter_fields = array('Product.id' => 'int', 'Product.category_id' => 'int', 'Product.title' => 'text');
    public $model = 'Product';

    public function main(){
    }
    public function tyres(){
        $this->loadModel('Brand');
        $this->loadModel('Product');
        $this->Product->bindModel(
            array(
                'belongsTo' => array(
                    'Brand' => array(
                        'foreignKey' => 'brand_id'
                    ),
                    'Brand'
                )
            ),
            false
        );

        $conditions = array('Product.is_active' => 1, 'Product.category_id' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
        $products = $this->Product->find('all', array('conditions' => $conditions, 'order' => 'Product.price ASC'));
        $this->set('products', $products);
    }
}