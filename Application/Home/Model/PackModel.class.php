<?php
/**
 * 文本转换数据模型类 - 此类未真正继承 Model 模型(只是模拟), 用法与普通类一致
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Model;

class PackModel
{

	//全部数据
	private $data = array();

	//每次创建一个此类(new)初始化一次数据库(将文本转换成数组赋值给data)
	public function __construct() {
		$this->data = $this->textToData();
	}

	//获取全部数据 并按时间从大到小排序
	public function getData() {
		return $this->orderByData( $this->data );
	}

	//获取有本地压缩包的数据(已下载的) 并 分类
	public function getTrueData() {
		foreach ( $this->data as $value ) {
			if ( $value['status'] == 1 )
				$data[$value['type']][] = $value;
		}
		$result = $this->orderByData( $data );
		return $result;
	}

	//生成更新包类型列表
	public function systemTypeList() {
		$num = array();
		$data = array();
		foreach ( $this->data as $key=>$value ) {
			if ( $key == 0 ) {
				$num[] = $value['type'];
				$data[$key]['type'] = $value['type'];
				$data[$key]['type_name'] = $value['type_name'];
				continue;
			}

			if ( false == in_array( $value['type'], $num )) {
				$num[] = $value['type'];
				$data[$key]['type'] = $value['type'];
				$data[$key]['type_name'] = $value['type_name'];
			}
		}
		//$this->orderByData();
		return $data;
	}

	//生成与更新包各自类型相匹配 的 分组数据列表( 自动按类型分组 )
	public function typeDataList() {
		$result = $this->orderByData( $this->data );
		foreach ( $result as $value )
			$data[$value['type']][] = $value;
		return $data;
	}

	//按时间排序数据 - 默认从大到小
	public function orderByData( $pDataArr, $pStr = '>'  ) {
		$data = $pDataArr;
		$count = count( $data );
		for ( $i=0; $i<$count; $i++ ) {
			for ( $j=0; $j<$i; $j++ ) {
				if ( $pStr == '>' ) {
					if ( $data[$i]['add_time'] > $data[$j]['add_time'] ) {
						$tmp = $data[$i];
						$data[$i] = $data[$j];
						$data[$j] = $tmp;
					}
				} else {
					if ( $data[$i]['add_time'] < $data[$j]['add_time'] ) {
						$tmp = $data[$i];
						$data[$i] = $data[$j];
						$data[$j] = $tmp;
					}
				}
			}
		}
		
		return $data;
	}

	//将文本转换成数据
	public function textToData() {
		//初始化数组
		$data = array();
		//定义字段名
		$dataName = array( 'id','pack_name','type','type_name','download','status', 'add_time' );
		//读取文件
		$fopen = fopen( DATABASE_TEXT, "rb" );
        while ( !feof( $fopen )){
            $tData = fgets( $fopen );
            $dataValue = explode( '<|>', $tData );
            $data[] = array_combine( $dataName, $dataValue );
        }
        fclose( $fopen );
        return $data;
	}

	//------------------------------------------------------------------------------------------
	//获取单个更新包全部信息
	public function getOnePackInfo( $pId ) {
		foreach ( $this->data as $key=>$value ) {
			if ( strcmp( $value['id'], $pId ) == 0 ) {
				$value['download'] = rtrim( $value['download'], '/' ).'/'.$value['pack_name'];
				return $value;
			}
		}
	}

	//设置压缩包下载状态改为 1 已下载
	public function setStatusValue( $pId, $pStatus ) {
		foreach ( $this->data as $key=>$value ) {
			if ( strcmp( $pId, $value['id'] ) == 0 )
				$this->data[$key]['status'] = $pStatus;
		}
		$this->dataToText();
	}

	//对比更新包设置 下载状态 是否成功  1 为已下载 0 为未下载
	public function downloadStatus( $pId, $pStatus ) {
		foreach ( $this->data as $key=>$value ) {
			if (( strcmp( $pId, $value['id'] ) == 0 ) && ( strcmp( $pStatus, $this->data[$key]['status'] ) == 0 ))
				return true;
		}
		return false;
	}

	//将数据写入到文本
	public function dataToText() {
		$fopen = fopen( DATABASE_TEXT, "w" );
        foreach( $this->data as $value ) {
        	$data = $this->arrToStr( $value );
			fwrite( $fopen, $data );
        }
        fclose( $fopen );
	}

	//删除本地更新包
	public function deletePack( $pFilePath ) {
		return unlink( $pFilePath );
	}

	//数组转换成字符串 - 
	public function arrToStr( $pArr, $pChar = '<|>' ) {
		$data = array_values( $pArr );
		return implode( $pChar, $data );
	}



}
