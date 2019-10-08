<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Think;

use ReflectionClass;

abstract class Container
{


    protected $bindings = array();
    protected $associated = '';
    protected $alias = array();

    abstract public function bind();
    abstract public function make();
    abstract public function makeWith();

    public function _bind( $abstract, $concrete = null ) {

        if ( is_array( $concrete )) {
            count( $concrete ) == count( $concrete, 1 )
                ? $this->bindings[$abstract][$concrete[0]] = $concrete[1]
                : $ccc =$this->bindings[$abstract][$concrete[0]][$concrete[1][0]] = $concrete[1][1];
        } else {
            is_null( $concrete )
                ? $this->bindings[$abstract] = true
                : $this->bindings[$abstract][$concrete] = $concrete;
        }
        
    }

    public function _make( $concrete, $associated = null, $params = null, $bool = false ) {
        
        if ( is_array( $associated ) && false == is_bool( $params ) )
            list( $associated, $params ) = array( $params, $associated );

        if ( is_array( $associated ) && is_bool( $params ) )
            list( $params, $bool, $associated ) = array( $associated, $params, null );      

        $alias = $this->getAllAlias();
        // switch ( func_num_args() || is_null( $associated ) ) {
        switch ( is_null( $associated ) ) {
            case 1:
                if ( $alias[$concrete] ) $concrete = $alias[$concrete];
                break;
            default: 
                if ( $alias[$concrete] && $alias[$associated] )
                    list( $concrete, $associated ) = array( $alias[$concrete], $alias[$associated]);
                break;
        }
        return $this->getInstance( $concrete, $associated, $params, $bool );

    }

    public function _makeWith( $classInstance, $method, $methodAssociated = null, $methodParams = null, $bool = false ) {
        dump( $classInstance );dump( $method );
        if ( is_array( $methodAssociated ) && false == is_bool( $methodParams ) )
            list( $methodParams, $methodAssociated ) = array( $methodAssociated, $methodParams );

        if ( is_array( $methodAssociated ) && is_bool( $methodParams ) )
            list( $methodParams, $bool, $methodAssociated ) = array( $methodAssociated, $methodParams, null );    
       
        $alias = $this->getAllAlias();dump( $alias );
        if ( $alias[$methodAssociated] )
            $methodAssociated = $alias[$methodAssociated];
        $className = $this->reflecterClass( $classInstance );

        $reflecter = new ReflectionClass( $className );
        $reflecterMethod = $reflecter->getMethod( $method );
        $parameters = $reflecterMethod->getParameters();
        foreach ( $parameters as $param ) {
            $class = $param->getClass();dump($class);
            if ( $class ) {
                if ( interface_exists( $class->name ) ) {

                    if ( is_null( $methodAssociated ) )
                        $methodAssociated = $this->searchBindInterface( $className, $class->name, $method );

                    if ( empty( $this->bindings[$class->name][$methodAssociated] ))
                        die( 'not found class, bind abstract or interface please !' );

                    $instance[] = $this->make( $this->bindings[$class->name][$methodAssociated] );
                } else {
                    $instance[] = $this->getInstance( $class->name );
                }
            }
        }
        
        if ( true === array_pop( array_filter( func_get_args())))
            array_unshift( $methodParams, $this );
        
        empty( $instance )
            ? $instance[] = $methodParams
            : array_push( $instance, $methodParams );
    
        return call_user_func_array( array( $classInstance, $method ), $instance );

    }

    public function getInstance( $className, $associated = null, $params = null, $bool = false ) {
        
        if ( false == class_exists( $className )) die( 'Class '.$className.' does not exist' );

        $reflecter = new ReflectionClass( $className );
        
        $constructor = $reflecter->getConstructor();
        
        $instance = array();
        if ( false == $constructor )
            return $reflecter->newInstanceArgs( $instance );
        $parameters = $constructor->getParameters();
        foreach ( $parameters as $param ) {
            $class = $param->getClass();
            if ( $class ) {
                if ( interface_exists( $class->name ) ) {
                    if ( is_null( $associated ) )
                        $associated = $this->searchBindInterface( $className, $class->name );
                    if ( empty( $this->bindings[$class->name][$associated] ))
                        die( 'not found class, bind abstract or interface please !' );
                    $instance[] = $this->make( $this->bindings[$class->name][$associated] );
                } else {
                    $instance[] = $this->getInstance( $class->name );
                }
            } else {
                $classParam[] = $param->name;
            }
        }

        if ( true === array_pop( array_filter( func_get_args())))
            array_unshift( $params, $this );

        array_push( $instance, $params );
        return $reflecter->newInstanceArgs( $instance );
        
    }

    protected function searchBindInterface( $className, $abstract, $methodName = null ) {

        if ( is_null( $methodName ) ) {
            if ( $this->bindings[$className][$abstract] )
                return $this->bindings[$className][$abstract];
        } else {
            if ( $this->bindings[$className][$methodName][$abstract] )
                return $this->bindings[$className][$methodName][$abstract];
        }
        if ( count( $this->bindings[$abstract] ) != 1 ) {
            die( 'getInstance: $this->bindings( '.$abstract.' ) only one Interface OR number 2 parameter bind class Concrete   please !' );
        } 
        return current( $this->bindings[$abstract] );

    }

    protected function bindAbstrcact() {
        // $this->bind( 'abcd' );
        // $this->bind( 'bacddddd', 'sadkfj;sadf' );
    }

    protected function bindAlias() {
        return array(
            // 'IndexController' => 'Controller\IndexController',
            // 'ModelInterface' => 'Interfaces\ModelInterface',
            // 'TestModel' => 'Model\TestModel',
        );
    }

    public function setAlias( $alias, $fullName ) {
        $this->alias[$alias] = $fullName;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function getAllAlias() {
        return array_merge( $this->getAlias(), $this->bindAlias() );
    }

    public function getBinds() {
        return $this->bindings;
    }

    protected function reflecterClass( $class ) {
        $reflecterClass = new ReflectionClass( $class );
        return $reflecterClass->name;
    }




}