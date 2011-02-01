<?php
/**
 * This is a bean that will call your own shutdown handler (only if it
 * implements IShutdownHandler).
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Helpers
 * @subpackage ShutdownHandler
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
namespace Ding\Helpers\ShutdownHandler;

/**
 * This is a bean that will call your own shutdown handler (only if it
 * implements IShutdownHandler).
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Helpers
 * @subpackage ShutdownHandler
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class ShutdownHandlerHelper
{
    /**
     * log4php logger or our own.
     * @var Logger
     */
    private $_logger;

    /**
     * Shutdown handler to call.
     * @var IShutdownHandler
     */
    private $_handler;

    /**
     * Set a handler to call upon shutdown.
     *
     * @param IShutdownHandler $handler Handler to call.
     *
     * @return void
     */
    public function setShutdownHandler(IShutdownHandler $handler)
    {
        $this->_handler = $handler;
    }

    /**
     * This was set by register_shutdown_function.
     *
     * @return void
     */
    public function handle()
    {
        $this->_handler->handleShutdown();
    }

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_logger = \Logger::getLogger('Ding.ShutdownHandlerHelper');
    }
}