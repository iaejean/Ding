<?php
/**
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Bean
 * @subpackage Factory.Driver
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
namespace Ding\Security;

/**
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Bean
 * @subpackage Factory.Driver
 * @author     Israel Hernández <iaejeanx@gmail.com>
 * @license    https://gitlab.com/iaejean Apache License 2.0
 * @link       https://gitlab.com/iaejean
 */
interface IProviderUser
{

	public function getRolsUser($user);
	
	public function findUser($user, $password, $status = false);

}