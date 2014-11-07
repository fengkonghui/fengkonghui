<?php
$site_config = ( array ) F ( 'site_options', '', C ( 'CMF_CONF_PATH' ) );
$sdk_config = ( array ) F ( 'sdk_options', '', C ( 'CMF_CONF_PATH' ) );

$config = array (
		'DEFAULT_THEME' => 'default', // 默认模板主题名称
		'TMPL_TEMPLATE_SUFFIX' => '.html', // 默认模板文件后缀
		'VIEW_PATH' => CMF_ROOT . '/static/',

		'OAUTH'                 => array(
	        'QQ_APPKEY'         => '101161180',
	        'QQ_APPSECRETKEY'   => '3ea8c3cbbda3b4ab8b552f474eca6c38',
	        'QQ_SCOPE'          => '',
	        'QQ_CALLBACK'       => 'http://hongtuwang.com/Portal/user/auth/type/qq',
	        'WEIBO_APPKEY'      => '1332614169',
	        'WEIBO_APPSECRETKEY'=> 'e5162a80f92f0f5110220adbf7542052',
	        'WEIBO_SCOPE'       => '',
	        'WEIBO_CALLBACK'    => 'http://fengkong.hongtuwang.com/portal/user/auth/type/weibo',
	    ),
);

return array_merge ( $config, $site_config, $sdk_config );
