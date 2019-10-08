<?php
/**
 * @author hupengyin
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller{
    public function login(){
        $this->success('登陆成功！',U('Home/Index/main'));
        // if(IS_POST){
        //     $model=D('User');
        //     if($model->create()){
        //         $ret=$model->login();
        //         if($ret===TRUE){
        //             $this->success('登陆成功！',U('Home/Index/main'));
        //             exit;
        //         }
        //         elseif($ret==-1)
        //             $this->error('用户名不存在！');
        //         elseif($ret==-2)
        //             $this->error('密码错误！');

        //     }
        //     else
        //         $this->error($model->getError());
        // }
        // $this->display();
    }
    public function logout(){
        $model =  D('User');
        $model->logout();
        $this->success('已退出!', U('login'));
        exit;
    }
}
?>