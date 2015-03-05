<?php

return array(
    'aws' => array(
         'key'    				=> '<aws-key>',
         'secret' 				=> '<aws-region>',
         'region' 				=> '<aws-region>'
    ),
    'mailqueue' => array(
	    'adminEmail' 			=> '',
	 	'senderName' 			=> '',
	 	'senderEmail' 			=> '', 
	 	'numberOfEmailsPerRun' 	=> 250,  
	 	'database' => array(
		 	'entity' 			=> 'Application\Entity\MailQueue',
	 	),
    ),
);