<?php
/**
 * 文件下载类 - 暂未用 - 接近废弃
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

use Home\Supply\Log\Logs;

class DownloadUtility extends Logs
{

    public $errorInfo = array(
            1 => 'Download file '
    );

    public $successInfo = array(
            1 => 'Download file complete! '
    );

	//下载压缩包
	public function down( $pUrl, $pFolder = "./" ) {

       	//设置超时时间
        set_time_limit (24 * 60 * 60); 

        //本地目录不存在,则递归创建本地目录
        if ( false == is_dir( $pFolder )) self::createDir( $pFolder );
        
        //组合新的路径和文件名称
        $newFileName = $pFolder.basename( $pUrl ); // 取得文件的名称
        
        //打开需要下载的文件，二进制模式  
        $file = fopen ( $pUrl, "rb" ); 

        if ( false == $file ) return false; //( '打开下载文件失败!' );

        //创建本地文件
        $localFile = fopen ( $newFileName, "wb" ); // 远在文件文件  

        //本地文件创建失败
        if ( false == $localFile ) return false; //( '打开本地文件失败!' );

        //循环读取到文件末尾并写入本地文件
        while ( !feof( $file )) { 
            fwrite( $localFile, fread( $file, 1024 * 8 ), 1024 * 8 );
        }

        fclose( $file ); // 关闭远程文件
        fclose( $newfile ); // 关闭本地文件
        //ob_clean();   //如果压缩包下载后损坏,打开 ob_clean() 和 fulush();
        //flush();   
        return true;  
    }

    /**
     * 重写错误信息 - 并将错误信息写入日志
     * [inforReceive description]
     * @param  string $pFunctionName [class and functionName]
     * @param  int $pParam           [0,1,2...]
     * @return [string]              [error: info]
     */
    public function inforReceive ( $pFunctionName = '', $pParam = '' ) {
        $message = parent::inforReceive( $pFunctionName, $pParam );
        $this->writeLog( $message, LOCAL_LOG );
        $this->writeLog( $message, LOCAL_UPDATE_ERROR );
    }

    /**
     * 重写正确信息 - 并将错误信息写入日志
     * [successReceive description]
     * @param  string $pParam [class and functionName]
     * @param  string $pStr   [0,1,2...]
     * @return [string]       [success: info]
     */
    public function successReceive( $pParam = '', $pStr = '' ) {
        $message = parent::successReceive( $pParam, $pStr );
        $this->writeLog( $message, LOCAL_LOG );
    }



}