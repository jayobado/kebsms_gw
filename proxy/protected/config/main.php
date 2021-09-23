<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SMS SYSTEM',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'jibu',
		 	// If removed, Gii defaults to 192.168.0.6 only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
        'sms' => array(
            'connectionString' => 'mysql:host=localhost;dbname=sms',
            'tablePrefix' => '',
            'username'  => 'kebs',
            'password'=>'kebs12',
        	'class' => 'CDbConnection'
        ),

        'adtel' => array(
            'connectionString' => 'mysql:host=ivr.ad-tel.com;dbname=db_20023',
            'username'  => '20023',
            'password'=>'20@23#',
        	'class'=> 'CDbConnection'
        ),
            
        'ism' => array(
        	'connectionString' => 'dblib:host=197.156.138.250;dbname=KEBS',
           	'username'  => 'sms',
           	'password'=>'Kebs*sms2015',
        	'class'=> 'CDbConnection',
        	'charset' => 'UTF8',
        ),
		
        'saved'=>array(
          	'connectionString' => 'mysql:host=localhost;dbname=saved',
            'emulatePrepare' => true,
            'username' => 'kebs',
            'password' => 'db@KEBS123*',
            'charset' => 'utf8',
            'class' => 'CDbConnection'
        ),
		
		'sdp'=>array(
			'connectionString' => 'mysql:host=45.56.99.66;dbname=kebs',
            'emulatePrepare' => true,               
			'username' => 'sms',
			'password' => 'jibusms*',
            'charset' => 'utf8',
            'class' => 'CDbConnection'
                         
		),

		'kebsDb' => array(
			'connectionString' => 'mysql:host=10.10.1.241;dbname=smbs',
			'username'  => 'jibutel',
			'password'=>'jibutelsms*',
			'class'=>'CDbConnection'
		),

		'employee'=>array(
		// 'connectionString' => 'mssql:host=KEBS-NBIDC34\SQLExpress;database=KEBSPSA;',
			'connectionString' => 'sqlsrv:Server=10.10.0.136;Database=KEBSPSA;',
			'username' => 'sa',
			"password" => 'P@$$w0rd',
			'charset' => 'utf8',
			'class'=> 'CDbConnection'
		),

		'motor'=>array(
		//'connectionString' => 'mssql:host=KEBS-NBIDC11\SQLExpress;database=MotorVehicle;',
			'connectionString' => 'sqlsrv:Server=KEBS-NBIDC9\SQLExpress;Database=MotorVehicle;',
			'username' => 'sa',
			'password' => 'kebs@gari2o16',
			'charset' => 'utf8',
			'class'=> 'CDbConnection'
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
