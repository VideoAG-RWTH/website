<?php
namespace FSMPIVideo;

function create_admin_navigation($label, $controller){
	return array(
		'label' => $label,
		'route' => 'zfcadmin/'.$controller.'/list',
		'pages' => array(
			'create' => array('label' => 'New '.$label,  'route' => 'zfcadmin/'.$controller.'/create'),
			'edit'   => array('label' => 'Edit '.$label, 'route' => 'zfcadmin/'.$controller.'/edit'),
		),
	);
}

function create_child_route($controller){
	return array(
        'type' => 'Literal',
        'options' => array(
            'route' => '/'.$controller,
            'defaults' => array(
                'controller' => $controller,
                'action'     => 'index',
            ),
        ),
        'child_routes' => array(
			'list' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/list[/:p]',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'list',
					),
					'constraints' => array(
						'p'         => '[0-9]*',
					),
				),
			),
			'create' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/create',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'create'
					),
				),
			),
			'edit' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/edit/:id',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'edit',
						'id'     => 0
					),
					'constraints' => array(
						'id'         => '[0-9]+',
					),
				),
			),
			'delete' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/delete/:id',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'delete',
						'id'     => 0
					),
					'constraints' => array(
						'id'         => '[0-9]+',
					),
				),
			),
		),
    );	
}

$seriesRoute = create_child_route('series');
$seriesRoute['child_routes']['events'] = array(
    'type' => 'Segment',
    'options' => array(
        'route' => '/events/:id',
        'defaults' => array(
            'controller' => 'series',
            'action'     => 'index',
			'id'         => 0
        ),
		'constraints' => array(
			'id'    => '[0-9]+',
		),
    ),
    'child_routes' => array(
		'list' => array(
			'type' => 'Segment',
			'options' => array(
				'route' => '/list[/:p]',
				'defaults' => array(
					'controller' => 'series',
					'action'     => 'events',
				),
				'constraints' => array(
					'p'         => '[0-9]*',
				),
			),
		),
		'create' => array(
			'type' => 'Literal',
			'options' => array(
				'route' => '/create',
				'defaults' => array(
					'controller' => 'series',
					'action'     => 'createEvent'
				),
			),
		),
		'edit' => array(
			'type' => 'Segment',
			'options' => array(
				'route' => '/edit/:eventId',
				'defaults' => array(
					'controller' => 'series',
					'action'     => 'editEvent',
					'eventId'    => 0
				),
				'constraints' => array(
					'eventId'    => '[0-9]+',
				),
			),
		),
		'delete' => array(
			'type' => 'Segment',
			'options' => array(
				'route' => '/delete/:eventId',
				'defaults' => array(
					'controller' => 'series',
					'action'     => 'deleteEvent',
					'eventId'    => 0
				),
				'constraints' => array(
					'eventId'    => '[0-9]+',
				),
			),
		),
	),
);

return array(
	'controllers' => array(
		'invokables' => array(
			'FSMPIVideo\Controller\Index' => 'FSMPIVideo\Controller\IndexController',
			'course' => 'FSMPIVideo\Controller\CourseController',
			'coursetype' => 'FSMPIVideo\Controller\CourseTypeController',
			'coursehost' => 'FSMPIVideo\Controller\CourseHostController',
			'lecturer' => 'FSMPIVideo\Controller\LecturerController',
			'videoquality' => 'FSMPIVideo\Controller\VideoQualityController',
			'suggestedtitle' => 'FSMPIVideo\Controller\SuggestedTitleController',
			'listeditem' => 'FSMPIVideo\Controller\ListedItemController',
			'series' => 'FSMPIVideo\Controller\SeriesController',
			'event' => 'FSMPIVideo\Controller\EventController',
		),
	),
	
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'controller' => 'FSMPIVideo\Controller\Index',
						'action'     => 'index',
					),
				),
			),
			'zfcadmin' => array(
				'child_routes' => array(
	                'course' => create_child_route('course'),
	                'coursetype' => create_child_route('coursetype'),
	                'coursehost' => create_child_route('coursehost'),
	                'lecturer' => create_child_route('lecturer'),
	                'videoquality' => create_child_route('videoquality'),
	                'suggestedtitle' => create_child_route('suggestedtitle'),
	                'listeditem' => create_child_route('listeditem'),
	                'series' => $seriesRoute,
	                'event' => create_child_route('event'),
				),
			),
		),
	),
	
	
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
	
    'translator' => array(
        'locale' => 'de_DE',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
	
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'fsmpivideo/index/index'  => __DIR__ . '/../view/fsmpi-video/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
	
	

	'navigation' => array(
		'default' => array(
			array('label' => 'VIDEOS',   'route' => 'home'),
			array('label' => 'FSMPI',    'route' => 'home'),
			array('label' => 'VAMPIR',   'route' => 'home')
		),
		'admin' => array(
			'course' => create_admin_navigation('Course', 'course'),
			'coursetype' => create_admin_navigation('CourseType', 'coursetype'),
			'coursehost' => create_admin_navigation('CourseHost', 'coursehost'),
			'lecturer' => create_admin_navigation('Lecturer', 'lecturer'),
			'videoquality' => create_admin_navigation('VideoQuality', 'videoquality'),
			'suggestedtitle' => create_admin_navigation('SuggestedTitle', 'suggestedtitle'),
			'series' => create_admin_navigation('Series', 'series'),
			'event' => create_admin_navigation('Events', 'event'),
		),
	),

	
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				)
			)
		)
	),

);
