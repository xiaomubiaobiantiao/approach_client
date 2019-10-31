<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Supply;

class Supply
{

	private static $classCollection = array(
		'dataExtract' => '\Home\Service\Data\DataExtractService',
		'zip' => '\Home\Common\Utility\PclZipController',
		'xml' => '\Home\Common\Utility\XmlOperationUtility',
		'dataType' => '\Home\Common\Utility\DataTypeUtility',
		'sqlServerData' => '\Home\Common\Data\SqlserverData',
		'mysqlData' => '\Home\Common\Data\MysqlData',
		'oracleData' => '\Home\Common\Data\OracleData'
	);

	public function  __get( $pClassName ) {

		$value = self::$classCollection[$pClassName];

        return isset( $value ) ? self::getInstance( $value ) : null;

    }

	private static function getInstance( $pInstancePath ) {

		return new $pInstancePath;

	}

	// 未完待续
	public function specifiedInstance( $pClassName ) {

		$value = self::$classCollection[$pClassName];
		self::getInstance( $value );

	}

	public function getClassConf( $pInstanceName ) {

		return self::$classCollection;

	}

	private static function in_conf( $className ) {
		return 
	}




}