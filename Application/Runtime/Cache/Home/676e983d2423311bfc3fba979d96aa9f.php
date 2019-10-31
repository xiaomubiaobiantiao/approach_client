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

<!-- css部分 -->
<style type="text/css">
.progress-title{
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin: 0 0 20px;
    }
    .progress{
        height: 10px;
        background: #333;
        border-radius: 0;
        box-shadow: none;
        margin-bottom: 30px;
        overflow: visible;
    }
    .progress .progress-bar{
        position: relative;
        -webkit-animation: animate-positive 6s;
        animation: animate-positive 6s;
    }
    .progress .progress-bar:after{
        content: "";
        display: inline-block;
        width: 9px;
        background: #fff;
        position: absolute;
        top: -10px;
        bottom: -10px;
        right: -1px;
        z-index: 1;
        transform: rotate(35deg);
    }
    .progress .progress-value{
        display: block;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        position: absolute;
        top: -30px;
        right: -25px;
    }
    @-webkit-keyframes animate-positive{
        0%{ width: 0; }
    }
    @keyframes animate-positive {
        0%{ width: 0; }
    }

}
</style>

<script type="text/javascript">
    $(document).ready(function(e) {
        $(".select1").uedSelect({
            width : 345           
        });
        $(".select2").uedSelect({
            width : 500  
        });
        $(".select3").uedSelect({
            width : 100
        });
    });
</script>
</head>

<body>

    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">数据库更新</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
    <ul> 
    <li><a href="#tab1" class="selected">数据库更新</a></li> 
    </ul>
    </div> 
    
    <div id="tab1" class="tabson">
    
    <!-- <div class="formtext">系统 <b>当前版本</b> <?php echo ($datalist[3]); ?></div> -->
    
    <ul class="forminfo">

        <form id="form_type" action="<?php echo U('Home/UpdateData/index');?>" method="get" >
        <li>
        <label>选择类别<b>*</b></label>  
        <div class="vocation">
            <select id="type" name="type_id" class="select1">
                <?php if(is_array($ziplist[0])): foreach($ziplist[0] as $key=>$vo): if($vo["type"] == $ziplist[2]): ?><option value="<?php echo ($vo["type"]); ?>" selected ><?php echo ($vo["type_name"]); ?></option>
                    <?php else: ?>
                        <option value="<?php echo ($vo["type"]); ?>" ><?php echo ($vo["type_name"]); ?></option><?php endif; endforeach; endif; ?>
            </select>
        </div>
        </li>
        </form>
        <form id="form_update" action="<?php echo U( 'Home/UpdateData/dataType' );?>" method="get" >
        <li>
            <label>选择版本<b>*</b></label>
            <div class="vocation">
                <select id="version" name="version_id" class="select1">
                    <?php if(is_array($ziplist[1])): foreach($ziplist[1] as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["pack_name"]); ?></option><?php endforeach; endif; ?>
                </select>
            </div>
        </li>

        <li><label><b></b></label>
            <div class="vocation">
                <!-- <input id="submit" class="btn" type="submit" value="更新" > -->
                <!-- <button id="submit" class="btn" type="submit" value="更新" > -->
                <button id="update" class="btn" >下一步</button>
            </div>
        </li>
        </form>

        </ul>
        
    </div> 
    
       </div>
     
   
    
    
    </div>

    <!-- jquery 部分 -->
    <script type="text/javascript">
        alert( '确认是否已经 备份 数据库 !' );
    </script>        

    <script type="text/javascript">

        $("#update").click(function(){
            $("form[id='form_update']").submit();
            //progress();
        })

    </script>

    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
    
    <script type="text/javascript">
        /*提交类别表单*/
        $('#type').change(function(){
            //jQuery 提交表单
            $("form[id='form_type']").submit();
            //js 提交表单
            //document.getElementById("form_type").submit()
        });

    </script>

</body>

</html>