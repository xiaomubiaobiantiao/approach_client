<?php
/**
 * Xml处理类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

class XmlOperationUtility
{


	public $xml = array();
	public $content = '';

	// 入口函数 1 - 传入文件目录, 匹配 xml 文件, 计算 xml 文件个数
	
	public function _perForm( $pFiles ) {

		$this->xml['list'] = $this->getXmlList( $pFiles );
		$this->xml['xmlCount'] = $this->getXmlCount( $this->xml['list'] );
		$this->xml['xmlGroup'] = $this->xmlType( $this->xml['list'] );
		$this->xml['xmlType'] = array_keys( $this->xml['xmlGroup'] );
		return $this->xml;

	}

	// 入口函数 2 - 传入 xml 文件内容, 解析成数组

	public function _secondPerForm( Pclzip $pZip, $pZipPath ) {

		$list = $this->getFileContent( $pZip, $pZipPath, $this->xml['xmlGroup'] );
		// if ( count( $list ) > 1 ) {
			$contentList = $this->parsXmlArr( $list );
			$arrContentList = $this->xmlCovArr( $contentList );//dump($overList);die();
		// } else {
		// 	$contentList = $this->parsXml( $list );
		// 	$overList = $this->xmlCov( $contentList );
		// }

		return $arrContentList;

	}

	// xml 数据库文件分类

	private function xmlType( $pFiles ) {
		
		foreach ( $pFiles as $key=>$value ) {
			$tmpList = explode( '.', $value );
			$str = $this->cut_str( $tmpList[0], '_', -1 );
			$dataType[$str] = $pFiles[$key];
		}

		return $dataType;

	}


	// 获取压缩包内文件的内容
	
	private function getFileContent( Pclzip $pZip, $pZipPath, $pXmlList ) {

		foreach ( $pXmlList as $key=>$value )
			$xmlContent[$key] = $pZip->getZipFileContent( $pZipPath, $value );

		return $xmlContent;

	}

	// 解析 xml 内容

	public function parsXml( $pXmlContent ) {

		return json_decode( json_encode((array) simplexml_load_string( $pXmlContent )), 1 );

	}

	// 解析多个 xml 内容

	public function parsXmlArr( $pXmlContent ) {

		foreach ( $pXmlContent as $key=>$value )
			$parsArr[$key] = json_decode( json_encode((array) simplexml_load_string( $value )), 1 );
		return $parsArr;

	}

	// 去掉单个 xml 标识符的数组

	public function xmlCov( $pArr ) {

		foreach ( $pArr['table'] as $key=>$value ) {//dump($value);
			foreach ( $value['column'] as $val ) {
				$tmpArr[$value['@attributes']['name']][$val['@attributes']['cname']] = $val['@attributes'];
			}
		}
		return $tmpArr;

	}

	// 去掉多个 xml 文件中的 xml 标识符的数组

	public function xmlCovArr( $pArr ) {

		foreach ( $pArr as $key=>$value )
			$tmpArr[$key] = $this->xmlCov( $value );

		return $tmpArr;

	}

	// 获取 xml 文件数目

	public function getXmlCount( $pXmlList ) {

		return count( $pXmlList );

	}

	// 获取 xml 文件列表
	
	public function getXmlList( $pArr ) {

		$list = array_map( 'reset', $pArr );
		return array_filter( array_map( array( $this, 'xmlCallback'), $list));

	}

	// getXmlList 的回调函数
	
	private function xmlCallback( $pVar ) {

		if ( strpos( $pVar, 'Database' ) !== false && 'xml' == end( explode( '.', $pVar )))
			return $pVar;

	}

	/**
	 * 按符号截取字符串的指定部分
	 * @param string $str 需要截取的字符串
	 * @param string $sign 需要截取的符号
	 * @param int $number 如是正数以0为起点从左向右截  负数则从右向左截
	 * @return string 返回截取的内容
	 */
	public function cut_str( $str, $sign, $number ){

	    $array = explode( $sign, $str );
	    $length = count( $array );

	    if( $number < 0 ){
	        $new_array = array_reverse( $array );
	        $abs_number = abs( $number );
	        return $abs_number > $length ? 'error' : $new_array[$abs_number-1];
	    }

	    return $number >= $length ? 'error' : $array[$number];
	}


}