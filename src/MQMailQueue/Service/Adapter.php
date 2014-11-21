<?php

namespace MQMailQueue\Service;

use Application\Service\AbstractService;

class Adapter extends AbstractService
{
	private $SENDER_NAME = array(3 => 'skions.com', 2 => 'wintersporters.nl', 5 => 'wintersporters.be');
	private $SENDER_EMAIL = array(3 => 'info@skions.com', 2 => 'redactie@wintersporters.nl', 5 => 'redactie@wintersporters.nl');
		
	private $devEmails = array('martijn@milq.nl', 'martijn.milq@gmail.com', 'johankuijt@gmail.com');
	
	public function __construct() {
		
		$config = $this->getServiceLocator()->get('application')->getConfig();
		
		var_dump($config);	
	}
	
	public function queueNewMessage($name, $email, $text, $html, $title, $prio = 1) {
		
		$data = array('prio' 			=> $prio,
					  'send' 			=> 0,
					  'recipientName' 	=> $name,
					  'recipientEmail' 	=> $email,
					  'senderName'		=> $this->SENDER_NAME[LANGUAGE_ID],
					  'senderEmail'		=> $this->SENDER_EMAIL[LANGUAGE_ID],
					  'createDate'		=> date('Y-m-d H:i:s'),
					  'subject'			=> $title,
					  'bodyHTML'		=> $html,
					  'bodyText'		=> $text,
					 );
					  
		$this->getConnection()->insert('queue', $data);
	}
	
	public function sendEmailsFromQueue() {
		
		$transport = $this->getServiceLocator()->get('SlmMail\Mail\Transport\SesTransport');
		$queue = $this->fetchAll('SELECT * FROM queue WHERE send = 0 ORDER BY prio, createDate DESC LIMIT 250');
		
		foreach($queue as $mail) {
			
			if(ENVIRONMENT !== 'production' && !in_array($mail['recipientEmail'], $this->devEmails))
				continue;
				
			$message = new \Zend\Mail\Message();			
			
			$message->addFrom($mail['senderEmail'], $mail['senderName'])
	        		->addTo($mail['recipientEmail'], $mail['recipientName'])
					->setSubject($mail['subject']);
					
			if($mail['bodyHTML'] !== '') {
				
				$bodyPart = new \Zend\Mime\Message();

				$bodyMessage = new \Zend\Mime\Part($mail['bodyHTML']);
				$bodyMessage->type = 'text/html';

				$bodyPart->setParts(array($bodyMessage));

				$message->setBody($bodyPart);
				$message->setEncoding('UTF-8');
			
			} else {
				
				$message->setBody($mail['bodyText']);	
			}
			
			try {
			
				$transport->send($message);
				
				$this->getConnection()->update('queue', array('send' => 1, 'sendDate' => date('Y-m-d H:i:s')), array('qId' => $mail['qId']));
					
			} catch(\Exception $e) {
				
				$this->getConnection()->update('queue', array('send' => 2, 'error' => $e->getMessage()), array('qId' => $mail['qId']));
				
				$this->queueNewMessage('Johan', 'johankuijt+kappemailerror@gmail.com', $e->getMessage(), $e->getMessage(), 'Kappe Mail Error', 9);
			}
			
			
		}				
	}
	
	private function getConnection() {
	    
	     $em = $this->getServiceLocator()->get('doctrine.entitymanager.' . $this->getDbConnectionId());
	     $connection = $em->getConnection();
	     
	     return $connection;
    }
}