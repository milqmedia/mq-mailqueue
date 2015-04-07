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
 
namespace MQMailQueue\Exception;

use InvalidArgumentException;

class InvalidProviderException
    extends InvalidArgumentException
    implements ExceptionInterface
{
}