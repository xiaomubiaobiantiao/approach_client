<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Public/css/progress/bootstrap.min.css" rel="stylesheet">
<link href="/Public/css/progress/demo.css" rel="stylesheet" type="text/css" >
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="/Public/js/select-ui.min.js"></script>

</head>

<body>

    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">日志</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
    <ul> 
    <li><a href="#tab1">更新日志</a></li> 
    </ul>
    </div> 

    <div id="tab1" class="tabson">
    
    <ul class="seachform">
    
        <?php if(is_array($logs)): foreach($logs as $key=>$vo): ?><li><label style="width:100%; color:gray;" class="type" onclick="up(this)" ><?php echo ($vo); ?></label></li><?php endforeach; endif; ?>

    
    </ul>

    </div>

    <!-- ========================================================================================== -->

    </div>

    </div>

     <script type="text/javascript"> 
        $("#usual1 ul").idTabs(); 
    </script>



</body>

</html>