<?php

/**
 * 系统配置文件
 */
return array(
	/* Default Module */
	'DEFAULT_MODULE' => 'Portal',
	/* cookies Prefix */
	"COOKIE_PREFIX" => 'Ob8M4q_',
	/* Potal Tpl Path */
	'CMF_TPL_PATH' => CMF_ROOT . '/static/Portal/',
	/* CMF Config Path */
	'CMF_CONF_PATH' => CMF_DATA . '/config/',
	/* CMF Databack Path */
	'CMF_DATA_PATH' => CMF_DATA . '/backup/',
	/* TMPL Parse String  */
	'TMPL_PARSE_STRING' => array (
				'__TMPL__' => __ROOT__ . '/static/Portal/default' 
		),
	/*  TMPL_EXCEPTION_FILE */
	'TMPL_ACTION_ERROR' => APP_PATH . 'Common/Tpl/dispatch_jump.tpl',
	'TMPL_ACTION_SUCCESS' => APP_PATH . 'Common/Tpl/dispatch_jump.tpl',
	// 'TMPL_EXCEPTION_FILE' => APP_PATH . 'Common/Tpl/app_exception.tpl'
	'SENDSMS' => '红途风控汇',
	
	/**
	 * ****************************************************
	 */
	/**
	 * ******			积分配置					*******
	 */
	/**
	 * ****************************************************
	
	// 登录 积分 + 5
	'LOGIN' => '5',
	// 注册 积分 +20 红途币 +20
	'REGISTRATION' => '20',
	'COIN_REGISTRATION' => '20',
	// 发表评论 积分 + 5
	'COMMENT' => '5',
	// 回复他人评论 积分 + 5
	'respond_comment' => '5', 
	// 提问 积分+5
	'put_questions_to' => '10',
	//评论/问答被点赞 积分 +5
	'praise' => '5',
	//加入小组 积分 +10
	'join_group' => '10',
	//发组内话题 积分 +20
	'topic_group' => 20,
	//普通案例分享 积分 +30
	'case_sharing' => 30,
	//分享案例加精 积分+50 红途币 +50
	'case_jiajing' => 50,
	'coin_case_jiajing' => 50,
	//普通技术分享 积分 + 30
	'ordinary_share_technology' => 30,
	//加精技术分享 积分 + 50 红途币 +50
	'jiajing_share_technology' => 50,
	'coin_jiajing_share_technology' => 50,
	//投票 积分 +20
	'the_vote' => 20,
	//被举报 积分 - 10
	'report' => 10, */
);
