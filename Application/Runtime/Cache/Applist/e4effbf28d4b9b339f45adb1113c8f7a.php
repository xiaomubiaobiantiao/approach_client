<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>列表页</title>
    <link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/js/jquery.js"></script>
    <style type="text/css">
        .current{
            display: inline;
        }
        .num{
            padding: 10px;
        }

    </style>
    <script type="text/javascript">
        function yanzheng(){
            var flg=false;
            $("input[name='delid[]']").each(function(){
                if($(this).attr('checked')){
                    flg=true;
                    return 0;
                }

            });
            if(!flg){
                alert('请选择要删除的选项！');
                return false;
            }
           return confirm('确定要删除吗？');
            //return true;
        }
    </script>

</head>


<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li>首页</li>
        <li>列表页</li>
        <li><a href="javascript:window.history.back()">返回</a></li>
    </ul>
</div>
<?php
 $key_depart=I('get.depart_name'); $key_name=I('get.name'); ?>

<div class="rightinfo">

    <div class="tools">
        <form action="/index.php/Applist/Index/hospital.html" method="GET" name="searchForm">
            <img src="/Public/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
            科室名：
            <select class="dfinput" name="depart_name">
                <option value="">请选择科室</option>
                <?php
 if($dep_data): foreach($dep_data as $k=>$v): if($v['depart_name']==I('get.depart_name')) $select='selected="selected"'; else $select=''; ?>
                <option value="<?php echo ($v['depart_name']); ?>" <?php echo $select;?>><?php echo ($v['depart_name']); ?></option>
               <?php endforeach;endif; ?>

            </select>
            姓名:<input type="text" name="name" size="15" class="dfinput" value="<?php echo I('get.name'); ?>" />
            <input type="submit" value=" 搜索 " class="btn" />
        </form>
        <ul class="toolbar" style="float: right;">
            <li class="click"><span><img src="/Public/images/t01.png" /></span><a href="/index.php/Applist/Index/hospital_add">添加</a></li>
        </ul>

    </div>
    <form action="/index.php/Applist/Index/hospital_bdel" method="post" onsubmit="return yanzheng();">

        <table class="tablelist">
            <thead>
            <tr>
                <!--<th><input  type="checkbox" id="selall"/></th>-->
                <!--<th>id</th>-->
                <th>医院名称</th>
                <th>科室名称</th>
                <th>姓名</th>
                <th>电联方式</th>
                <th>网联方式</th>

                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $k=>$v):?>
            <tr>
                <!--<td>-->
                    <!--<input name="delid[]" type="checkbox" value="<?php echo $v['id']; ?>" />-->
                <!--</td>-->
                <!--<td align="center"><?php echo $v['id']; ?></td>-->
                <td ><?php echo $v['hos_name']; ?></td>
                <td ><?php echo str_replace($key_depart,'<font color=red>'.$key_depart.'</font>',$v['depart_name']); ?></td>
                <td ><?php echo str_replace($key_name,'<font color=red>'.$key_name.'</font>',$v['name']); ?></td>
                <td ><?php echo $v['phone']; ?></td>
                <td ><?php echo $v['email']; ?></td>
                <td >
                    <a href="/index.php/Applist/Index/hospital_save/id/<?php echo $v['id']; ?>" title="编辑" class="tablelink">编辑</a>
                    <a onclick="return confirm('确定要删除吗？');" href="/index.php/Applist/Index/hospital_del/id/<?php echo $v['id']; ?>" title="移除" class="tablelink">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
            <tr>
                <!--<td><input type="submit" value="删除所选" /></td>-->
                <td align="right"  colspan="11">
                    <?php echo $page;?>
                </td>
            </tr>
        </table>
    </form>

</div>

</body>

</html>
<script>
    $("#selall").click(function(){
        if($(this).attr("checked"))
            $("input[name='delid[]']").attr("checked", "checked");
        else
            $("input[name='delid[]']").removeAttr("checked");
    });
</script>