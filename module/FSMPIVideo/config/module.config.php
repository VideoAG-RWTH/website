<?php
namespace FSMPIVideo;

function create_admin_navigation($label, $controller, $morePages = array()){
	$navi = array(
		'label' => $label,
		'route' => 'zfcadmin/'.$controller.'/list',
		'pages' => array(
			'create' => array('label' => 'New '.$label,  'route' => 'zfcadmin/'.$controller.'/create'),
			'edit'   => array('label' => 'Edit '.$label, 'route' => 'zfcadmin/'.$controller.'/edit'),
		),
	);
	$navi['pages'] = $morePages + $navi['pages'];
	return $navi;
}

function create_child_route($controller, $moreChildRoutes = array()){
	$config = array(
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
					'route' => '/:id/edit',
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
					'route' => '/:id/delete',
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
	$config['child_routes'] = $moreChildRoutes + $config['child_routes'];
	return $config;
}

/**
 * Route for SuggestedTitles for ListedItems
 */
function create_title_child_route($controller, $parent_parm_name = 'id'){
	return array(
		'type' => 'Segment',
		'options' => array(
	        'route' => '/:'.$parent_parm_name.'[-:alias]/titles',
	        'defaults' => array(
	            'controller' => $controller,
	            'action'     => 'index',
				'alias'      => ''
	        ),
			'constraints' => array(
				$parent_parm_name    => '[0-9]+',
				'alias'    => '[a-zA-Z0-9_-]*',
			),
		),
		'child_routes' => array(
			'list' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/list[/:p]',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'titles',
					),
					'constraints' => array(
						'p'         => '[0-9]*',
					),
				),
			),
			'accept' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/:titleId/accept',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'acceptTitle',
					),
					'constraints' => array(
						'titleId'         => '[0-9]+',
					),
				),
			),
			'decline' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/:titleId/decline',
					'defaults' => array(
						'controller' => $controller,
						'action'     => 'declineTitle',
					),
					'constraints' => array(
						'titleId'         => '[0-9]+',
					),
				),
			),
	    ),
	);
}

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
	                'series' => create_child_route('series', array(
						'titles' => create_title_child_route('series'),
						'events' => array(
						    'type' => 'Segment',
						    'options' => array(
						        'route' => '/:id[-:alias]/events',
						        'defaults' => array(
						            'controller' => 'series',
						            'action'     => 'index',
									'id'         => 0,
									'alias'      => ''
						        ),
								'constraints' => array(
									'id'    => '[0-9]+',
									'alias'    => '[a-zA-Z0-9_-]*',
								),
						    ),
						    'child_routes' => array(
								'titles' => array(
									'type' => 'Segment',
									'options' => array(
								        'route' => '/:eventId[-:eventAlias]/titles',
								        'defaults' => array(
								            'controller' => 'series',
								            'action'     => 'index',
											'eventAlias'      => ''
								        ),
										'constraints' => array(
											'eventId'       => '[0-9]+',
											'eventAlias'    => '[a-zA-Z0-9_-]*',
										),
									),
									'child_routes' => array(
										'list' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/list[/:p]',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'eventTitles',
												),
												'constraints' => array(
													'p'         => '[0-9]*',
												),
											),
										),
										'accept' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/:titleId/accept',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'acceptEventTitle',
												),
												'constraints' => array(
													'titleId'         => '[0-9]+',
												),
											),
										),
										'decline' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/:titleId/decline',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'declineEventTitle',
												),
												'constraints' => array(
													'titleId'         => '[0-9]+',
												),
											),
										),
								    ),
								),
								'markers' => array(
									'type' => 'Segment',
									'options' => array(
								        'route' => '/:eventId[-:eventAlias]/markers',
								        'defaults' => array(
								            'controller' => 'series',
								            'action'     => 'index',
											'eventAlias'      => ''
								        ),
										'constraints' => array(
											'eventId'     => '[0-9]+',
											'eventAlias'  => '[a-zA-Z0-9_-]*',
										),
									),
									'child_routes' => array(
										'list' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/list[/:p]',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'eventMarkers',
												),
												'constraints' => array(
													'p'         => '[0-9]*',
												),
											),
										),
										'accept' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/:markerId/accept',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'acceptEventMarker',
												),
												'constraints' => array(
													'markerId'         => '[0-9]+',
												),
											),
										),
										'decline' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/:markerId/decline',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'declineEventMarker',
												),
												'constraints' => array(
													'markerId'         => '[0-9]+',
												),
											),
										),
								    ),
								),
								'videos' => array(
									'type' => 'Segment',
									'options' => array(
								        'route' => '/:eventId[-:eventAlias]/videos',
								        'defaults' => array(
								            'controller' => 'series',
								            'action'     => 'index',
											'eventAlias'      => ''
								        ),
										'constraints' => array(
											'eventId'     => '[0-9]+',
											'eventAlias'  => '[a-zA-Z0-9_-]*',
										),
									),
									'child_routes' => array(
										'assign' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/:videoId/assign',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'assignEventVideo',
												),
												'constraints' => array(
													'videoId'         => '[0-9]+',
												),
											),
										),
										'unassign' => array(
											'type' => 'Segment',
											'options' => array(
												'route' => '/:videoId/unassign',
												'defaults' => array(
													'controller' => 'series',
													'action'     => 'unassignEventVideo',
												),
												'constraints' => array(
													'videoId'         => '[0-9]+',
												),
											),
										),
								    ),
								),
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
										'route' => '/:eventId[-:eventAlias]/edit',
										'defaults' => array(
											'controller' => 'series',
											'action'     => 'editEvent',
											'eventId'    => 0,
											'eventAlias' => ''
										),
										'constraints' => array(
											'eventId'    => '[0-9]+',
											'eventAlias'    => '[a-zA-Z0-9_-]*',
										),
									),
								),
								'delete' => array(
									'type' => 'Segment',
									'options' => array(
										'route' => '/:eventId[-:eventAlias]/delete',
										'defaults' => array(
											'controller' => 'series',
											'action'     => 'deleteEvent',
											'eventId'    => 0,
											'eventAlias' => ''
										),
										'constraints' => array(
											'eventId'    => '[0-9]+',
											'eventAlias'    => '[a-zA-Z0-9_-]*',
										),
									),
								),
							),
						),
					)),
	                'event' => create_child_route('event', array(
						'titles' => create_title_child_route('event'),
						'markers' => array(
							'type' => 'Segment',
							'options' => array(
						        'route' => '/:id[-:alias]/markers',
						        'defaults' => array(
						            'controller' => 'event',
						            'action'     => 'index',
									'alias'      => ''
						        ),
								'constraints' => array(
									'id'     => '[0-9]+',
									'alias'  => '[a-zA-Z0-9_-]*',
								),
							),
							'child_routes' => array(
								'list' => array(
									'type' => 'Segment',
									'options' => array(
										'route' => '/list[/:p]',
										'defaults' => array(
											'controller' => 'event',
											'action'     => 'markers',
										),
										'constraints' => array(
											'p'         => '[0-9]*',
										),
									),
								),
								'accept' => array(
									'type' => 'Segment',
									'options' => array(
										'route' => '/:markerId/accept',
										'defaults' => array(
											'controller' => 'event',
											'action'     => 'acceptMarker',
										),
										'constraints' => array(
											'markerId'         => '[0-9]+',
										),
									),
								),
								'decline' => array(
									'type' => 'Segment',
									'options' => array(
										'route' => '/:markerId/decline',
										'defaults' => array(
											'controller' => 'event',
											'action'     => 'declineMarker',
										),
										'constraints' => array(
											'markerId'         => '[0-9]+',
										),
									),
								),
						    ),
						),
						'videos' => array(
							'type' => 'Segment',
							'options' => array(
						        'route' => '/:id[-:alias]/videos',
						        'defaults' => array(
						            'controller' => 'event',
						            'action'     => 'index',
									'alias'      => ''
						        ),
								'constraints' => array(
									'id'     => '[0-9]+',
									'alias'  => '[a-zA-Z0-9_-]*',
								),
							),
							'child_routes' => array(
								'assign' => array(
									'type' => 'Segment',
									'options' => array(
										'route' => '/:videoId/assign',
										'defaults' => array(
											'controller' => 'event',
											'action'     => 'assignVideo',
										),
										'constraints' => array(
											'videoId'         => '[0-9]+',
										),
									),
								),
								'unassign' => array(
									'type' => 'Segment',
									'options' => array(
										'route' => '/:videoId/unassign',
										'defaults' => array(
											'controller' => 'event',
											'action'     => 'unassignVideo',
										),
										'constraints' => array(
											'videoId'         => '[0-9]+',
										),
									),
								),
						    ),
						),
					)),
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
			'series' => create_admin_navigation('Series', 'series', array(
				'titles' => array(
					'label' => 'Titles',
					'route' => 'zfcadmin/series/titles/list',
				),
				'events' => array(
					'label' => 'Events',
					'route' => 'zfcadmin/series/events/list',
					'pages' => array(
						'create' => array('label' => 'New Event',  'route' => 'zfcadmin/series/events/create'),
						'edit'   => array('label' => 'Edit Event', 'route' => 'zfcadmin/series/events/edit'),
						'titles' => array('label' => 'Titles',     'route' => 'zfcadmin/series/events/titles/list')
					)
				),
			)),
			'event' => create_admin_navigation('Events', 'event', array(
				'titles' => array( 'label' => 'Titles', 'route' => 'zfcadmin/event/titles/list' ),
			)),
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
