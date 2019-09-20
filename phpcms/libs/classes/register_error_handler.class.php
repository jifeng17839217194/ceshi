<?php

/**
 * 调试错误模式:
 * 0                =>            非调试模式，不显示异常、错误信息但记录异常、错误信息
 * 1                =>            调试模式，显示异常、错误信息但不记录异常、错误信息
 */
define('DEBUG_ERROR', 0);
pc_base::load_sys_class('error_handler', '', 0);

class register_error_handler
{
    /**
     * 方      法：注册异常、错误拦截
     * 参      数：void
     * 返      回：void
     */
    public static function register()
    {
        global $argv;
        if(DEBUG_ERROR)
        {//如果开启调试模式
            ini_set('display_errors', 1);
            return;
        }
        
        //如果不开启调试模式
        ini_set('error_reporting', -1);
        ini_set('display_errors', 0);
        $handler = new error_handler();
        $handler->argvs = $argv;//此处主要兼容命令行模式下获取参数
        $handler->register();
    }
}
