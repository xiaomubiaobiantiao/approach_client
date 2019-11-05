<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>

<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="/Public/js/update.js"></script>

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
    
    <ul class="forminfo" >

        <?php if(is_array($datalist)): foreach($datalist as $key=>$vo): ?><from id="<?php echo ($vo); ?>" action="{U('UpdateData/linkData')}" method='POST' >
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
                <button id="update" class="btn" value="<?php echo ($vo); ?>" onclick="update.linkData(update.url='<?php echo U(UpdateData/testLink);?>', this.value);" >检测连接数据库</button></li>
                <!-- <input id="update" type="button" value="检测连接数据库" class="btn" ></li> -->
            </div>
        </from><?php endforeach; endif; ?>
        <!-- <button id="update" class="btn" onclick="linkDataAll();" >一键检测连接</button></li> -->
        <button id="update" class="btn" onclick="update.linkDataAll(update.url='<?php echo U(UpdateData/testLink);?>');" >一键检测连接</button></li>
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


   <!--  <script type="text/javascript">
        function linkData( id ){
            var str = getFromData( id );
            if( str == false ) { 
                alert( str );
                alert( '信息输入不完整' );
                return false;
            };
            var url = "<?php echo U('UpdateData/testLink');?>";
            submitAjax( str, url );
        }
    </script>

    <script type="text/javascript">
        function linkDataAll(){
            var str = getFromAllData();
            alert( str );
            if( str == false ) { 
                alert( '信息输入不完整' );
                return false;
            };
            var url = "<?php echo U('UpdateData/testLinkAll');?>";
            submitAjax( str, url );
        }
    </script>

    <script type="text/javascript"> 
        function getFromData( id ) {

            var str = '';
            var frmObj = $("#"+id);
            var input_Obj = frmObj.find("input:text");
            
            //由上面的表单获取里面的值
            var input_length = input_Obj.length;

            input_Obj.each(function(i){

                var thisName = $(this).attr('name');
                var thisVal = $(this).val();

                if ( thisVal == '' ) {
                    // alert( id +'下的'+ thisName +'不能为空' );
                    $(this).siblings('i').css("color","red");
                    result = false;
                } else {
                    $(this).siblings('i').css("color","gray");
                }

                str += '"'+(thisName+'":"'+thisVal)+'"';
                if ( i+1 < input_length ) {
                    str += ',';
                }
                // alert( result ); // 未完待续
            });

            if ( result == false ) { return false; } 

            return '{'+str+'}';

        }
    </script>

    <script type="text/javascript">
        function getFromAllData () {

            var str = '';
            var value = '';
            var fomObj = $('from');
            var value = new Array();
            var input_length = fomObj.length;

            fomObj.each(function(i){

                value = getFromData( $(this).attr('id') );

                if ( value == false ) {
                    result = false;
                }

                str += value;

                if ( i+1 < input_length ) {
                    str += ',';
                }

            });

            if ( result == false ) { return false };
            // return JSON.stringify('['+str+']');
            return '['+str+']';
        }
    </script>

    <script type="text/javascript"> 
        function submitAjax( str, url ) { 
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: str,
                // traditional: true,
                success: function (data) {

                    alert(JSON.stringify(data))
                    alert( data.sqlserver );
                    // if ( data = true )
                    // console.log(result);    //打印服务端返回的数据(调试用)
                    // if (result.resultCode == 200) {
                    //     alert("SUCCESS");
                    // }; 
                    // alert(data.username);
                },
                error : function() {
                    alert("提交异常！");
                }
            });
        }
    </script>

    <script type="text/javascript">
        function aaa(obj){
            // obj = {"cid":"C0","ctext":"区县"};
            alert(obj);
                var temp = "";
                for(var i in obj)
                alert(temp);//结果：cid:C0 \n ctext:区县
            }
    </script>
 -->
    </div>

  


</body>

</html>