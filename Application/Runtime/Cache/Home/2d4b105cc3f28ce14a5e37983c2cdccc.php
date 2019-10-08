<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/Public/css/select.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/js/select-ui.min.js"></script>

    <!--
    <script language="javascript">
    $(function(){   
        //导航切换
        $(".imglist li").click(function(){
            $(".imglist li.selected").removeClass("selected")
            $(this).addClass("selected");
        })  
    })  
    </script>
    -->
    <script type="text/javascript">

    /*$(document).ready(function(){

        $(".toolbar2").click(function(){
            //alert( 'aaa' );
        });

        $(".click").click(function(){
            $(".tip").fadeIn(200);
            });
          
            $(".tiptop a").click(function(){
            $(".tip").fadeOut(200);
        });
            $(".sure").click(function(){
            $(".tip").fadeOut(100);
        });

            $(".cancel").click(function(){
            $(".tip").fadeOut(100);
        });
    */

    </script>

    <!-- 设置seelct1样式和宽度 -->
    <script type="text/javascript">
    $(document).ready(function(e) {
        $(".select1").uedSelect({
            width : 200
        });
    });
    </script>

</head>

<body>

    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">更新包管理</a></li>
        </ul>
    </div>
    
    <div class="rightinfo">
    
        <div class="tools">
            <!-- <ul class="toolbar"> -->
            <ul class="forminfo" style="padding-left:0px;">
            
            <!--
            <li class="click"><span><img src="/Public/images/t02.png" /></span>修改</li>
            <li><span><img src="/Public/images/t03.png" /></span>删除</li>
            -->
            <form id="form_type" action="<?php echo U( 'Home/Pack/dataList' ) ;?>" method="get" >
            <!--<li>选择系统</li>-->
            <li>
                <div class="vocation">
                    <select id="type" name="type_id" class="select1">
                        <option value="">全部</option>
                        <?php if(is_array($datalist[0])): foreach($datalist[0] as $key=>$vo): if($vo["type"] == $datalist[2]): ?><option value="<?php echo ($vo["type"]); ?>" selected ><?php echo ($vo["type_name"]); ?></option>
                            <?php else: ?>
                                <option value="<?php echo ($vo["type"]); ?>" ><?php echo ($vo["type_name"]); ?></option><?php endif; endforeach; endif; ?>
                    </select>
                </div>
            </li>

            <input onclick = "checkUser();" name="" type="button" class="btn" value="提交" style="margin-left:10px;"  >
            </form>
            <!-- <li><span><img src="/Public/images/t04.png" /></span>统计</li> -->
            </ul>
        </div>
    
        <table class="imgtable">
            <thead>
                <tr>
                    <th width="100px;">缩略图</th>
                    <th>标题</th>
                    <th>编号</th>
                    <th>类别</th>
                    <th>更新包</th>
                    <th>操作</th>
                </tr>
            </thead>
            
            <tbody>
                <?php if(is_array($datalist[1])): foreach($datalist[1] as $key=>$vo): ?><tr>
                        <td class="imgtd">
                            <a href="#" >
                            <img src="/Public/images/rar_01.png" /></a>
                        </td>

                        <td>
                            <a href="#"> <?php echo ($vo["pack_name"]); ?> </a>
                            <p>发布时间： <?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?></p>
                            <p>相对路径: <?php echo ($vo["relative_path"]); ?></p>
                            <p>下载地址: <?php echo ($vo["download"]); ?></p>
                        </td>

                        <td>编号<p>ID: <?php echo ($vo["id"]); ?></p></td>
                        <td><?php echo ($vo["type_name"]); ?></td>
                        <?php if($vo["status"] == 1): ?><td>已下载</td>
                        <?php else: ?>
                            <td style="color:gray" >未下载</td><?php endif; ?>
                        <td>
                            <!-- <?php echo U( 'Home/Pack/downloadPack', array( 'id'=>$vo['id'] ));?> -->
                            <a id="down" href="" value="<?php echo ($vo['id']); ?>" class="tablelink">下载</a> 
                            <?php if($vo["status"] == 1): ?><a id="del" href="" value="<?php echo ($vo['id']); ?>" class="tablelink">删除</a>
                            <?php else: ?>
                                <a style="color:gray" href="#" class="tablelink">删除</a><?php endif; ?>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>

        <div class="pagin">
            <div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
            <ul class="paginList">
                <li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>
                <li class="paginItem"><a href="javascript:;">1</a></li>
                <li class="paginItem current"><a href="javascript:;">2</a></li>
                <li class="paginItem"><a href="javascript:;">3</a></li>
                <li class="paginItem"><a href="javascript:;">4</a></li>
                <li class="paginItem"><a href="javascript:;">5</a></li>
                <li class="paginItem more"><a href="javascript:;">...</a></li>
                <li class="paginItem"><a href="javascript:;">10</a></li>
                <li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>
            </ul>
        </div>
    
        <div class="tip">
            <div class="tiptop"><span>提示信息</span><a></a></div>
            
            <div class="tipinfo">
                <span><img src="/Public/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>

            <div class="tipbtn">
                <input name="" type="button"  class="sure" value="确定" />&nbsp;
                <input name="" type="button"  class="cancel" value="取消" />
            </div>
        </div>
    
    
    </div>
    
    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>
        
        <div class="tipinfo">
            <span><img src="/Public/images/ticon.png" /></span>
            <div class="tipright">
                <p>是否确认对信息的修改 ？</p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>
        
        <div class="tipbtn">
            <input name="" type="button"  class="sure" value="确定" />&nbsp;
            <input name="" type="button"  class="cancel" value="取消" />
        </div>
    </div>

    
<script type="text/javascript">

    /* 点击下载按钮时将分类id和当前一条数据id传递给后端处理 */
    $(".imgtable #down").click(function() {
        /* 获取分类 id */
        var type_id = $( "#type" ).find( "option:selected" ).val();
        /* 获取当前一条数据 id */
        var id = $(this).attr("value");
        /* 拼接URI请求地址 */
        $(this).attr( 'href', "<?php echo U( 'Home/Pack/downloadPack' );?>"+'?id='+id+'&type_id='+type_id );
    });

    $(".imgtable #del").click(function() {
        /* 获取分类 id */
        var type_id = $( "#type" ).find( "option:selected" ).val();
        /* 获取当前一条数据 id */
        var id = $(this).attr("value");
        /* 拼接URI请求地址 */
        $(this).attr( 'href', "<?php echo U( 'Home/Pack/del' );?>"+'?id='+id+'&type_id='+type_id ); 
    });

    function checkUser(){
       // var result = document.getElementById("userid").value;
       // var password = document.getElementById("passid").value;
       // if(result == ""  ){
       //   alert("用户名不能为空");
       //   return false;
       // }
       // if(password == ""  ){
       //  alert("密码不能为空");
       //   return false;
       // }
        document.getElementById("form_type").submit()
    }
</script>

<script type="text/javascript">
    $('.imgtable tbody tr:odd').addClass('odd');
</script>

    
</body>

</html>