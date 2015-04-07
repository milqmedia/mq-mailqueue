<?php

return array(
    'mailqueue' => array(
	    'adminEmail' 			=> '',
	 	'senderName' 			=> '',
	 	'senderEmail' 			=> '', 
	 	'numberOfEmailsPerRun' 	=> 250,  
	 	'database' => array(
		 	'entityManager'		=> 'doctrine.entitymanager.orm_default',
		 	'entity' 			=> 'Application\Entity\MailQueue',
	 	),
	 	'adapter'				=> 'aws',
	    'stmp' => array(
			'name' => '<name>',
			'host' => '<host>',
			'port' => 25,
	    ),
    ),
    'aws' => array(
         'key'    				=> '<aws-key>',
         'secret' 				=> '<aws-region>',
         'region' 				=> '<aws-region>'
    ),
    'service_manager' => array(
	    'invokables' => array(
            'MQMailQueue\Adapter\AdapterManager' => 'MQMailQueue\Adapter\AdapterManager',
        ),
        'factories'  => array(
            'MQMailQueue\Service\Adapter' => 'MQMailQueue\Service\AdapterFactory',
        ),
    ),
);