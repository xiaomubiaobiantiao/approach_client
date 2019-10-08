<?php
/**
 * Description of CommonModel 
 * 公共服务类 - 目前未用
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */

namespace Home\Common\Service;

class CommonService
{

    //删除数据和文件 - 待完善 - 目前未用
    public function deleteData( $pId ) {

        $data = $this->PackModel->getDataOne( array( 'id'=>$pId ) );

        if ( is_file( $data['relative_path'] ))
                unlink( $data['relative_path'] );

        $this->PackModel->deleteAction( array( 'id'=>$pId ));

        return true;

    }

	// 字符串转换成数组
    // IndexFileService
	// private function strConversionArr( $pStr, $pChar = ',' ) {
	//     return explode( $pChar, trim( $pStr ));
	// }

	//模拟 array_column 函数, 因为 array_column 只能用于5.5以上版本,具体使用方法参考手册
	//暂时未用
    public function i_array_column( $array, $columnKey, $indexKey = null )
    {
        $result = array();
        foreach ( $array as $subArray ) {
            if ( is_null( $indexKey ) && array_key_exists( $columnKey, $subArray )) {
                $result[] = is_object( $subArray ) ? $subArray->$columnKey : $subArray[$columnKey];
            } elseif ( array_key_exists( $indexKey, $subArray )) {
                if ( is_null( $columnKey )) {
                    $index = is_object( $subArray ) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif ( array_key_exists( $columnKey, $subArray )) {
                    $index = is_object( $subArray ) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = is_object( $subArray ) ? $subArray->$columnKey : $subArray[$columnKey];
                }
            }
        }
        return $result;
    }

    


}