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
.forminfo .datadiv { border-bottom: 1px solid black; margin: 0px 0px 0px 80px; float:left; width:300px;}
.forminfo .formbody { align-content: center; }
.forminfo .button { margin: 35px 0px 35px 0px; float:center; }
.forminfo .dfinput { margin-top: 10px; }
.forminfo li i { padding-left: 0px; margin-left: 20px; }
/*.forminfo li label { line-height: 50px; }*/
/*li label { margin-top:8px; color:gray;}*/
/*.forminfo label { width:500px; }*/
/*.forminfo .li_o label { margin-left: 30%; color:red; width:120px; }*/
.forminfo .btn { width:100px; }
#bottom-buttons { float:left;height:100%;width:100%;padding:40px 0px 100px 35% }
#bottom-buttons #update { background:#ea68a2; }
#bottom-buttons #preview { background:gray; }
.forminfo li label { width:200px; }
/*body { width:120%;  }*/
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
    <li><a href="#tab1" class="selected">配置数据库</a></li>
<!--     <li><a href="#tab2">sqlserver</a></li>
    <li><a href="#tab3">mysql</a></li>  -->
    </ul>
    </div> 
    
    <div id="tab1" class="tabson">
    
    <!-- <div class="formtext">系统 <b>当前版本</b> <?php echo ($datalist[3]); ?></div> -->

    <!-- <div id="zipId" style="display: none" ><?php echo ($datalist['zipId']); ?></div> -->
    <!-- <ul class="forminfo" >
        <?php if(is_array($datalist['xmlType'])): foreach($datalist['xmlType'] as $key=>$vo): ?><from id="<?php echo ($vo); ?>" name="<?php echo ($vo); ?>" action="<?php echo U('UpdateData/test');?>" method='POST' >
            <div class="datadiv" >
            <li class="li_o" >
                <label class="type" ><?php echo ($vo); ?></label>
                <input name="type" type="text" class="dfinput" value="<?php echo ($vo); ?>" style="display:none" />
            </li>
            <li>
                <label>服务器：</label>
                <input name="server" type="text" class="dfinput" value="" /><i></i>
            </li>
            <li>
                <label>登陆名：</label>
                <input name="user" type="text" class="dfinput" value="" /><i></i>
            </li>
            <li>
                <label>密码：</label>
                <input name="pass" type="text" class="dfinput" value="" /><i></i>
            </li>

            <li class="button" >
                <label><b></b></label>
                <button id="update" class="btn" value="<?php echo ($vo); ?>" onclick="submitData('<?php echo U('UpdateData/testLink');?>', this.value);" >连接数据库</button></li>
            </div>
        </from><?php endforeach; endif; ?>
        
    </ul>
 -->

    <ul class="forminfo" >
    <?php if(is_array($list['prieview'])): foreach($list['prieview'] as $dataType=>$vo): ?><div class="datadiv">

        <li><label class="dtype" style="color:red;" >数据库类型：<?php echo ($dataType); ?></label></li>

        <?php if(is_array($vo[1])): foreach($vo[1] as $dataName=>$data): ?><li><label class="dname" style="color:blue;" >数据库名：<?php echo ($dataName); ?></label></li>
    
            <?php if(is_array($data[1])): foreach($data[1] as $tableName=>$tables): ?><li>
                    <label class="tname" onclick="fcount(this)" style="color:#FF00FF;">表名：<?php echo ($tableName); ?></label>
                </li>
                <span>
                    <li>
                        <label class="fcount" onclick="fcount(this)" >xml 字段：<?php echo ($tables[1]['xmlCount']); ?></label>
                    </li>

                    <span>
                        <?php if(is_array($tables[1]['list'])): $i = 0; $__LIST__ = $tables[1]['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><li class="field" style="background-color:#F8F8F8;height:32px;">
                                <label style="width:60px;color:gray;" >字段对比：</label>
                                <label style="width:120px;" class="fname" style="color:black;" ><?php echo ($key); ?></label>
                                
                                <?php if(($value) == "false"): ?><label style="width:60px;color:green;">可添加</label>
                                <?php else: ?>
                                    <label style="width:60px;color:red;">已存在</label><?php endif; ?>
                                
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </span>

                    <li><label class="fcount" onclick="fcount(this)" >添加的字段：<?php echo ($tables[1]['addFieldCount']); ?></label></li>

                    <span>
                        <?php if(is_array($tables[1]['addField'])): $i = 0; $__LIST__ = $tables[1]['addField'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$addField): $mod = ($i % 2 );++$i;?><li>
                                <label style="width:80px;color:gray;" >字段名称：</label>
                                <label style="width:120px;" ><?php echo ($addField); ?></label>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </span>

                </span><?php endforeach; endif; endforeach; endif; ?>

        </div><?php endforeach; endif; ?>
    </ul>

    <div id="bottom-buttons" >
        <button id="update" class="btn" onclick="updateData();" >开始更新</button></li>
    </div>

    </div> 
    </div>

    <!-- 隐藏域 -->
    <form id="jumpData" name="form1"  method="" action="">
        <textarea name ="data" hidden ><?php echo ($list['data']); ?></textarea>
    </form> 
    
    </div>

    <script type="text/javascript">
        function updateData() {
            $("#jumpData").attr("action", "<?php echo U('UpdateData/updateXmlToData');?>" ); 
            $("#jumpData").attr("method", 'POST' ); 
            $('#jumpData').submit();
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('span').hide();
        });
    </script>

    <script type="text/javascript">
        function fcount( obj ) {
            $(obj).parent().next().toggle();
        }
    </script>


</body>

</html>