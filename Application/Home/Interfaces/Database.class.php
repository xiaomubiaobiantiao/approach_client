<?php
/**
 * 数据库接口
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */

namespace Home\Interfaces;

interface Database
{

	public function connection();

	public function setParam( $pParams );

	public function exec( $pSql );

	public function fetchConnect( $pResources );


}