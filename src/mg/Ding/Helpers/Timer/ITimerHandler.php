<?php
/**
 * Timer handler interface. Implement this one in your own handler.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Helpers
 * @subpackage Timer
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
namespace Ding\Helpers\Timer;

/**
 * Timer handler interface. Implement this one in your own handler.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Helpers
 * @subpackage Timer
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
interface ITimerHandler
{
    /**
     * Called when the timer expires.
     *
     * @return void
     */
    public function handleTimer();
}