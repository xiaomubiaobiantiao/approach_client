<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加</title>
    <link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/js/jquery.js"></script>
    <script type="text/javascript">
    function isEmpty(){
        var runForm=document.addForm;
        if($.trim(runForm.field_name.value)==''){
            alert('请填写字段名称！');
            return false;
        }
        if($.trim(runForm.field_value.value)==''){
            alert('请填写字段值！');
            return false;
        }
        return true;
    }
    </script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li>首页</li>
        <li>表单</li>
        <li><a href="javascript:window.history.back()">返回</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>操作界面</span></div>
<form name="addForm">
    <input type="hidden" name="id" value="<?php echo ($one_data['id']); ?>" id="fid"/>
    <ul class="forminfo">

        <li><label>字段名称：</label><input name="field_name" id="field_name" type="text" class="dfinput" value="<?php echo ($one_data['field_name']); ?>"/><font >示例：PHP版本</font></li>
        <li><label>字段值</label><input name="field_value" id="field_value" type="text" class="dfinput"  value="<?php echo ($one_data['field_value']); ?>"/><font>示例：5.5.12</font></li>
        <li><label>&nbsp;</label><input id="subBtn" type="submit" class="btn" value="确认保存"/></li>
    </ul>

</form>
<form>
    <table class="tablelist">

        <thead>
        <tr>

            <th>字段名称</th>
            <th>字段值</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data): foreach($data as $k=>$v): ?>
            <tr>
                <td><?php echo ($v['field_name']); ?></td>
                <td><?php echo ($v['field_value']); ?></td>
                <td>
                    <a href="#" title="编辑" class="tablelink"  onclick="modify(<?php echo ($v['id']); ?>)">编辑</a>
                    <a href="#" title="删除" class="tablelink"  id="<?php echo ($v['id']); ?>" onclick="del(this.id)">删除</a>
                </td>
            </tr>
         <?php endforeach;endif;?>
        </tbody>
    </table>
</form>
</div>
</body>
</html>
<script>
    $("#subBtn").click(function(){
        var field_name=$("#field_name").val();
        var field_value=$("#field_value").val();
        var field_id=$("#fid").val();
        if(field_name==''){
            alert('请填写字段名称！');
            return false;
        }
        if(field_value==''){
            alert('请填写字段值！');
            return false;
        }
        if(field_id){
            //执行修改操作
            //alert(111);
            $.ajax({
                'type':'post',
                'url':'/index.php/Applist/Index/ajax_save',
                'data':{field_name:field_name,field_value:field_value,field_id:field_id},
                success:function(data){
                    //console.log(data);
//                    if(data=='ok'){
                    $("#field_name").attr('value','');
                    $("#field_value").val('');
                    $("#fid").val('');
                        alert("保存成功");
                       window.location.reload();

//                    }else{
//                       alert("修改失败");
//                    }
                },
                error:function(e){

                }
            });
        }else{
            //alert(222);
            //执行添加操作
            $.ajax({
                'type':'post',
                'url':'/index.php/Applist/Index/ajax_add',
                'data':{field_name:field_name,field_value:field_value},
                success:function(data){
                    //alert(data);
                    if(data=='ok'){
                        alert("添加成功");
                        window.location.reload();
                    }else{
                        alert("添加失败");
                    }
                },
                error:function(e){

                }
            });
        }

    });
function modify(id){
    var field_id=id;
    $.ajax({
        'type':'post',
        'url':'/index.php/Applist/Index/ajax_mod',
        'data':{field_id:field_id},
        'dataType':'json',
        success:function(data){
          // console.log(data.field_name);
            $("#field_name").attr('value',data.field_name)
            $("#field_value").attr('value',data.field_value)
            $("#fid").attr('value',data.id)

        }
    });
}
function del(id){
    if(confirm("确认要删除吗？")){
        var field_id=id;
        $.ajax({
            'type':'post',
            'url':'/index.php/Applist/Index/ajax_del',
            'data':{field_id:field_id},
            success:function(data){
                if(data=='ok'){
                    alert("删除成功");
                    window.location.reload();
                }else{
                    alert("删除失败");
                }
            }
        });
    }

}
</script>