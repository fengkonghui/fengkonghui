<?php

/**
 * 会员注册登录
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;

class MemberController extends HomeBaseController {
	
	// 登录
	public function index() {
		$this->display ( "Member:login" );
	}
	// 登录验证
	function dologin() {
		extract ( $_POST );
		// 登录时不需要验证码将验证码功能取消
		if (check_verify ( $verify )) {
			$this->error ( "验证码错误！" );
		} else {
			if ($type == 'personal') {
				if(strpos($user_login_name,'@')!==false){
					$da['user_email'] = array('eq',$user_login_name);
				}else{
					$da['user_tel'] = array('eq',$user_login_name);
				}
				$da['type'] = array('eq',$type);
				$goto = U ( "portal/xdal/index" );
			} else if ($type == 'enterprise') {
				$da = array (
						'user_login_name' => $user_login_name,
						'type' => $type 
				);
				$goto = U ( "portal/center/enterprise" );
			}
			
			$result = M ( 'Members' )->where ( $da )->find ();
			if ($result != null) {
				if ($result ['user_pass'] == sp_password ( $passwd )) {
					// 登入成功页面跳转
					$_SESSION ["MEMBER_type"] = 'local';
					$_SESSION ["MEMBER_id"] = $result ["ID"];
					$_SESSION ['MEMBER_name'] = $result ["user_login_name"];
					session ( "roleid", $result ['role_id'] );
					session ( "type", $result ['type'] );
					session ( "score", $result ['score'] );
					session ( "redcoin", $result ['redcoin'] );
					// 写入此次登录信息
					$data = array (
							'last_login_time' => time (),
							'last_login_ip' => get_client_ip () 
					);
					M ( 'Members' )->where ( array (
							'ID' => $result ["ID"] 
					) )->save ( $data );
					// $this->integrals ( 'login' );
					$this->success ( "登录验证成功！", $goto );
				} else {
					$this->error ( "密码错误！" );
				}
			} else {
				$this->error ( "用户名不存在！" );
			}
		}
	}
	
	// 注册--默认个人注册
	public function register() {
		$this->display ( "Member:register" );
	}
	// 注册--企业注册
	public function registerqy() {
		$this->display ( "Member:registerqy" );
	}
	
	/**
	 * 生成验证码
	 */
	public function sendphone() {
		// 检查是否已经注册
		$phone = I ( 'get.phone' );
		$email = I ( 'get.email' );
		$type = I ('get.type');

		if($type){
			$map['user_tel'] = array('eq',$phone);
			$info = '手机';
		}else{
			$map['user_email'] = array('eq',$email);
			$info = '邮箱';
		}
		$has = M ( 'Members' )->where ($map)->count ();
		if ($has) {
			$this->error ( $info."已注册" );
		} else {
			// 随机码
			$code = rand ( 100000, 999999 );
			if($type){
				$result = $this->sendMESSAGES ( $phone, '【' . C ( 'SENDSMS' ) . '】您的验证码为：' . $code );
			}else{
				$result = SendMail($email,'【' . C ( 'SENDSMS' ) . '】校验码','您的验证码为：'.$code);
			}
			if ($result) {
				session ( 'tel_yz', $code );
				$this->success ( "发送成功！" );
			} else {
				session ( 'tel_yz', null );
				$this->error ( "发送失败！" );
			}
		}
	}
	
	// 注册验证
	function doregister() {
		// 函数，把数组中的键作为变量，值作为变量的值
		extract ( $_POST );
		// 用户名需过滤的字符的正则
		$stripChar = '?<*.>\'';
		if ($user_xy != 1) {
			// 取消注册 验证码 换成是否阅读协议
			$this->error ( '请同意用户协议' );
		} else if (preg_match ( '/[' . $stripChar . ']/is', $user_nickname ) == 1) {
			$this->error ( '用户名中包含' . $stripChar . '等非法字符！' );
		} else if (preg_match ( '/[' . $stripChar . ']/is', $user_login_name ) == 1) {
			$this->error ( '用户名中包含' . $stripChar . '等非法字符！' );
		} else if ($pass != $repass || ! $pass) {
			$this->error ( "两次密码输入不一致！" );
		} else if (strlen ( $pass ) < 5 || strlen ( $pass ) > 12) {
			$this->error ( "密码长度至少5位，最多12位！" );
		} else if ($user_tel_yz != session ( 'tel_yz' )) {
			$this->error ( "校验码输入错误或者过期" );
		} else {
			// 注册个人用户条件
			if ($type == 'personal') {
				$da = array (
						'user_login_name' => $user_login_name,
						'user_tel' => $user_tel,
						'user_email' => $user_email,
						'_logic' => 'OR' 
				);
				$goto = U ( "portal/xdal/index" );
			} else if ($type == 'enterprise') {
				$da = array (
						'user_login_name' => $user_login_name 
				);
				$goto = U ( "portal/center/enterprise" );
			}
			$result = M ( 'Members' )->where ( $da )->count ();
			if ($result) {
				$this->error ( "邮箱或者该手机号已经存在！" );
			} else {
				/*
				 * $data = array( //'user_login_name'	 => $name, //'user_email'		 => $email, 'user_pass'			 => encode($pass, C('DATA_AUTH_KEY')), 'last_login_ip'		 => get_client_ip(), 'create_time'		 => time(), 'last_login_time'	 => time(), 'user_status'		 => '1', );
				 */
				if ($type == 'personal') { // 个人注册信息
					$data = array (
							'user_pass' => encode ( $pass, C ( 'DATA_AUTH_KEY' ) ),
							'last_login_ip' => get_client_ip (),
							'create_time' => time (),
							'last_login_time' => time (),
							'user_status' => '1',
							'user_nickname' => $user_login_name,
							'user_login_name' => $user_login_name,
							'user_tel' => $user_tel,
							'user_email' => $user_email,
							'user_post_level' => $user_post_level,
							'user_yq' => $user_yq,
							'user_city' => $user_city,
							'company_type' => $company_type,
							'type' => 'personal' 
					);
				} else if ($type == 'enterprise') { // 企业注册信息
					$data = array (
							'user_pass' => encode ( $pass, C ( 'DATA_AUTH_KEY' ) ),
							'last_login_ip' => get_client_ip (),
							'create_time' => time (),
							'last_login_time' => time (),
							'user_status' => '1',
							'user_login_name' => $user_login_name,
							'user_nickname' => $user_login_name,
							'company_capital' => $company_capital,
							'company_found_time' => $company_found_time,
							'company_scale' => $company_scale,
							'company_business' => $company_business,
							'company_contactby' => $company_contactby,
							'company_contacttel' => $company_contacttel,
							'user_city' => $city,
							'company_type' => $company_type,
							'type' => 'enterprise' 
					);
				}
				$id = M ( 'Members' )->add ( $data );
				
				// 登入成功页面跳转
				$_SESSION ["MEMBER_id"] = $id;
				$_SESSION ["MEMBER_type"] = 'local';
				$_SESSION ["MEMBER_name"] = $user_login_name;
				$_SESSION ["MEMBER_etype"] = $type;
				$_SESSION ["type"] = $type;
				// $this->integrals ( 'registration' );
				$this->success ( "注册成功！", $goto );
			}
		}
	}
	
	// 绑定本地账号
	function bang() {
		extract ( $_POST );
		if (! isset ( $_SESSION ["MEMBER_id"] )) {
			$this->error ( "登录后才能绑定本地帐户！" );
		} else if ($pass != $repass) {
			$this->error ( "两次密码输入不一致！" );
		} else if (strlen ( $pass ) < 5 || strlen ( $pass ) > 12) {
			$this->error ( "密码长度至少5位，最多12位！" );
		} else {
			$result = M ( 'Members' )->where ( "user_login_name='$name' or user_email='$email'" )->count ();
			if ($result) {
				$this->error ( "用户名或者该邮箱已经存在！" );
			} else {
				$data = array (
						'user_login_name' => $name,
						'user_email' => $email,
						'user_pass' => sp_password ( $pass ),
						'last_login_ip' => get_client_ip (),
						'create_time' => time (),
						'last_login_time' => time (),
						'user_status' => '1' 
				);
				if (M ( 'Members' )->where ( 'ID=' . $_SESSION ["MEMBER_id"] )->save ( $data ))
					$this->success ( "绑定本地帐户成功！" );
				else
					$this->error ( "绑定本地帐户失败！" );
			}
		}
	}
	
	// 退出
	public function logout() {
		session_destroy ();
		$this->redirect ( "portal/index/index" );
	}
	
	// 修改密码
	function changepass() {
		if (IS_POST) {
			if ($_POST ['pass'] != $_POST ['repass']) {
				$this->error ( "两次密码输入不一致！" );
				exit ();
			}
			if (strlen ( $_POST ['pass'] ) < 5 || strlen ( $_POST ['pass'] ) > 12) {
				$this->error ( "密码长度至少5位，最多12位！" );
				exit ();
			}
			$mem = M ( 'Members' );
			$uid = $_SESSION ["MEMBER_id"];
			
			$user_info = $mem->where ( "ID=$uid" )->find ();
			$old_password = $_POST ['inipass'];
			$password = $_POST ['pass'];
			if (sp_password ( $old_password ) == $user_info ['user_pass']) {
				if ($user_info ['user_pass'] == sp_password ( $password )) {
					$this->error ( "新密码不能和原密码相同！" );
				} else {
					$data ['user_pass'] = sp_password ( $password );
					$data ['ID'] = $uid;
					$r = $mem->save ( $data );
					if ($r) {
						$this->success ( "修改成功！" );
					} else {
						$this->error ( "修改失败！" );
					}
				}
			} else {
				$this->error ( "原密码不正确！" );
			}
		} else {
			$this->error ( '提交数据为空！' );
		}
	}
	
	/**
	 * *****
	 * 他人用户信息
	 *
	 * ******
	 */
	// 用户主页
	public function user() {
		if (! I ( 'get.uid' ))
			$this->error ( '用户不存在！' );
		
		$result = M ( "Members" )->where ( "ID=%d", array (
				I ( 'get.uid' ) 
		) )->find ();
		if (! $result)
			$this->error ( '用户不存在！' );
		$this->uid = I ( 'get.uid' );
		$this->assign ( '_info', $result );
		$this->display ();
	}
	
	// 他的发布
	public function trelease() {
		// t的发布
		if (! I ( 'get.uid' ))
			$this->error ( '用户不存在！' );
		
		$result = M ( "Members" )->where ( "ID=%d", array (
				I ( 'get.uid' )
		) )->find ();
		if (! $result)
			$this->error ( '用户不存在！' );
		$this->uid = I ( 'get.uid' );
		$tab = I ( 'get.tab' );
		$memid =  I ( 'get.uid' );
		$release = array ();
		$where ['user_id'] = array (
				'eq',
				$memid 
		);
		switch ($tab) {
			case 'technology' : // 技术
				$result = $this->getPagination ( 'Share', $where );
				foreach ( $result ['data'] as $v ) {
					$release [] = array (
							'url' => U ( 'Portal/zhuanti/jishuxiangqing', array (
									'xq_id' => $v ['ID'] 
							) ),
							'ID' => $v ['id'],
							'time' => date ( 'Y-m-d', $v ['dataline'] ),
							'title' => $v ['fx_title'] 
					);
				}
				break;
			default : // 默认 案例
				$result = $this->getPagination ( 'Wangyou', $where );
				foreach ( $result ['data'] as $v ) {
					$release [] = array (
							'url' => U ( 'Portal/xindai/anlixiangqing', array (
									'wy_id' => $v ['ID'] 
							) ),
							'ID' => $v ['ID'],
							'time' => date ( 'Y-m-d', $v ['dataline'] ),
							'title' => $v ['wy_title'] 
					);
				}
				break;
		}
		$this->assign ( 'page', $result ['show'] );
		$this->assign ( 'release', $release );
		$this->display ( 'trelease' );
	}
	
	
	//他的回答
	public function tmyanswer() {
		// t的发布
		if (! I ( 'get.uid' ))
			$this->error ( '用户不存在！' );
		
		$result = M ( "Members" )->where ( "ID=%d", array (
				I ( 'get.uid' )
		) )->find ();
		if (! $result)
			$this->error ( '用户不存在！' );
		
		$memid = I ( 'get.uid' );
		$tab = I ( 'get.tab' );
		$myanswer = array ();
		if($tab=='debate'){
			$where ['postby'] = array (
					'eq',
					$memid
			);
		}else{
			$where ['user_id'] = array (
					'eq',
					$memid
			);
		}
		
		switch ($tab) {
			case 'technology' : // 技术
				$result = $this->getPagination ( 'Comment_zt', $where );
				foreach ( $result ['data'] as $v ) {
					$myanswer [] = array (
							'url' => U ( 'Portal/zhuanti/jishuxiangqing', array (
									'xq_id' => $v ['credit_id']
							) ),
							'id' => $v ['id'],
							'time' => date ( 'Y-m-d', $v ['create_time'] ),
							'title' => M ( 'Share' )->where ( 'id=%d', array (
									$v ['credit_id']
							) )->getField ( 'fx_title' ),
							'message' => $v ['content']
					);
				}
				break;
			case 'debate' :
				$result = $this->getPagination ( 'Comment', $where );
				foreach ( $result ['data'] as $v ) {
					$myanswer [] = array (
							'url' => U ( 'Portal/Xindaixiangqing/index', array (
									'xd_id' => $v ['credit_id']
							) ),
							'id' => $v ['id'],
							'time' => date ( 'Y-m-d', $v ['create_time'] ),
							'title' => M ( 'Credit' )->where ( 'ID=%d', array (
									$v ['credit_id']
							) )->getField ( 'xd_title' ),
							'message' => $v ['content']
					);
				}
				break;
			default : // 默认 案例
				$result = $this->getPagination ( 'Comment_xd', $where );
				foreach ( $result ['data'] as $v ) {
					$myanswer [] = array (
							'url' => U ( 'Portal/xindai/anlixiangqing', array (
									'wy_id' => $v ['credit_id']
							) ),
							'id' => $v ['id'],
							'time' => date ( 'Y-m-d', $v ['create_time'] ),
							'title' => M ( 'Wangyou' )->where ( 'ID=%d', array (
									$v ['credit_id']
							) )->getField ( 'wy_title' ),
							'message' => $v ['content']
					);
				}
				break;
		}
		$this->uid = I ( 'get.uid' );
		$this->assign ( 'page', $result ['show'] );
		$this->assign ( 'myanswer', $myanswer );
		$this->display (  );
	}
	
	//他的小组
	public function tgroup(){
		if (! I ( 'get.uid' ))
			$this->error ( '用户不存在！' );
		
		$result = M ( "Members" )->where ( "ID=%d", array (
				I ( 'get.uid' )
		) )->find ();
		if (! $result)
			$this->error ( '用户不存在！' );
		$uid =  I ( 'get.uid' );
		$gids = M('GroupExtend')->where("chcek=1 AND uid=%d",array($uid))->getField('gid',true);
		$map['id'] = array('in',$gids);
		$group = M('Group')->where($map)->select();
		$this->uid = I ( 'get.uid' );
		$this->assign('group',$group);
		$this->display();
	}
	
	/********
	 * ta积分  红途币   查询
	* ********/
	public function tintegral(){
		if (! I ( 'get.uid' ))
			$this->error ( '用户不存在！' );
		
		$result = M ( "Members" )->where ( "ID=%d", array (
				I ( 'get.uid' )
		) )->find ();
		if (! $result)
			$this->error ( '用户不存在！' );
		$uid = I ( 'get.uid' );
		//查询
		$tab = I('get.tab');
		switch ($tab) {
			case 'integral' : // 积分
				$where['user'] = $uid;
				$where['integral'] = array('gt','0');
				$this->rows = M('integrals_record')->where($where)->select();
				break;
			case 'coin' : //红途币
				$where['user'] = $uid;
				$where['coin'] = array('gt','0');
				$this->rows = M('integrals_record')->where($where)->select();
				break;
			default : // 积分
				$where['user'] = $uid;
				$where['integral'] = array('gt','0');
				$this->rows = M('integrals_record')->where($where)->select();
				break;
		}
		$this->uid = I ( 'get.uid' );
		$this->display();
	}
	
	/**
	 * 密码找回
	 * **/
	public function retrieve(){
		if(IS_POST){
			if (strlen ( $_POST ['password'] ) < 5 || strlen ( $_POST ['password'] ) > 12) {
				$this->error ( "密码长度至少5位，最多12位！" );
				exit ();
			}
			
			//查询用户id
			$id = M('members')->where(array('user_tel'=>I('post.user_tel')))->getField('ID');
			$data['ID'] = $id;
			$data['user_pass'] = encode ( I('post.password'), C ( 'DATA_AUTH_KEY' ) );
			$data['last_login_time'] = time();
			if(M('members')->save($data)){
				$this->success('重置成功，请重新登录',U('member/index'));
			}else {
				$this->error('重置失败');
			}
		}else{
			$this->display();
		}
	}
	
	//密码找回生成验证码
	public function sendPhone_1() {
		// 随机码
		$code = rand ( 100000, 999999 );
		if ($this->sendMESSAGES ( $phone, '【' . C ( 'SENDSMS' ) . '】您的验证码为：' . $code )) {
			session ( 'tel_yz', $code );
			$this->success ( "发送成功！" );
		} else {
			session ( 'tel_yz', null );
			$this->error ( "发送失败！" );
		}
	}
	//异步请求 验证码
	public function ajaxyz(){
		if(I('post.yz')==session('tel_yz')){
			echo 1;
		}else{
			echo 0;
		}
	}
}
