<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/Public/js/jquery.js"></script>

<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active");
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>菜单列表</div>
    
    <dl class="leftmenu">
        
    <dd>


    <dd>
        <div class="title"><span><img src="/Public/images/leftico04.png" /></span>软件更新</div>
        <ul class="menuson" style="display: block;">
            <li><cite></cite><a href="<?php echo U('Home/Update/index');?>" target='rightFrame'>文件更新</a><i></i></li>
            <li><cite></cite><a href="<?php echo U('Home/UpdateData/index');?>" target='rightFrame'>數据更新</a><i></i></li>
            <li><cite></cite><a href="<?php echo U('Home/Pack/index');?>" target='rightFrame'>软件包管理</a><i></i></li>
            <li><cite></cite><a href="<?php echo U('Home/Logs/index');?>" target='rightFrame'>查看日志</a><i></i></li>
            <li><cite></cite><a href="<?php echo U('Home/UpdateData/getDataXml');?>" target='rightFrame'>获取xml文件</a><i></i></
            <li><cite></cite><a href="<?php echo U('Home/UpdateData/updateXmlToData');?>" target='rightFrame'>测试页</a><i></i></
            li>
        </ul>
    </dd>

    </dl>
    
</body>
</html>