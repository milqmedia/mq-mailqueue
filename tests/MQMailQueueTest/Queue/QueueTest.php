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

namespace MQMailQueueTest\Queue;

use Heartsentwined\Phpunit\Testcase\Doctrine as DoctrineTestcase;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class AddToQueueTest extends DoctrineTestcase
{    
	protected $em, $tool;
	
	private $mailQueueEntity = 'MQMailQueueTest\Entity\MailQueue';
	
    public function setUp()
    {
        $this
            ->setBootstrap(__DIR__ . '/../../Bootstrap.php')
            ->setEmAlias('doctrine.entitymanager.orm_default');
        	               
        try {
	        parent::setUp();
	        
		} catch(\Exception $e) {}
		
    	$this->setUpSchema();    
    }

    public function tearDown()
    {      	      
	    if($this->em)
	    	$this->em->getConnection()->query('DROP TABLE IF EXISTS test_mailQueue');
	          
        parent::tearDown();
    }

    public function setUpSchema()
    {	    
	    if(!$this->em)
	    	return;
	    	
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
		$classes = array(
		  $this->em->getClassMetadata($this->mailQueueEntity),
		);
		
		$tool->dropSchema($classes);
		$tool->createSchema($classes);
    }
    
    
    public function testCanConstructAdapter()
    {
       	$client = new \MQMailQueue\Service\Adapter($this->sm, $this->em);
        $this->assertInstanceOf('MQMailQueue\Service\Adapter', $client);
    }
    
    public function testCanAddMessageToQueue()
    {
        $client = new \MQMailQueue\Service\Adapter($this->sm, $this->em);
        $entity = $client->queueNewMessage('test name', 'johan@milq.nl', 'test text', '<strong>test html</strong>', 'test title', 1);
        
        $this->assertInstanceOf('MQMailQueueTest\Entity\MailQueue', $entity);
    } 
    
    public function testInvalidRecipientEmailaddress()
    {
	    $this->setExpectedException('\MQMailQueue\Exception\RuntimeException');
	    
        $client = new \MQMailQueue\Service\Adapter($this->sm, $this->em);
        $entity = $client->queueNewMessage('test name', 'test', 'test text', '<strong>test html</strong>', 'test title', 1);     
    } 
	
	public function testSendEmailsFromQueue()
    {   
        $client = new \MQMailQueue\Service\Adapter($this->sm, $this->em);
        $entity = $client->sendEmailsFromQueue();     
    } 
}