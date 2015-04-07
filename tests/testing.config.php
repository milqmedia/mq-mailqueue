<?php
/**
 * MQMailQueue
 * Copyright (c) 2014 Milq Media.
 *
 * @author      Johan Kuijt <johan@milq.nl>
 * @copyright   2014 Milq Media.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://milq.nl
 */

namespace MQMailQueueTest;

return array(

    'mailqueue' => array(
	    'adminEmail' => 'johan@milq.nl',
	 	'senderName' => 'Johan',
	 	'senderEmail' => 'johan@milq.nl', 
	 	'numberOfEmailsPerRun' => 250,  
	 	'database' => array(
		 	'entityManager'		=> 'doctrine.entitymanager.orm_default',
		 	'entity' 			=> 'MQMailQueueTest\Entity\MailQueue',
	 	),
	    'smtp' => array(
			'name' => '<name>',
			'host' => '<host>',
			'port' => 25,
	    ),
    ),
    'aws' => array(
         'key'    				=> '',
         'secret' 				=> '',
         'region' 				=> 'us-east-1'
    ),
    'service_manager' => array(
	    'invokables' => array(
            'MQMailQueue\Adapter\AdapterManager' => 'MQMailQueue\Adapter\AdapterManager',
        ),
        'factories'  => array(
            'MQMailQueue\Service\Adapter' => 'MQMailQueue\Service\AdapterFactory',
        ),
    ),
    'doctrine' => array(
	    'connection' => array(
			'orm_default' => array(
				'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
					'host'     => '127.0.0.1',
					'port'     => '3306',
					'user'     => 'test',
					'password' => '',
					'dbname'   => 'testdb',
					'charset' => 'utf8',
					'driverOptions' => array(
                        1002=>'SET NAMES utf8'
					)
				),				
			),
		),
		'driver' => array(
			__NAMESPACE__ . '_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/' . __NAMESPACE__ . '/Entity')
			),
			'orm_default' => array(
				'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_entities',
				)
			),
		),
	)
);