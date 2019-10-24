<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */

/*
必须先类头部 namespace 下面 use Home\Common\Utility\UploadUtility;
调用的时候要先配置下列相关信息, 然后再 new 调用

$config = array(
    'maxSize'    =>    0,
    'rootPath'   =>    './test_uploads/',
    'savePath'   =>    '',
    'saveName'   =>    'aaa',
    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg', 'rar', 'html', 'zip'),
    'autoSub'    =>    false,
    'subName'    =>    array('date','Ymd'),
);

$Upload = new UploadUtility();
$Upload->upload( $config );

*/

/*
文件上传后的返回信息
array(1) {
  ["photo"] => array(9) {
    ["name"] => string(10) "index.html"
    ["type"] => string(9) "text/html"
    ["size"] => int(1583)
    ["key"] => string(5) "photo"
    ["ext"] => string(4) "html"
    ["md5"] => string(32) "1e948963fb53d6215920ba0f8c8b3e9e"
    ["sha1"] => string(40) "0692742c10c489fce5a2cd3fb0cfd33966f8100c"
    ["savename"] => string(8) "aaa.html"
    ["savepath"] => string(0) ""
  }
}
*/

namespace Home\Common\Utility;
use Think\Controller;
use Think\Upload;

class UploadUtility extends Controller //不需要继承Controller
{

	// thinkphp 3.2 自带的文件上传方法 - 后期可能需要自己写方法替换
	public function upload( $pConfig ){
		if( empty( $pConfig )) $this->error( '请输入上传文件配置信息！' );

		$Upload = new Upload( $pConfig );									 // 实例化上传类
		$info = $Upload->upload();
        
		FALSE == $info
			? $path = FALSE													 // 上传失败
			: $path = $info['photo']['savepath'].$info['photo']['savename']; // 上传成功
		return $path;

	}


}