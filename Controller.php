<?php
/**
 * Created by PhpStorm.
 * User: lushaohui
 * Date: 2017/6/28
 * Time: 20:19
 */

namespace monitor\core;


class Controller
{
    //定义一个私有的属性，并给其默认的值，即跳转路径
    private $url='window.history.back()';
    //声明一个私有的方法，在本类和子类中都可以被调用;目的是为了让其子类继承该方法
    protected function go($url=''){
        //如果没有调用此方法即$url为空的时候，就让它跳回上一页
        if (empty($url)){
            $this->url='window.history.back()';
        }else{//如果调用了此方法，就让其跳回指定的页面
            $this->url="location.href='{$url}'";
        }
        //返回对象；2.目的是为了链式调用。
        return $this;
    }
    protected function message($msg){
        //加载模板文件
        include './view/message.php';
        exit;

    }
}