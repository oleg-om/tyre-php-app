<?php

Router::connect(
	'/privat_response',
	array(
		'controller' => 'orders',
		'action' => 'privat_response'
	)
);

// корзина
Router::connect(
	'/cart',
	array(
		'controller' => 'orders',
		'action' => 'cart'
	)
);

// спасибо за заказ
Router::connect(
	'/thank',
	array(
		'controller' => 'orders',
		'action' => 'thank'
	)
);

// сезонное хранение шин
Router::connect(
	'/storage',
	array(
		'controller' => 'storage_requests',
		'action' => 'index'
	)
);

// оформление заказа
Router::connect(
	'/checkout',
	array(
		'controller' => 'orders',
		'action' => 'checkout'
	)
);

// удаление из корзины
Router::connect(
	'/cart/delete/:id',
	array(
		'controller' => 'orders',
		'action' => 'delete_from_cart'
	),
	array(
		'pass' => array(
			'id'
		),
		'id' => '[0-9]+'
	)
);

Router::connect(
	'/upload',
	array(
		'controller' => 'used_tyres',
		'action' => 'upload'
	)
);
 
// главная
Router::connect(
	'/',
	array(
		'controller' => 'pages',
		'action' => 'home'
	)
);
 
// акции
Router::connect(
	'/sales',
	array(
		'controller' => 'pages',
		'action' => 'sales'
	)
);

// Доставка
Router::connect(
	'/delivery',
	array(
		'controller' => 'pages',
		'action' => 'delivery'
	)
);

// город доставки
Router::connect(
	'/delivery/:slug',
	array(
		'controller' => 'pages',
		'action' => 'city'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);


Router::connect(
	'/stations/booking',
	array(
		'controller' => 'stations',
		'action' => 'booking'
	)
);
Router::connect(
	'/stations/thanks/:id',
	array(
		'controller' => 'stations',
		'action' => 'thanks'
	),
	array(
		'pass' => array(
			'id'
		),
		'id' => '[0-9]+'
	)
);

Router::connect(
	'/stations/:slug',
	array(
		'controller' => 'stations',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);

Router::connect(
	'/storage/set_filter',
	array(
		'controller' => 'storage_requests',
		'action' => 'set_filter'
	)
);

Router::connect(
	'/tyres/popular',
	array(
		'controller' => 'tyres',
		'action' => 'popular'
	)
);

Router::connect(
	'/tyres/set_filter',
	array(
		'controller' => 'tyres',
		'action' => 'set_filter'
	)
);

Router::connect(
	'/tyres/auto',
	array(
		'controller' => 'tyres',
		'action' => 'auto'
	)
);

Router::connect(
	'/api/products',
	array(
		'controller' => 'Products',
		'action' => 'api'
	)
);

Router::connect(
	'/api/orders',
	array(
		'controller' => 'Orders',
		'action' => 'api'
	)
);

Router::connect(
	'/api/brands',
	array(
		'controller' => 'Brands',
		'action' => 'api'
	)
);

Router::connect(
	'/api/models',
	array(
		'controller' => 'Models',
		'action' => 'api'
	)
);

Router::connect(
	'/disks/set_filter',
	array(
		'controller' => 'disks',
		'action' => 'set_filter'
	)
);


Router::connect(
	'/disks/ttt',
	array(
		'controller' => 'disks',
		'action' => 'ttt'
	)
);


Router::connect(
	'/bolts/set_filter',
	array(
		'controller' => 'bolts',
		'action' => 'set_filter'
	)
);

// фильтр для АКБ
Router::connect(
	'/akb/set_filter',
	array(
		'controller' => 'akb',
		'action' => 'set_filter'
	)
);

// шина
Router::connect(
	'/tyres/:slug/:id',
	array(
		'controller' => 'tyres',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'slug',
			'id'
		),
		'slug' => '[A-z0-9_-]+',
		'id' => '[0-9]+'
	)
);

// бренд шин
Router::connect(
	'/tyres/:slug/*',
	array(
		'controller' => 'tyres',
		'action' => 'brand'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);

// шины
Router::connect(
	'/tyres/*',
	array(
		'controller' => 'tyres',
		'action' => 'index'
	)
);


// автокамера
Router::connect(
	'/tubes/:id',
	array(
		'controller' => 'tubes',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'id'
		),
		'id' => '[0-9]+'
	)
);

// автокамеры
Router::connect(
	'/tubes/*',
	array(
		'controller' => 'tubes',
		'action' => 'index'
	)
);


// болты
Router::connect(
	'/bolts/:id',
	array(
		'controller' => 'bolts',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'id'
		),
		'id' => '[0-9]+'
	)
);

// болты
Router::connect(
	'/bolts/*',
	array(
		'controller' => 'bolts',
		'action' => 'index'
	)
);

Router::connect(
	'/disks/popular',
	array(
		'controller' => 'disks',
		'action' => 'popular'
	)
);

// диск
Router::connect(
	'/disks/:slug/:id',
	array(
		'controller' => 'disks',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'slug',
			'id'
		),
		'slug' => '[A-z0-9_-]+',
		'id' => '[0-9]+'
	)
);

// бренд дисков
Router::connect(
	'/disks/:slug/*',
	array(
		'controller' => 'disks',
		'action' => 'brand'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);

// диски
Router::connect(
	'/disks/*',
	array(
		'controller' => 'disks',
		'action' => 'index'
	)
);

// диск
Router::connect(
	'/akb/:slug/:id',
	array(
		'controller' => 'akb',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'slug',
			'id'
		),
		'slug' => '[A-z0-9_-]+',
		'id' => '[0-9]+'
	)
);

// бренд аккумуляторов
Router::connect(
	'/akb/:slug/*',
	array(
		'controller' => 'akb',
		'action' => 'brand'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);

// аккумуляторы
Router::connect(
	'/akb/*',
	array(
		'controller' => 'akb',
		'action' => 'index'
	)
);

// страница
Router::connect(
	'/page-:slug',
	array(
		'controller' => 'pages',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);
Router::connect(
	'/selection/view',
	array(
		'controller' => 'cars',
		'action' => 'view'
	)
);
// побдор по марке авто
Router::connect(
	'/selection/:brand_slug/:model_slug/:generation_slug/:modification_slug',
	array(
		'controller' => 'cars',
		'action' => 'car_view'
	),
	array(
		'pass' => array(
			'brand_slug',
			'model_slug',
			'generation_slug',
			'modification_slug'
		),
		'brand_slug' => '[A-z0-9_-]+',
		'model_slug' => '[A-z0-9_-]+',
		'generation_slug' => '[A-z0-9_-]+',
		'modification_slug' => '[A-z0-9_-]+'
	)
);

// побдор по марке авто - выбор модификации
Router::connect(
	'/selection/:brand_slug/:model_slug/:generation_slug',
	array(
		'controller' => 'car_generations',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'brand_slug',
			'model_slug',
			'generation_slug'
		),
		'brand_slug' => '[A-z0-9_-]+',
		'model_slug' => '[A-z0-9_-]+',
		'generation_slug' => '[A-z0-9_-]+'
	)
);

// побдор по марке авто - выбор года
Router::connect(
	'/selection/:brand_slug/:model_slug',
	array(
		'controller' => 'car_models',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'brand_slug',
			'model_slug'
		),
		'brand_slug' => '[A-z0-9_-]+',
		'model_slug' => '[A-z0-9_-]+'
	)
);

// побдор по марке авто - выбор марки
Router::connect(
	'/selection/:slug',
	array(
		'controller' => 'car_brands',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'slug'
		),
		'slug' => '[A-z0-9_-]+'
	)
);

// побдор по марке авто - выбор бренда
Router::connect(
	'/selection',
	array(
		'controller' => 'car_brands',
		'action' => 'index'
	)
);


// шинно-дисковый калькулятор
Router::connect(
	'/calculator',
	array(
		'controller' => 'pages',
		'action' => 'calculator'
	)
);

// Б/У шина 
Router::connect(
	'/used_tyres/:id',
	array(
		'controller' => 'used_tyres',
		'action' => 'view'
	),
	array(
		'pass' => array(
			'id'
		),
		'id' => '[0-9]+'
	)
);

// Б/У шины 
Router::connect(
	'/used_tyres/*',
	array(
		'controller' => 'used_tyres',
		'action' => 'index'
	)
);

// generate data
Router::connect(
	'/generate',
	array(
		'controller' => 'generate',
		'action' => 'index'
	)
);


// admin route
Router::connect(
	'/admin',
	array(
		'controller' => 'administrators',
		'action' => 'login',
		'prefix' => 'admin',
		'admin' => true
	)
);
// change language for admin
Router::connect(
	'/admin/lang/*',
	array(
		'controller' => 'p28n',
		'action' => 'change',
		'prefix' => 'admin',
		'admin' => true
	)
);
// route for all other admin pages
Router::connect(
	'/admin/:controller/:action',
	array(
		'prefix' => 'admin',
		'admin' => true
	)
);

Router::connect(
    '/selection-modal/:path',
    array(
        'controller' => 'selection_modal',
        'action' => 'car_brands'
    ),
    array(
        'pass' => array(
            'path'
        ),
        'path' => '[A-z0-9_-]+'
    )
);
Router::connect(
    '/selection-modal/:path/:slug',
    array(
        'controller' => 'selection_modal',
        'action' => 'car_models'
    ),
    array(
        'pass' => array(
            'path',
            'slug'
        ),
        'path' => '[A-z0-9_-]+',
        'slug' => '[A-z0-9_-]+'
    )
);
Router::connect(
    '/selection-modal/:path/:brand_slug/:model_slug',
    array(
        'controller' => 'selection_modal',
        'action' => 'car_generation'
    ),
    array(
        'pass' => array(
            'path',
            'brand_slug',
            'model_slug'
        ),
        'path' => '[A-z0-9_-]+',
        'brand_slug' => '[A-z0-9_-]+',
        'model_slug' => '[A-z0-9_-]+'
    )
);
Router::connect(
    '/selection-modal/:path/:brand_slug/:model_slug/:generation_slug',
    array(
        'controller' => 'selection_modal',
        'action' => 'car_modifications'
    ),
    array(
        'pass' => array(
            'path',
            'brand_slug',
            'model_slug',
            'generation_slug'
        ),
        'path' => '[A-z0-9_-]+',
        'brand_slug' => '[A-z0-9_-]+',
        'model_slug' => '[A-z0-9_-]+',
        'generation_slug' => '[A-z0-9_-]+',
    )
);

Router::connect(
    '/api/update_session/:field/:value',
    array(
        'controller' => 'selection_modal',
        'action' => 'update_session'
    ),
    array(
        'pass' => array(
            'field',
            'value'
        ),
        'field' => '[A-z0-9_-]+',
        'value' => '[A-z0-9_-]+',
    )
);

Router::connect(
    '/api/remove_session/:field',
    array(
        'controller' => 'selection_modal',
        'action' => 'update_session'
    ),
    array(
        'pass' => array(
            'field'
        ),
        'field' => '[A-z0-9_-]+'
    )
);

//Router::connect('/*', array('controller' => 'Errors', 'action' => 'error404')); 


CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';