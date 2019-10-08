<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Think;

use Think\Container;

class ChildrenUtility extends Container
{

	public function __construct() {
		$this->bindAbstrcact();
	}

	public function bind( $abstract = null, $concrete = null ) {
		return $this->_bind( $abstract, $concrete );
	}

	public function make( $concrete = null, $associated = null, $params = null, $bool = false ) {
		return $this->_make( $concrete, $associated, $params, $bool );
	}

	public function makeWith( $classInstance = null, $method = null, $methodAssociated = null, $methodParams = null, $bool = false ) {
		return $this->_makeWith( $classInstance, $method, $methodAssociated, $methodParams, $bool );
	}

	public function bindAlias() {
        return array(
            'SqlserverData' => 'Home\Common\Data\SqlserverData',
            'MysqlData' => 'Home\Common\Data\MysqlData',
            'OracleData' => 'Home\Common\Data\OracleData',

            'DataType' => 'Home\Common\Utility\DataTypeUtility',
            'DataService' => 'Home\Service\Data\DataService',
            'UpdateData' => 'Home\Controller\UpdateDataController',

            'Index' => 'Home\Controller\IndexController',
            'Update' => 'Home\Controller\UpdateController',
            'Common' => 'Home\Controller\CommonController',
        );
    }

    protected function bindAbstrcact() {
    	$this->bind( 'Home\Interfaces\Database', 'Home\Common\Data\SqlserverData' );
    	$this->bind( 'Home\Interfaces\Database', 'Home\Common\Data\MysqlData' );
    	$this->bind( 'Home\Interfaces\Database', 'Home\Common\Data\OracleData' );
    }


}