<?php

/* 项目名称，不可更改 */
define ( 'APP_NAME', 'Application' );

/* 定义应该根目录 */
define ( 'CMF_ROOT', getcwd () );

/* 数据写入目录 */
define ( 'CMF_DATA', CMF_ROOT . '/../' . APP_NAME . '/CMFData' );

/* 项目路径，不可更改 */
define ( 'APP_PATH', CMF_ROOT . '/../' . APP_NAME . '/' );

$app_env = getenv ( 'APPLICATION_ENV' );
if (in_array ( $app_env, array (
		'dev',
		'staging',
		'production' 
) )) {
	define ( 'APP_DEBUG', $app_env != 'production' );
	define ( 'APP_STATUS', $app_env );
} else {
	define ( 'APP_STATUS', 'production' );
}


/* 检测系统是否需要安装 */
if (! file_exists ( "./static/data/install.lock" )) {
	$_GET ['m'] = 'install';
}

/* 版本号 */
define ( "CMF_VERSION", 'Extend 1.0' );

// 载入框架核心文件
require '../ThinkPHP/ThinkPHP.php';
