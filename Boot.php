<?php
/**
 * Created by PhpStorm.
 * User: lushaohui
 * Date: 2017/6/28
 * Time: 13:44
 */

namespace lushaohui\core;

/**
 * 框架启动类
 * Class Boot为框架的引擎类，通过Boot类可以加载monitor中的任何方法，在整个框架中起到至关重要的作用
 * @package monitor\core
 */
class Boot
{
    public static function run(){
        //静态调用init方法，初始化框架
        self::init();
        //静态调用appRun方法，执行应用


        self::appRun();

    }
    public static function init(){
        //检测session id是否存在；2.如果存在则证明session已经开启，偶不存在，则开启session；3.因为在操作验证码的时候需要用到，如果不开启验证码出不来
        session_id()||session_start();
        //设置时区；2.为了防止出现时间不准确的现象;3.prc为东八区
        date_default_timezone_set('PRC');
        //定义IS_POST常量；2.因为在写登录、注册以及发表、修改、上传都是通过form表单进行提交的，而提交的方式一般都是post提交，
        //因为post提交更安全
        define ('IS_POST',$_SERVER['REQUEST_METHOD']=='POST'?true:false);
        //定义__ROOT__常量;2.目的是为了获取完整的文件路径
        define('__ROOT__','http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
        //print_r(__ROOT__);
        //p出来的结果：http://localhost/php-start/Homework/0628/MyFrame/public/index.php


    }
    public static function appRun(){
        if (isset($_GET['s'])){
            //在地址栏输入index.php?s=home/entry/index
            // p($_GET);
            //p出来的结果是一个一维关联数组Array( [s] => home/entry/index  )其实就是一个字符串

            //将$_GET获得的字符串进行分割；2.explode函数返回由字符串组成的数组，每个元素都是 string 的一个子串，它们被字符串 delimiter 作为边界点分割出来。3.这样我们就可以将模块、类和方法单独取出来
            $info = explode('/',$_GET['s']);
            //p($info);
            //p出来的结果
//      Array([0] => home
//            [1] => entry
//            [2] => index  )
            //获得模块；2.上面p出来的结果我们可以看出来home对应的是$info[0]
            $m=strtolower($info[0]);
            //获得控制器类；2.上面p出来的结果我们可以看出来entry对应的是$info[1]
            $c=strtolower($info[1]);
            //获得方法；2.上面p出来的结果我们可以看出来index对应的是$info[2]
            $a=strtolower($info[2]);
        }else{ //如果$_GET['s']不存在，那么就进入默认的模块
            //默认进入的模块
            $m = 'home';
            // 默认进入的控制器
            $c = 'entry';
            //默认执行方法
            $a = 'index';
        }
        //定义MODULE常量；2。以后在加载模板组合完整路径的时候会用到
        define('MODULE',$m);
        //定义CONTROLLER常量；2。以后在加载模板组合完整路径的时候会用到
        define('CONTROLLER',$c);
        //定义ACTION常量；2。以后在加载模板组合完整路径的时候会用到
        define('ACTION',$a);

        //将类名首字母转成大写；2.因为类名首字母就是大写的
        $controller=ucfirst($c);
        //1.组合完整的类名；2.因为需要进行实例化调用方法实现相应的功能；3.我们在上面将控制器模块以及方法单独分割了出来，而在应用中会进入哪个模块实例化类调用相应的方法是不确定的，所以不能将其写死，在上面的操作中我们定义了三个常量，这里就可以拼接出完整的类名了
        // app\home\model123\Entry
        $class="\app\\{$m}\controller\\{$controller}";
        //实例化类；2.echo的时候会自动触发__tostring方法
        echo call_user_func_array([new $class,$a],[]);
        //相当于 echo new app\home\model123\Entry();

    }
}