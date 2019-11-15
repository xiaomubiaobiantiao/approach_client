<?php
/**
 * 数据库操作扩展
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */

namespace Home\Interfaces;
use Home\Interfaces\Database;

interface DatabasExtension extends Database
{

	public function in_database( $pDataName );

	public function in_table( $pTableName );

	public function in_field( $pTableName, $pFieldName );

	public function addField( $pTableName, $pFieldInfo );

}