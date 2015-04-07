<?php
/**
 * MQMailQueue
 * Copyright (c) 2015 Milq Media.
 *
 * @author      Johan Kuijt <johan@milq.nl>
 * @copyright   2015 Milq Media.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://milq.nl
 */
 
namespace MQMailQueue\Adapter;

interface AdapterInterface
{
	public function initialize(array $config, \Zend\ServiceManager\ServiceManager $serviceManager, \Doctrine\ORM\EntityManager $entityManager);	
		
	public function queueNewMessage($name, $email, $text, $html, $title, $prio = 1);
		
	public function sendEmailsFromQueue();
}