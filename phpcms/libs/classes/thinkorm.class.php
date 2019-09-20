<?php

function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR .'think-orm'. DIRECTORY_SEPARATOR . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');

$default = "default";
$db_config = pc_base::load_config('database',$default);

\think\Db::setConfig([
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => $db_config['hostname'],
    // 数据库名
    'database'        => $db_config['database'],
    // 用户名
    'username'        => $db_config['username'],
    // 密码
    'password'        => $db_config['password'],
    // 端口
    'hostport'        => $db_config['port'],
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => $db_config['charset'],
    // 数据库表前缀
    'prefix'          => $db_config['tablepre'],
    // 数据库调试模式
    'debug'           => false,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => '',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
    // Builder类
    'builder'         => '',
    // Query类
    'query'           => '\\think\\db\\Query',
    // 是否需要断线重连
    'break_reconnect' => false,
    // 默认分页设置
    'paginate' => [
        'type'     => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ]
]);