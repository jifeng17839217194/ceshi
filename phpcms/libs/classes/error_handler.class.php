<?php
/**
 * 文件名称：baseErrorHandler.class.php
 * 摘    要：错误拦截器父类
 */

pc_base::load_sys_class('error_handler_exception', '', 0);
 // 异常类
class error_handler
{

    public $argvs = array();

    public $memoryReserveSize = 262144;
 // 备用内存大小
    private $_memoryReserve;
 // 备用内存
    
    /**
     * 方 法：注册自定义错误、异常拦截器
     * 参 数：void
     * 返 回：void
     */
    public function register()
    {
        ini_set('display_errors', 0);
        
        set_exception_handler(array(
            $this,
            'handleException'
        )); // 截获未捕获的异常
        
        set_error_handler(array(
            $this,
            'handleError'
        )); // 截获各种错误 此处切不可掉换位置
                                                        
        // 留下备用内存 供后面拦截致命错误使用
        $this->memoryReserveSize > 0 && $this->_memoryReserve = str_repeat('x', $this->memoryReserveSize);
        
        register_shutdown_function(array(
            $this,
            'handleFatalError'
        )); // 截获致命性错误
    }

    /**
     * 方 法：取消自定义错误、异常拦截器
     * 参 数：void
     * 返 回：void
     */
    public function unregister()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * 方 法：处理截获的未捕获的异常
     * 参 数：Exception $exception
     * 返 回：void
     */
    public function handleException($exception)
    {
        $this->unregister();
        try {
            $this->logException($exception);
            exit(1);
        } catch (Exception $e) {
            exit(1);
        }
    }

    /**
     * 方 法：处理截获的错误
     * 参 数：int $code 错误代码
     * 参 数：string $message 错误信息
     * 参 数：string $file 错误文件
     * 参 数：int $line 错误的行数
     * 返 回：boolean
     */
    public function handleError($code, $message, $file, $line)
    {
        // 该处思想是将错误变成异常抛出 统一交给异常处理函数进行处理
        if ((error_reporting() & $code) && ! in_array($code, array(
            E_NOTICE,
            E_WARNING,
            E_USER_NOTICE,
            E_USER_WARNING,
            E_DEPRECATED
        ))) { // 此处只记录严重的错误 对于各种WARNING NOTICE不作处理
            $exception = new error_handler_exception($message, $code, $code, $file, $line);
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            array_shift($trace); // trace的第一个元素为当前对象 移除
            foreach ($trace as $frame) {
                if ($frame['function'] == '__toString') { // 如果错误出现在 __toString 方法中 不抛出任何异常
                    $this->handleException($exception);
                    exit(1);
                }
            }
            throw $exception;
        }
        return false;
    }

    /**
     * 方 法：截获致命性错误
     * 参 数：void
     * 返 回：void
     */
    public function handleFatalError()
    {
        unset($this->_memoryReserve); // 释放内存供下面处理程序使用
        
        $error = error_get_last(); // 最后一条错误信息
        
        if (error_handler_exception::isFatalError($error)) { // 如果是致命错误进行处理
            $exception = new error_handler_exception($error['message'], $error['type'], $error['type'], $error['file'], $error['line']);
            $this->logException($exception);
        }
    }

    /**
     * 方 法：获取服务器IP
     * 参 数：void
     * 返 回：string
     */
    final public function getServerIp()
    {
        $serverIp = '';
        if (isset($_SERVER['SERVER_ADDR'])) {
            $serverIp = $_SERVER['SERVER_ADDR'];
        } elseif (isset($_SERVER['LOCAL_ADDR'])) {
            $serverIp = $_SERVER['LOCAL_ADDR'];
        } elseif (isset($_SERVER['HOSTNAME'])) {
            $serverIp = gethostbyname($_SERVER['HOSTNAME']);
        } else {
            $serverIp = getenv('SERVER_ADDR');
        }
        
        return $serverIp;
    }

    /**
     * 方 法：获取当前URI信息
     * 参 数：void
     * 返 回：string $url
     */
    public function getCurrentUri()
    {
        $uri = '';
        if ($_SERVER["REMOTE_ADDR"]) { // 浏览器浏览模式
            $uri = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        } else { // 命令行模式
            $params = $this->argvs;
            $uri = $params[0];
            array_shift($params);
            for ($i = 0, $len = count($params); $i < $len; $i ++) {
                $uri .= ' ' . $params[$i];
            }
        }
        return $uri;
    }

    /**
     * 方 法：记录异常信息
     * 参 数：error_handler_exception $e 错误异常
     * 返 回：boolean 是否保存成功
     */
    final public function logException(error_handler_exception $e)
    {
        $error = array(
            'add_time' => date('Y-m-d H:i:s'),
            'title' => error_handler_exception::getName($e->getCode()), // 这里获取用户友好型名称
            'message' => $e->getMessage(),
            'server_ip' => $this->getServerIp(),
            'code' => error_handler_exception::getLocalCode($e->getCode()), // 这里为各种错误定义一个编号以便查找
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'url' => $this->getCurrentUri(),
            'trace' => $e->getTrace()
        );
        $this->logError($error);
    }

    /**
     * 方 法：记录异常信息
     * 参 数：array $error = array(
     * 'time' => int,
     * 'title' => 'string',
     * 'message' => 'string',
     * 'code' => int,
     * 'server_ip' => 'string'
     * 'file' => 'string',
     * 'line' => int,
     * 'url' => 'string',
     * );
     * 返 回：boolean 是否保存成功
     */
    public function logError($error)
    {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"] == 'xmlhttprequest')){
            // 是ajax请求
            header("Content-Type: application/json; charset=utf-8");
            exit(json_encode(['code'=>500,'msg'=>$error['message'],'data'=>$error]));
        } else {
            // 不是ajax请求
            include $this->admin_tpl('exception','admin');
        }
        //error_log(date('m-d H:i:s',SYS_TIME).' | '.$errno.' | '.str_pad($errstr,30).' | '.$errfile.' | '.$errline."\r\n", 3, CACHE_PATH.'error_log.php');
        
    }
    
    /**
     * 加载后台模板
     * @param string $file 文件名
     * @param string $m 模型名
     */
    final public static function admin_tpl($file, $m = '',$c = '') {
        $m = empty($m) ? ROUTE_M : $m;
        if(empty($m)) return false;
        return PC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$c.DIRECTORY_SEPARATOR.$file.'.tpl.php';
    }
}