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
		$this->xml['xmlType'] = $this->xmlType( $this->xml['list'] );
		return $this->xml;

	}

	// 第二入口函数 2 - 传入 xml 文件内容, 解析成数组

	public function _secondPerForm( Pclzip $pZip, $pZipPath, $xmlList = '' ) {

		if ( empty( $xmlList )) $xmlList = $this->xml['list'];
		
		$list = $this->getFileContent( $pZip, $pZipPath, $xmlList );
		// dump( $list );


		// return $this->getFileContent( $pZip, $pZipPath, $this->xmlCovArr( $this->parsXml( $pXmlContent )));

	}

	// xml 数据库文件分类

	private function xmlType( $pFiles ) {
		foreach ( $pFiles as $key=>$value ) {
			$list = explode( '.', $value );
			$str = substr( $list[0], -1 );
			$dataType[$str][] = $pFiles[$key];
		}
		return $dataType;
	}


	// 获取压缩包内文件的内容
	
	private function getFileContent( Pclzip $pZip, $pZipPath, $pXmlList ) {

		foreach ( $pXmlList as $value )
			$xmlContent = $pZip->getZipFileContent( $pZipPath, $value );

		return $xmlContent;

	}

	// 解析 xml 内容

	public function parsXml( $pXmlContent ) {

		return json_decode( json_encode((array) simplexml_load_string( $pXmlContent )), 1 );

	}

	// 去掉 xml 标识符的数组

	public function xmlCovArr( $pArr ) {
		foreach ( $pArr['table'] as $key=>$value ) {
			// $name[] = $value['@attributes']['name'];
			foreach ( $value['column'] as $val ) {
				// dump( $val['@attributes'] );
				$tmpArr[$value['@attributes']['name']][] = $val['@attributes'];
			}
		}
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


}