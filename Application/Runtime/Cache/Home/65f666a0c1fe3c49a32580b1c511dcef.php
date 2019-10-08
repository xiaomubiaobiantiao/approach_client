<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>

<script language="javascript">
	$(function(){
    $('.error').css({'position':'absolute','left':($(window).width()-490)/2});
	$(window).resize(function(){  
    $('.error').css({'position':'absolute','left':($(window).width()-490)/2});
    })  
});  
</script> 


</head>


<body style="background:#edf6fa;">

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">失败</a></li>
    </ul>
    </div>
    
    <div class="error" style="background: url(/Public/images/4041.png) no-repeat;" >
    
    <!-- <h2>非常遗憾，您访问的页面不存在！</h2>
    <p>看到这个提示，就自认倒霉吧!</p> -->
    <h2><?php echo ($data[0]); ?></h2>
    <p><?php echo ($data[1]); ?></p>
    <div class="reindex"><a href="<?php echo U( 'Index/main' );?>" target="_parent">返回首页</a></div>
    
    </div>


</body>

</html>