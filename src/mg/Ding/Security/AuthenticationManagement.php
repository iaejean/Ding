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

use Ding\Security\IProviderUser;
use Ding\Security\Exception\SecurityException;
use Ding\Container\IContainerAware;
use Ding\Container\IContainer;
use Ding\Container\Impl\ContainerImpl;


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
class AuthenticationManagement
{
	private $loginAction;
	private $logoutAction;
	private $username;
	private $password;
	private $authenticationFailureUrl;
	private $logoutSuccessUrl;
	private $logoutExpiredSessionUrl;
	private $providerUser;
	private $_container;

	public function setLoginAction($loginAction)
	{
		$this->loginAction = $loginAction;
	}
	
	public function setLogoutAction($logoutAction)
	{
		$this->logoutAction = $logoutAction;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setAuthenticationFailureUrl($authenticationFailureUrl)
	{
		$this->authenticationFailureUrl = $authenticationFailureUrl;
	}

	public function setLogoutSuccessUrl($logoutSuccessUrl)
	{
		$this->logoutSuccessUrl = $logoutSuccessUrl;
	}

	public function setLogoutExpiredSessionUrl($logoutExpiredSessionUrl)
	{
		$this->logoutExpiredSessionUrl = $logoutExpiredSessionUrl;
	}

	public function setProviderUser(IProviderUser $providerUser)
	{
		$this->providerUser = $providerUser;
	}
	
	public function setContainer(IContainer $container)
    {
        $this->_container = $container;
    }
	
	public function authenticate($url, $variables)	
	{
		error_log(print_r($variables,true));
		if($url == $this->loginAction){
		
			$variables = json_decode($variables["usuario"],true);
			
			$user = $this->providerUser->findUser(
				$variables[$this->username], 
				$variables[$this->password]
			);
			
			if(empty($user)){
				throw new SecurityException("User invalid");
				header('Location: ' . $this->authenticationFailureUrl);
			}
				
			$session = $this->_container->getBean("SessionHandler");
			$session->setAttribute("user", $user);			
			
		}
		if($url == $this->logoutAction)
			header('Location: ' . $this->logoutSuccessUrl);
			
		header('Location: ' . $this->logoutSuccessUrl);		
		return true;	
	}
}
