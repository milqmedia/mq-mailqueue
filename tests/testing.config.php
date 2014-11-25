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

return array(
    
    'service_manager' => array(
        'factories' => array(              
            'MailQueue' => function($serviceManager) {
	         	return new \MQMailQueue\Service\Adapter($serviceManager, $serviceManager->get('\Doctrine\ORM\EntityManager'));
	        }, 
		),
	),
    'mailqueue' => array(
	    'adminEmail' => '',
	 	'senderName' => '',
	 	'senderEmail' => '', 
	 	'numberOfEmailsPerRun' => 250,  
	 	'database' => array(
		 	'entity' => 'Application\Entity\MailQueue',
	 	),
    ),

    'aws' => array(
        'services' => array(
            'ses' => array(
                'params' => array(
                    'region' => 'us-east-1'
                )
            )
        )
    ),
);