<?php
/**
 * Bean Definition.
 *
 * PHP Version 5
 *
 * @category Ding
 * @package  Bean
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace Ding\Bean;

use Ding\Bean\BeanAnnotationDefinition;

/**
 * Bean Definition.
 *
 * PHP Version 5
 *
 * @category Ding
 * @package  Bean
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
class BeanDefinition
{
    /**
     * Specifies scope prototype for beans, meaning that a new instance will
     * be returned every time.
     * @var integer
     */
    const BEAN_PROTOTYPE = 0;
    
    /**
     * Specifies scope singleton for beans, meaning that the same instance will
     * be returned every time.
     * @var integer
     */
    const BEAN_SINGLETON = 1;
    
    /**
     * Bean name
     * @var string
     */
    private $_name;

    /**
     * Bean class name.
     * @var string
     */
    private $_class;

    /**
     * Bean type (scope). See this class constants.
     * @var integer
     */
    private $_scope;

    /**
     * Properties to be di'ed to this bean.
     * @var BeanPropertyDefinition[]
     */
    private $_properties;

    /**
     * Aspects mapped to this bean.
     * @var AspectDefinition[]
     */
    private $_aspects;
    
    /**
     * Constructor arguments.
     * @var BeanConstructorArgumentDefinition[]
     */
    private $_constructorArgs;

    /**
     * Factory method name (if any). 
     * @var string
     */
    private $_factoryMethod;

    /**
     * Factory bean name (if any). 
     * @var string
     */
    private $_factoryBean;
    
    /**
     * Init method (if any).
     * @var string
     */
    private $_initMethod;
    
    /**
     * Destroy method (called when container is destroyed).
     * @var string
     */
    private $_destroyMethod;

    /**
     * Annotations for this bean.
     * @var BeanAnnotationDefinition[]
     */
    private $_annotations;
    
    /**
     * Annotations for this bean methods.
     * @var BeanAnnotationDefinition[]
     */
    private $_methodAnnotations;
    
    /**
     * Dependency beans literally specified in the configuration.
     * @var string[]
     */
    private $_dependsOn;

    /**
     * This will annotated this bean with the given annotation.
     *
     * @param BeanAnnotationDefinition $annotation Annotation.
     * @param string                   $method     Optional method name.
     * 
     * @return void
     */
    public function annotate(BeanAnnotationDefinition $annotation, $method = false)
    {
        $name = $annotation->getName();
        if ($method === false) {
            if (!isset($this->_annotations[$name])) {
                $this->_annotations[$name] = array();
            }
            $this->_annotations[$name][] = $annotation;
        } else {
            if (!isset($this->_methodAnnotations[$method][$name])) {
                $this->_methodAnnotations[$method][$name] = array();
            }
            $this->_methodAnnotations[$method][$name][] = $annotation;
        }
    }
    
    /**
     * Returns all annotations under the given name.
     *
     * @param string $name   Annotation name.
     * @param string $method Optional method name.
     * 
     * @return BeanAnnotationDefinition[]
     */
    public function getAnnotation($name, $method = false)
    {
        if ($method === false && $this->isAnnotated($name)) {
            return $this->_annotations[$name];
        } else if ($this->isAnnotated($name, $method)) {
            return $this->_methodAnnotations[$method][$name];
        }
        return false;
    }

    /**
     * Returns all annotations as an array indexed by annotation value.
     *
     * @param string $method Optional method name.
     * 
     * @return BeanAnnotationDefinition[string][]
     */
    public function getAnnotations($method = false)
    {
        if ($method === false) {
            return $this->_annotations;
        } else {
            return isset($this->_methodAnnotations[$method]);
        }
    }
    
    /**
     * Returns true if this bean is annotated with the given annotation name.
     *
     * @param string $name   Annotation name to check for.
     * @param string $method Optional method name.
     * 
     * @return boolean
     */
    public function isAnnotated($name, $method = false)
    {
        if ($method === false) {
            return isset($this->_annotations[$name]);
        } else {
            return isset($this->_methodAnnotations[$method][$name]);
        }
    }
    
    /**
     * Returns true if this bean has mapped aspects.
     * 
     * @return boolean
     */
    public function hasAspects()
    {
        return count($this->getAspects()) > 0;
    }
    
    /**
     * Sets new aspects for this bean.
     *
     * @param BeanAspectDefinition[] $aspects New aspects.
     * 
     * @return void
     */
    public function setAspects(array $aspects)
    {
        $this->_aspects = $aspects;
    }
    
    /**
     * Returns aspects for this bean.
     * 
     * @return AspectDefinition[]
     */
    public function getAspects()
    {
        return $this->_aspects;
    }
    
    /**
     * Changes the scope for this bean.
     *
     * @param string $scope New scope.
     * 
     * @return void
     */
    public function setScope($scope)
    {
        $this->_scope = $scope;
    }
    
    /**
     * Returns bean type (scope). See this class constants.
     * 
     * @return integer
     */
    public function getScope()
    {
        return $this->_scope;
    }
    
    /**
     * Sets a new name for this bean.
     *
     * @param string $name New name.
     * 
     * @return void
     */
    public function setName($name)
    {
        $this->_name = $name;
    }
    
    /**
     * Returns bean name.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets a new class name for this bean.
     *
     * @param string $class New class name.
     * 
     * @return void
     */
    public function setClass($class)
    {
        $this->_class = $class;
    }
    
    /**
     * Returns bean class.
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * Sets new properties for this bean.
     *
     * @param BeanPropertyDefinition[] $properties New properties.
     * 
     * @return void
     */
    public function setProperties(array $properties)
    {
        $this->_properties = $properties;
    }
    
    /**
     * Returns properties for this bean.
     * 
     * @return BeanPropertyDefinition[]
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * Sets new arguments for this bean.
     *
     * @param BeanConstructorDefinition[] $arguments New arguments.
     * 
     * @return void
     */
    public function setArguments(array $arguments)
    {
        $this->_constructorArguments = $arguments;
    }
    
    /**
     * Returns arguments for this bean.
     * 
     * @return BeanConstructorArgumentDefinition[]
     */
    public function getArguments()
    {
        return $this->_constructorArgs;
    }
    
    /**
     * Sets a new factory method for this bean.
     *
     * @param string $factoryMethod New factory method.
     * 
     * @return void
     */
    public function setFactoryMethod($factoryMethod)
    {
        $this->_factoryMethod = $factoryMethod;
    }
    /**
     * Factory method, false if none was set.
     * 
     * @return string
     */
    public function getFactoryMethod()
    {
        return $this->_factoryMethod;
    }

    /**
     * Sets a new factory bean for this bean.
     *
     * @param string $factoryBean New factory bean.
     * 
     * @return void
     */
    public function setFactoryBean($factoryBean)
    {
        $this->_factoryBean = $factoryBean;
    }
    
    /**
     * Factory bean, false if none was set.
     * 
     * @return string
     */
    public function getFactoryBean()
    {
        return $this->_factoryBean;
    }

    /**
     * Sets a new init method for this bean.
     *
     * @param string $initMethod New init method.
     * 
     * @return void
     */
    public function setInitMethod($initMethod)
    {
        $this->_initMethod = $initMethod;
    }
    
    /**
     * Init method, false if none was set.
     * 
     * @return string
     */
    public function getInitMethod()
    {
        return $this->_initMethod;
    }

    /**
     * Sets a new destroy method for this bean.
     *
     * @param string $destroyMethod New destroy method.
     * 
     * @return void
     */
    public function setDestroyMethod($destroyMethod)
    {
        $this->_destroyMethod = $destroyMethod;
    }
    
    /**
     * Destroy method, false if none was set.
     * 
     * @return string
     */
    public function getDestroyMethod()
    {
        return $this->_destroyMethod;
    }

    /**
     * Returns all beans marked as dependencies for this bean.
     *
     * @return string[]
     */
    public function getDependsOn()
    {
        return $this->_dependsOn;
    }
    
    /**
     * Set bean dependencies.
	 *
     * @param string[] $dependsOn Dependencies (bean names).
     * 
     * @return void
     */
    public function setDependsOn(array $dependsOn)
    {
        $this->_dependsOn = $dependsOn;
    }
    
    /**
     * Constructor.
     * 
     * @param string                   $name          Bean name.
     * @param string                   $class         Bean class.
     * @param integer                  $scope         Bean type (scope). See
     * this class constants.
     * @param string                   $factoryMethod Factory method name or
     * false.
     * @param string                   $factoryBean   Factory bean name or
     * false.
     * @param string                   $initMethod    Init method.
     * @param string                   $destroyMethod Destroy method.
     * @param string[]                 $dependsOn     Dependency beans.
     * @param BeanPropertyDefinition[] $properties    Bean properties
     * definitions.
     * @param AspectDefinition[]       $aspects       Aspects definitions.
     * @param BeanConstructorArgumentDefinition[] $arguments Constructor args.
     * 
     * @return void
     */
    public function __construct(
        $name, $class, $scope, $factoryMethod, $factoryBean, $initMethod,
        $destroyMethod, array $dependsOn,
        array $properties, array $aspects, array $arguments
    ) {
        $this->_name = $name;
        $this->_class = $class;
        $this->_scope = $scope;
        $this->_factoryMethod = $factoryMethod;
        $this->_factoryBean = $factoryBean;
        $this->_initMethod = $initMethod;
        $this->_destroyMethod = $destroyMethod;
        $this->_dependsOn = $dependsOn;
        $this->_properties = $properties;
        $this->_aspects = $aspects;
        $this->_constructorArgs = $arguments;
    }
}
