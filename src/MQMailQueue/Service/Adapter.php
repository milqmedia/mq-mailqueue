<?php

namespace MQMailQueue\Service;

class Adapter
{
	private $serviceManager;
	
	private $config;
	
	public function __construct($serviceManager) {
		
		$this->setServiceManager($serviceManager);
		
		$config = $serviceManager->get('application')->getConfig();
		
		if(!isset($config['mailqueue']))
			throw new \Exception('No mailqueue config found.');
			
		$this->config = $config['mailqueue'];
	}
	
	public function queueNewMessage($name, $email, $text, $html, $title, $prio = 1) {
		
		$data = array('prio' 			=> $prio,
					  'send' 			=> 0,
					  'recipientName' 	=> $name,
					  'recipientEmail' 	=> $email,
					  'senderName'		=> $this->config['senderName'],
					  'senderEmail'		=> $this->config['senderEmail'],
					  'createDate'		=> date('Y-m-d H:i:s'),
					  'subject'			=> $title,
					  'bodyHTML'		=> $html,
					  'bodyText'		=> $text,
					 );
					  
		$this->getConnection()->insert('queue', $data);
	}
	
	public function sendEmailsFromQueue() {
		
		$transport = $serviceManager->get('SlmMail\Mail\Transport\SesTransport');
		
		$limit = $this->config['numberOfEmailsPerRun'];
		
		$stmt = $this->execute('SELECT * FROM queue WHERE send = 0 ORDER BY prio, createDate DESC LIMIT ' . $limit);
		$queue = $stmt->fetchAll();
		
		foreach($queue as $mail) {
				
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
				
				$this->queueNewMessage('MailAdmin', $this->config['adminEmail'], $e->getMessage(), $e->getMessage(), 'MailQueue Error', 9);
			}		
		}				
	}
	
	private function getConnection() {
	    
	     $connectionId = $this->config['database']['connectionId'];
	     
	     $em = $this->getServiceManager()->get($connectionId);
	     $connection = $em->getConnection();
	     
	     return $connection;
    }
    
    private function execute($sql, $params = array()) {
	    
	    $connection = $this->getConnection();
	    
	    $stmt = $connection->prepare($sql);
		$stmt->execute($params);
		
		return $stmt;
    }
 
    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager)  
    {  
        $this->serviceManager = $serviceManager;  
        return $this;  
    }  
  
    public function getServiceManager()  
    {  
        return $this->serviceManager;  
    } 
}