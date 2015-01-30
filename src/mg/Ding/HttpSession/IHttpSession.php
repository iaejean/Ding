<?php
/**
 * Http session Interface.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Mvc
 * @subpackage Http
 * @author     Israel Hernández <iaejeanx@gmail.com>
 * @license    https://gitlab.com/iaejean Apache License 2.0
 * @link       https://gitlab.com/iaejean
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
namespace Ding\HttpSession;

/**
 * Http session Interface.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Mvc
 * @subpackage Http
 * @author     Israel Hernández <iaejeanx@gmail.com>
 * @license    https://gitlab.com/iaejean Apache License 2.0
 * @link       https://gitlab.com/iaejean
 */
interface IHttpSession
{
    /**
     * Destroys the current session.
     *
     * @return void
     */
    public function destroy();

    /**
     * Returns true if this session contains this attribute.
     *
     * @param string $name
     *
     * @return boolean
     */
    public function hasAttribute($name);
	
    /**
     * Returns a previously saved session attribute with setAttribute().
     *
     * @param string $name Session attribute name.
     *
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Saves an attribute to the session.
     *
     * @param string $name  Session attribute name.
     * @param mixed  $value Value.
     *
     * @return void
     */
    public function setAttribute($name, $value);
}