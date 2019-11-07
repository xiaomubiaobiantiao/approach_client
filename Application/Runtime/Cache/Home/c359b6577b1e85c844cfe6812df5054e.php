<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>

<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="/Public/js/loadJs.js"></script>

<style> 
/*.forminfo { margin-left:22%;width:50%; }*/
.forminfo a { color:blue;line-height: 36px; margin-left:100px; }
.forminfo .datadiv { border-bottom: 1px solid black; margin: 0px 0px 0px 140px; float:left; }
.forminfo .formbody { align-content: center; }
.forminfo .button { margin: 35px 0px 35px 0px; float:center; }
.forminfo .dfinput { margin-top: 10px; }
.forminfo li i { padding-left: 0px; margin-left: 20px; }
/*.forminfo li label { line-height: 50px; }*/
li label { margin-top:8px; color:gray;}
.li_o label { margin-left: 45%; color:blue }
</style>

</head>

<body>
    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页 /Public/js/update.js </a></li>
    <li><a href="#">更新/还原</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
    <ul> 
    <li><a href="#tab1" class="selected">配置数据库</a></li>
<!--     <li><a href="#tab2">sqlserver</a></li>
    <li><a href="#tab3">mysql</a></li>  -->
    </ul>
    </div> 
    
    <div id="tab1" class="tabson">
    
    <!-- <div class="formtext">系统 <b>当前版本</b> <?php echo ($datalist[3]); ?></div> -->
    
    <ul class="forminfo" >

        <?php if(is_array($datalist)): foreach($datalist as $key=>$vo): ?><from id="<?php echo ($vo); ?>" action="" method='POST' >
            <div class="datadiv" >
            <li class="li_o" >
                <label><?php echo ($vo); ?></label><!-- <label></label> -->
                <input name="type" type="text" class="dfinput" value="<?php echo ($vo); ?>" style="display:none" />
            </li>
            <li>
                <label>服务器：</label>
                <input name="server" type="text" class="dfinput" value="" /><i>123</i>
            </li>
            <li>
                <label>登陆名：</label>
                <input name="user" type="text" class="dfinput" value="" /><i>123</i>
            </li>
            <li>
                <label>密码：</label>
                <input name="pass" type="text" class="dfinput" value="" /><i>123</i>
            </li>

            <li class="button" >
                <label><b></b></label>
                <button id="update" class="btn" value="<?php echo ($vo); ?>" onclick="submitData('<?php echo U('UpdateData/testLink');?>', this.value);" >检测连接数据库</button></li>
                <!-- <input id="update" type="button" value="检测连接数据库" class="btn" ></li> -->
            </div>
        </from><?php endforeach; endif; ?>
        <button id="update" class="btn" onclick="submitData('<?php echo U('UpdateData/testLinkAll');?>');" >一键检测连接</button></li>
<!--         <button id="update" class="btn" onclick="update.linkDataAll(update.url='<?php echo U(UpdateData/testLink);?>');" >一键检测连接</button></li> -->
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
        function submitData( url, id ){
            new Update( url, id );
        }
    </script>

    </div>

  


</body>

</html>