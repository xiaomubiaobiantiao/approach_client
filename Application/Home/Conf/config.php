<?php
//所有 常量值 路径后面必须加 / 符号	******** 例: Public/files/
//排除检测的常量除外

/* 被更新项目使用的变量 */
//文件更新的路径
//$path = 'D:/phpStudy/PHPTutorial/WWW/approach_test/';
$path = 'E:/approach_test/';
//$path = 'E:/download/';

/* 被更新项目使用的常量 */
define( 'UPDATE_PATH', $path );

//文件压缩包备份的路径 里面包含需要备份的文件和更新时追加的文件的记录文档
define( 'BACKUP_PATH', UPDATE_PATH.'Public/files/backup_pack/' );

//文件压缩包还原的路径
define( 'RESTORE_BACKUP_PATH', UPDATE_PATH.'Public/files/resore_backup_pack/' );



//记录全部信息的日志名称
define( 'LOCAL_LOG', UPDATE_PATH.'Public/files/logs/log.txt' );

//记录更新信息错误的日志名称
define( 'LOCAL_UPDATE_ERROR', UPDATE_PATH.'Public/files/logs/update/update_error.txt' );
//记录更新次数的日志名称
define( 'LOCAL_UPDATE_RECORD', UPDATE_PATH.'Public/files/logs/update/update_record.txt' );

//记录恢复信息错误的日志名称
define( 'LOCAL_RESTORE_ERROR', UPDATE_PATH.'Public/files/logs/restore/restor_error.txt' );
//记录恢复次数日志的名称
define( 'LOCAL_RESTORE_RECORD', UPDATE_PATH.'Public/files/logs/restore/restor_record.txt' );

//记录数据库相关操作的日志
define( 'DATABASE_LOG', UPDATE_PATH.'Public/files/logs/data_log.txt' );




/* 更新程序使用的常量 */
//压缩包文件下载路径
define( 'UPLOAD_PATH', 'Public/files/uploads_pack/' );

//文件备份的临时路径 最后会被自动删除
define( 'BACKUP_TMP_PATH', 'Public/files/backup_tmp_pack/' );

//文件解压缩的临时路径 最后会被自动删除
define( 'UNPACK_TMP_PATH', 'Public/files/unpack_tmp_pack/' );

//本地项目文件结构存放位置 - 暂时未用
define( 'PROJECT_STRUCTURE', 'Public/files/project_file/' );




//项目原有文件需要排除检测的目录  常量值字符串 ,号中间不能有空格, 路径开头末尾不能有 / 符号
define( 
	'IGNORE_DIRS', 
	 UPDATE_PATH.'Public/files,'
	.UPDATE_PATH.'ThinkPHP,'
	.UPDATE_PATH.'Public/Ueditor,'
	.UPDATE_PATH.'Application/Runtime' 
);

//排除检测的文件  常值值字符串 ,号中间不能有空格
define( 'IGNORE_FILES', '.git,version.txt' );



/* 数据库字段更新配置信息 */

// XML文件在更新包中的位置 -- 暂时未用
define( 'Database/' );

//下面这两项是不能更改的, 或者说根据 更新包 的数据库更新路径而更改的
//因为没有判定数据库目录的方式, 所以要手动设定, 不需要更改
//数据库更新目录的名称
define( 'DATABASE_UPDATE_NAME', 'data_base' );//暂时未用
//数据库更新目录的存放位置
define( 'DATABASE_UPDATE', rtrim( UNPACK_TMP_PATH, '/' ).'/'.DATABASE_UPDATE_NAME );//暂时未用


/* end */


//新的版本文件默认位置信息
define( 'VERSION_PATH', rtrim( UNPACK_TMP_PATH, '/' ).'/'.'version.txt' );

//旧的版本文件默认位置信息
define( 'OLD_VERSION_PATH', rtrim( UPDATE_PATH, '/' ).'/'.'version.txt' );

//版本信息默认值
define( 'VERSION_DEFAULT_INFO', 'no version' );





//数据文本的存放位置
define( 'DATABASE_TEXT', 'Public/data/database.txt' );