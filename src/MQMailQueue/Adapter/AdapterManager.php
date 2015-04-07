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

use Zend\ServiceManager\AbstractPluginManager;

class AdapterManager extends AbstractPluginManager
{
    protected $invokableClasses = array(
       'aws'    => 'MQMailQueue\Adapter\SESAdapter',
       'smtp'    => 'MQMailQueue\Adapter\SMTPAdapter',
    );

    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AdapterInterface) {
            return;
        }

        throw new MQMailQueue\Exception\InvalidAdapterException(sprintf(
            'Adapter of type %s is invalid; ',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}