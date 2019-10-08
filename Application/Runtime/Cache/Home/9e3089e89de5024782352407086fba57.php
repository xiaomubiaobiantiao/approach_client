<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>

</head>
<style>
    .success{
        color: green;
        font-size: 11pt;;
    }
    .error1{
        color: #919191;
        font-size: 11pt;;
    }
</style>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li>首页</li>
    </ul>
    </div>

    <div class="mainindex">


    <div class="welinfo">
    <span><img src="/Public/images/sun.png" alt="天气" /></span>
    <b><?php echo session('username');?>好，欢迎使用实施路径系统</b>
    <a href="/index.php/Poor/User/editPwd">帐号设置</a>
    </div>



    <div class="xline"></div>

    <ul class="iconlist">

    <li><img src="/Public/images/ico01.png" /></li>
    <li><img src="/Public/images/ico02.png" /></li>
    <li><img src="/Public/images/ico03.png" /></li>
    <li><img src="/Public/images/ico04.png" /></li>
    <li><img src="/Public/images/ico05.png" /></li>
    <li><img src="/Public/images/ico06.png" /></li>

    </ul>


    <div class="xline"></div>
    <div class="box"></div>

    <div class="welinfo">
    <span><img src="/Public/images/dp.png" alt="提醒" /></span>
    <b>众智实施路径系统使用指南</b>
    </div>

    <ul class="infolist">
    <li><span>个人管理</span><a class="ibtn">修改密码</a></li>

    </ul>

    <div class="xline"></div>
        <div class="uimakerinfo" >该系统进行的状态</div>
        <ul class="umlist">
            <li><a href="#" class="success">进场</a></li>
            <li><a href="#" class="success">服务器信息检查</a></li>
            <?php if($p_num){ ?>
            <li><a href="#" class="success">录入厂家信息</a></li>
            <?php }else{ ?>
            <li><a href="#" class="error1">录入厂家信息</a><p><a class="ibtn" href="/index.php/Applist/Index/product_add">去完成</a></p></li>
            <?php }if($hos_num){ ?>
            <li><a href="#" class="success">录入医院信息</a></li>
            <?php } else { ?>
            <li><a href="#" class="error1">录入医院信息</a><p><a class="ibtn" href="/index.php/Applist/Index/hospital_add">去完成</a></p></li>
            <?php } if($inter_num) {?>
            <li><a href="#" class="success">录入接口信息</a></li>
            <?php } else { ?>
            <li><a href="#" class="error1">录入接口信息</a><p><a class="ibtn" href="/index.php/Applist/Interface/interface_add">去完成</a></p></li>
            <?php }?>
            <li><a href="#" style="font-size: 11pt;">验证数据</a></li>
            <li><a href="#" class="error1">参数配置</a><p><a class="ibtn" href="#">去完成</a></p></li>
            <?php if($file_num) {?>
            <li><a href="#" class="success">上传文档</a></li>
            <?php }else { ?>
            <li><a href="#" class="error1">上传文档</a><p><a class="ibtn" href="/index.php/Applist/File/file_add">去完成</a></p></li>
            <?php }if($daily_num){?>
            <li><a href="#" class="success">实施日志</a></li>
            <?php } else { ?>
            <li><a href="#" class="error1">实施日志</a><p><a class="ibtn" href="/index.php/Applist/Daily/daily_add">去完成</a></p></li>
            <?php }?>
            <li><a href="#" class="error1">验收</a><p><a class="ibtn" href="#">去完成</a></p></li>
        </ul>




    </div>



</body>

</html>