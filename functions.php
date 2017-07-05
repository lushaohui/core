<?php
function p($var){
    echo "<pre>".print_r($var,true)."</pre>";
}
function u($url){
    $path = '';//定义一个空的变量给它默认值为空字符串；
    //将字符串分割为数组；因为在跳转的时候需要跳转到具体的页面，所以我们需要根据需求组合出不同的路径，就必须对$url进行分割
    $arr = explode('/',$url);
    //用count统计数组的长度
    switch (count($arr)){
        //u('index')
        //如果长度为1,则表示进入同一模块下相同类中的不同方法
        case 1:
            $path = '?s=' . MODULE . '/' . CONTROLLER . '/' . $arr[0];
            break;
        //u('arc/lists')
        //如果长度为2,则表示进入同一模块下不同类中的不同方法
        case 2:
            $path = '?s=' . MODULE . '/' . $arr[0] . '/' . $arr[1];
            break;
        case 3:
            //如果长度为1,则表示进入不同模块下不同类中的不同方法

        $path = '?s=' . $arr[0] . '/' . $arr[1] . '/' . $arr[2];

    }
    //将组合出的路径返回
    return __ROOT__ . $path;
}