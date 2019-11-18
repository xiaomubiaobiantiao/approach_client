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
    <li><a href="#">数据更新/更新日志</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
    <ul> 
    <li><a href="#tab1" class="selected">更新结果</a></li> 
    <li><a href="#tab2">更新日志</a></li> 
    </ul>
    </div> 
    
    <div id="tab1" class="tabson">
    
    <ul class="forminfo">
    
        <li>
            <div>
                <?php if($list['status'] == 'true'): ?><label style="width:100%; color:blue;" class="type" >更新成功</label>
                <?php else: ?>
                    <label style="width:100%;" class="type" >更新失败：记录为 <span style="color:red; display:inline;" ><?php echo ($list['count']); ?></span> 条</label><?php endif; ?>
                
            </div>
        </li>
        <?php if(is_array($list['up'])): foreach($list['up'] as $key=>$vo): ?><li>
            <label style="width:100%; color:red;" class="type" onclick="up(this)" ><?php echo ($vo); ?></label>
            <label class="down" style="width:100%; color:gray;" class="type" ><?php echo ($list['down'][$key]); ?></label>
        </li><?php endforeach; endif; ?>
       <!--  <li><label><b></b></label>
            <div class="vocation">
                <button id="update" class="btn" >返回首页</button>
            </div>
        </li> -->

        </ul>
        
    </div>
    
    <!-- ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ 日志 ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ -->

    <div id="tab2" class="tabson">
    
    <ul class="seachform">
    
        <?php if(is_array($list['logs'])): foreach($list['logs'] as $key=>$vo): ?><li>
            <label style="width:100%; color:gray;" class="type" onclick="up(this)" ><?php echo ($vo); ?></label>
            <!-- <label class="down" style="width:100%; color:gray;" class="type" ><?php echo ($list['down'][$key]); ?></label> -->
        </li><?php endforeach; endif; ?>
      <!--   <li><label><b></b></label>
            <div class="vocation">
                <button id="update" class="btn" >返回首页</button>
            </div>
        </li> -->
    
    </ul>

    </div>

    <!-- ========================================================================================== -->

    </div>

    </div>

     <script type="text/javascript"> 
        $("#usual1 ul").idTabs(); 
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.down').hide();
        });
    </script>

    <script type="text/javascript">
        function up( obj ) {
            $(obj).next().toggle();
        }
    </script>


</body>

</html>