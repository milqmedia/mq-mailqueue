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
 
namespace MQMailQueue\Service;

use \MQMailQueue\Exception\RuntimeException;

class Adapter
{
	private $serviceManager;
	private $entityManager;
	private $config;
	
	public function __construct(\Zend\ServiceManager\ServiceManager $serviceManager, \Doctrine\ORM\EntityManager $entityManager) {
		
		$this->serviceManager = $serviceManager;
		$this->entityManager = $entityManager;
		
		$config = $this->serviceManager->get('application')->getConfig();
		
		if(!isset($config['mailqueue']))
			throw new RuntimeException('No mailqueue config found.');
			
		$this->config = $config['mailqueue'];
	}
	
	public function queueNewMessage($name, $email, $text, $html, $title, $prio = 1) {
	
		if(!isset($this->config['database']['entity']))
			throw new RuntimeException('No queue entity defined in the configuration.');
		
		$entityName = $this->config['database']['entity'];	
		$entity = new $entityName($this->entityManager);    	
	    
	    $entity->setPrio(intval($prio));
	    $entity->setSend(0);
	    $entity->setRecipientName((string) $name);
	    $entity->setRecipientEmail((string) $email);
	    $entity->setSenderName((string) $this->config['senderName']);
	    $entity->setSenderEmail((string) $this->config['senderEmail']);
	    $entity->setSubject((string) $title);
	    $entity->setBodyHTML((string) $html);
	    $entity->setBodyText((string) $text);
	    
	    $entity->setCreateDate(new \DateTime());
    	  
    	$this->entityManager->persist($entity);    	
   		$this->entityManager->flush();

    	return $entity;
	}
	
	public function sendEmailsFromQueue() {
		
		$transport = $this->serviceManager->get('SlmMail\Mail\Transport\SesTransport');

	    $dql = 'SELECT m FROM ' . $this->config['database']['entity'] . ' m WHERE m.send = 0 ORDER BY m.prio, m.createDate DESC';

	    $query = $this->entityManager->createQuery($dql)
					        		->setMaxResults($this->config['numberOfEmailsPerRun']);
	    $queue = $query->getResult();
	    
		foreach($queue as $mail) {

			$message = new \Zend\Mail\Message();			
			
			$message->addFrom($mail->getSenderEmail(), $mail->getSenderName())
	        		->addTo($mail->getRecipientEmail(), $mail->getRecipientName())
					->setSubject($mail->getSubject());
					
			if(trim($mail->getBodyHTML()) !== '') {
				
				$bodyPart = new \Zend\Mime\Message();

				$bodyMessage = new \Zend\Mime\Part($mail->getBodyHTML());
				$bodyMessage->type = 'text/html';

				$bodyPart->setParts(array($bodyMessage));

				$message->setBody($bodyPart);
				$message->setEncoding('UTF-8');
			
			} else {
				
				$message->setBody($mail->getBodyText());	
			}
			
			try {
			
				$transport->send($message);
				
				$this->entityManager->getConnection()->update('mailQueue', array('send' => 1, 'sendDate' => date('Y-m-d H:i:s')), array('id' => $mail->getId()));
					
			} catch(\Exception $e) {
				
				$this->entityManager->getConnection()->update('mailQueue', array('send' => 2, 'error' => $e->getMessage()), array('id' => $mail->getId()));
				
				$this->queueNewMessage('MailAdmin', $this->config['adminEmail'], $e->getMessage(), $e->getMessage(), 'MailQueue Error', 9);
			}		
		}				
	}
}