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

use PHPUnit_Framework_TestCase;
use MQMailQueueTest\Util\ServiceManagerFactory;

class AddToQueueTest extends PHPUnit_Framework_TestCase
{
    public function testCanConstructAdapter()
    {
        $client = ServiceManagerFactory::getServiceManager()->get('MailQueue');
        $this->assertInstanceOf('MQMailQueue\Service\Adapter', $client);
    }   
}