<?php
/**
 * 文件操作基础类
 * [FileBaseUtility]
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

use Home\Supply\File\FileBase;

class FileBaseUtility extends FileBase
{

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

}