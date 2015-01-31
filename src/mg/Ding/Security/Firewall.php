<?php
/**
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Security
 * @subpackage Firewall
 * @author     Israel Hernández <iaejeanx@gmail.com>
 * @license    https://gitlab.com/iaejean Apache License 2.0
 * @link       https://gitlab.com/iaejean
 *
 * Copyright 2014 Israel Hernández <iaejeax@gmail.com>
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


use Ding\Container\IContainerAware;
use Ding\Container\IContainer;
use Ding\Container\Impl\ContainerImpl;
use Ding\Security\Exception\SecurityException;
use Ding\Helpers\ErrorHandler\ErrorInfo;


/**
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Security
 * @subpackage Firewall
 * @author     Israel Hernández <iaejeanx@gmail.com>
 * @license    https://gitlab.com/iaejean Apache License 2.0
 * @link       https://gitlab.com/iaejean
 */
class Firewall implements IContainerAware
{
	static $_instance;
	private $_contianer;
	
	private function __construct(){}
	
	public static function getInstance()
	{
		if(self::$_instance instanceof self)
			return self::$_instance;
		return self::$_instance = new self;
	}
	
	public function setContainer(IContainer $container)
    {
        $this->_container = $container;
    }
		
    /**
	@todo metodo para autenticar...
	public function validate(HttpAction $action, IProviderUser $user, array $rol)
    {
        $container    = ContainerImpl::getInstance();
        $authorizator = $container->getBean('AuthorizatorManagerDefinition');
        $method = $action->getMethod();
        $url  = $action->getId();

        foreach($authorizator->getInterceptUrls() as $key => $val){
            if($url == $val->getPattern()){
                $access = $val->getAccess();
                if(!$this->access())
                    throw new SecurityException("Method no valid");
            }
            break;
        }
    }*/

    public function validateAnnotatedSecure($access, $method)
    {		
        if(!$method){
			header('HTTP/1.1 400 Bad Request');            
			exit(json_encode(array(
				"type" => "Ding\Security\FireWall",
				"code" => "400",
				"file" => __FILE__,
				"line" => __LINE__,
				"time" => date("Y-m-d H:i:s"),
				"message" => "Error de tipo de peticion",
			)));			
		}
			
		$granted = true;
		$access  = explode(",", $access);
        $rols    = array();        				
		
		foreach($access as $key => $val){		
			$val = str_replace(" ", "", $val);		
            if (preg_match("/\(|\)/", $val)){
				preg_match('#\((.*?)\)#', $val, $parameter);
				$method = "(".$parameter[1].")";
				$method = str_replace($method, "", $val);						
				if(!method_exists($this, $method))
					throw new SecurityException("Method not supported");
					
				$granted = $granted && $this->$method($parameter[1]);				
            }else
                array_push($rols, $val);
        }		
		
		if(!empty($rols))
            $granted = $granted && $this->isAllowed($rols);
			
        if(!$granted){
			header('HTTP/1.1 403 Access Denied');            			
			exit(json_encode(array(
				"type" => "Ding\Security\FireWall",
				"code" => "403",
				"file" => __FILE__,
				"line" => __LINE__,
				"time" => date("Y-m-d H:i:s"),
				"message" => "Acceso Denegado",
			)));			
		}
    }

    public function isAllowed(array $listRols)
    {
		$session = $this->_container->getBean('SessionHandler');
		$providerRol = new ProviderRol();
		$providerRol->setProviderUser($this->_container->getBean('ProviderUser'));		
		
		if(!$session->hasAttribute("sessionAuthenticated")){
			header('HTTP/1.1 404 Session Expired');            			
			exit(json_encode(array(
				"type" => "Ding\Security\FireWall",
				"code" => "403",
				"file" => __FILE__,
				"line" => __LINE__,
				"time" => date("Y-m-d H:i:s"),
				"message" => "Session Expirada",
			)));	
		}
			
        $session = $session->getAttribute("sessionAuthenticated");		
		$rols = $providerRol->getRolsUser($session["username"]);
        
		$intersect = array_intersect($rols, $listRols);
		if(empty($intersect))
			return false; 		
			
		return true;
    }

    public function isAuthenticated()
    {
		$session = $this->_container->getBean('SessionHandler');
		return $session->hasAttribute("sessionAuthenticated");
    }

    public function hasIp($ip)
    {
		return ($ip === $_SERVER["REMOTE_ADDR"]);
    }

    public function permitAll()
    {
		return true;
    }

    public function deniedAll()
    {
		return false;
    }
}