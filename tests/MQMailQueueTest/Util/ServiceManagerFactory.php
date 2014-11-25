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

namespace MQMailQueueTest\Util;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

/**
 * Utility used to retrieve a freshly bootstrapped application's service manager
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Marco Pivetta <ocramius@gmail.com>
 */
class ServiceManagerFactory
{
    /**
     * @var array
     */
    protected static $config;

    /**
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        static::$config = $config;
    }

    /**
     * Builds a new service manager
     */
    public static function getServiceManager()
    {
        $serviceManager = new ServiceManager(new ServiceManagerConfig(
            isset(static::$config['service_manager']) ? static::$config['service_manager'] : array()
        ));
        $serviceManager->setService('ApplicationConfig', static::$config);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        return $serviceManager;
    }
}
