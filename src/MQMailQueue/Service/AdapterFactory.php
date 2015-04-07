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
 
namespace MQMailQueue\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdapterFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config 		= $serviceLocator->get('config');
        
        $entityManager =  $serviceLocator->get($config['mailqueue']['database']['entityManager']);       
        $adapterManager = $serviceLocator->get('MQMailQueue\Adapter\AdapterManager');

        $adapter = $adapterManager->get($config['mailqueue']['adapter']);
        $adapter->initialize($config, $serviceLocator, $entityManager);

        return $adapter;
    }
}