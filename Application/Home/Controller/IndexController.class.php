<?php
/**
 * @author hupengyin
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function __construct()
    {
        // 先调用父类构造函数
        parent::__construct();
        // 判断登录状态，必须登录了才能访问这个控制器中的方法
        // if(!session('id'))
        //     $this->error('必须先登录！', U('Home/Login/login'));
        // 判断当前用户有没有权限
        //$privilege = session('privilege');
        // 欢迎页面可以直接访问
        // if(MODULE_NAME == 'Home' && CONTROLLER_NAME == 'Index')
        //     return TRUE;
        // else
        // {
        //     // 循环所有的权限判断有没有当前正在访问的地址对应的权限
        //     foreach ($privilege as $k => $v)
        //     {
        //         if(strtoupper($v['module_name']) == strtoupper(MODULE_NAME) &&
        //             strtoupper($v['controller_name']) == strtoupper(CONTROLLER_NAME) &&
        //             strtoupper($v['action_name']) == strtoupper(ACTION_NAME))
        //             return TRUE;
        //     }
        //     $this->error('无权访问');
        //}
    }

    public function index(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function left(){
        $this->display();
    }
    public function right(){
        $this->display();
    }
    public function index1(){
       //获得系统进行的状态
        // $p_num=M('Product')->count();//厂家信息
        // $hos_num=M('Hospital')->count();//医院信息
        // $inter_num=M('Interface')->count();//接口的信息
        // $file_num=M('File')->count();//文档的信息
        // $daily_num=M('Daily')->count();//实施日志信息
        // $this->assign(array(
        //     'p_num'=>$p_num,
        //     'hos_num'=>$hos_num,
        //     'inter_num'=>$inter_num,
        //     'file_num'=>$file_num,
        //     'daily_num'=>$daily_num
        // ));
        $this->display();
    }
    public function main(){
        $this->display();
    }




    
}