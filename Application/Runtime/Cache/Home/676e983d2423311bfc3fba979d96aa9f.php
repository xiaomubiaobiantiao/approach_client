<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>

<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.idTabs.min.js"></script>

<style> 
.forminfo { margin-left:22%;width:50%; }
.forminfo a { color:blue;line-height: 36px;margin-left:100px; }
.forminfo .datadiv { border-bottom: 1px solid black; }
.forminfo .formbody { align-content: center; }
.forminfo .button { margin: 35px 0px 0px 0px; float:right; }
</style>

</head>

<body>
    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">更新/还原</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
    <ul> 
    <li><a href="#tab1" class="selected">数据库信息</a></li>
    <li><a href="#tab2">sqlserver</a></li>
    <li><a href="#tab3">mysql</a></li> 
    </ul>
    </div> 
    
    <div id="tab1" class="tabson">
    
    <div class="formtext">系统 <b>当前版本</b> <?php echo ($datalist[3]); ?></div>
    
    <ul class="forminfo" >

        <?php if(is_array($databaselist)): foreach($databaselist as $key=>$databasetype): ?><div class="datadiv" >
            <li>
                <label>数据库类型</label><label><strong><?php echo ($key); ?></strong></label>
                <!--<input name="" type="text" class="dfinput" value="<?php echo ($key); ?>" readonly /><i></i>-->
            </li>
            <?php if(is_array($databasetype)): foreach($databasetype as $key=>$databasename): ?><li style="margin-bottom:0px;" >
                    <label>数据库名称</label><label><?php echo ($key); ?></label>
                    <!--<input name="" type="text" class="dfinput" value="<?php echo ($key); ?>" /><i></i>-->
                    <a href="#" >修改</a>
                </li><?php endforeach; endif; ?>
            </div><?php endforeach; endif; ?>

        <li class="button" ><label><b></b></label><button id="update" class="btn" >检测连接数据库</button></li>

    </ul>
    

    </div> 
    
    <!--
    <div id="tab2" class="tabson">
    
    <div class="formtext">系统 <b>当前版本</b> <?php echo ($datalist[3]); ?></div>

    <ul class="forminfo">
    
  
    <li><label>文章标题</label><input name="" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
    <li><label>关键字</label><input name="" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>
    
    </ul>

    </div>
    -->
    <!-- ========================================================================================== -->

    </div>
 
    <script type="text/javascript"> 
        $("#usual1 ul").idTabs(); 
    </script>
    
    </div>





</body>

</html>