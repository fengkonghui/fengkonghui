<?php

/**
 * 会员中心
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;

class CenterController extends HomeBaseController {
	public function index() {
		$this->checklogin ();
		$type = $_SESSION ['type'];
		$this->redirect ( $type );
	}
	
	// 会员中心
	public function personal() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		$DbPre = C ( 'DB_PREFIX' );
		// 个人信息
		$user_info = M ( 'Members' )->where ( "ID=" . $memid )->find ();
		$this->assign ( 'user_info', $user_info );
		// 收藏记录
		$sql = 'select b.*
				from ' . $DbPre . 'topic_collect a
				left join ' . $DbPre . 'topic b
				using(topic_id)
				where user_id=' . $memid . ' order by a.collect_time';
		$collection = M ()->query ( $sql );
		$this->assign ( 'collect', $collection );
		// 账号绑定
		$OauthMember = M ( 'OauthMember' );
		$lock ['qq'] = $OauthMember->where ( "status=1 and _from='qq' and lock_to_id=" . $memid )->count ();
		$lock ['sina'] = $OauthMember->where ( "status=1 and _from='sina' and lock_to_id=" . $memid )->count ();
		$this->assign ( 'lock', $lock );
		// 消息列表
		$this->assign ( 'mesComment', $count1 = getMes ( $memid, 'topic_comment' ) );
		$this->assign ( 'mesAnswer', $count2 = getMes ( $memid, 'topic_answer' ) );
		$this->assign ( 'mesCollect', $count3 = getMes ( $memid, 'topic_collect' ) );
		$this->assign ( 'mesCount', count ( $count1 ) + count ( $count2 ) + count ( $count3 ) );
		$this->display ( 'Member:personal' );
	}
	public function enterprise() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		$DbPre = C ( 'DB_PREFIX' );
		// 个人信息
		$user_info = M ( 'Members' )->where ( "ID=" . $memid )->find ();
		$this->assign ( 'user_info', $user_info );
		// 收藏记录
		$sql = 'select b.*
				from ' . $DbPre . 'topic_collect a
				left join ' . $DbPre . 'topic b
				using(topic_id)
				where user_id=' . $memid . ' order by a.collect_time';
		$collection = M ()->query ( $sql );
		$this->assign ( 'collect', $collection );
		// 账号绑定
		$OauthMember = M ( 'OauthMember' );
		$lock ['qq'] = $OauthMember->where ( "status=1 and _from='qq' and lock_to_id=" . $memid )->count ();
		$lock ['sina'] = $OauthMember->where ( "status=1 and _from='sina' and lock_to_id=" . $memid )->count ();
		$this->assign ( 'lock', $lock );
		// 消息列表
		$this->assign ( 'mesComment', $count1 = getMes ( $memid, 'topic_comment' ) );
		$this->assign ( 'mesAnswer', $count2 = getMes ( $memid, 'topic_answer' ) );
		$this->assign ( 'mesCollect', $count3 = getMes ( $memid, 'topic_collect' ) );
		$this->assign ( 'mesCount', count ( $count1 ) + count ( $count2 ) + count ( $count3 ) );
		$this->display ( 'Member:enterprise' );
	}
	
	// 个人资料
	public function means() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		if (IS_POST) {
			M ( 'Members' )->where ( "id=%d", array (
					$memid 
			) )->save ( array (
					'user_city' => I ( 'post.user_city' ),
					'company_type' => I ( 'post.company_type' ),
					'user_post_level' => I ( 'post.user_post_level' ) 
			) );
			$this->success ( '修改成功!' );
		} else {
			// 个人信息
			$user_info = M ( 'Members' )->where ( "id=%d", array (
					$memid 
			) )->find ();
			$this->assign ( 'user_info', $user_info );
			$this->display ( 'Member:means' );
		}
	}
	
	// 修改头像
	public function setface() {
		$this->checklogin ();
		$this->display ( 'Member:setface' );
	}
	
	// 上传到空间
	public function upavatar() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		$post_input = 'php://input';
		$save_path = './static/upload/face/';
		is_dir ( $save_path ) || mkdir ( $save_path );
		$postdata = file_get_contents ( $post_input );
		if (isset ( $postdata ) && strlen ( $postdata ) > 0) {
			$filename = $memid . '.jpg';
			$picname = substr ( $save_path, 0, 25 ) . $filename;
			$handle = fopen ( $picname, 'w+' );
			fwrite ( $handle, $postdata );
			fclose ( $handle );
			if (is_file ( $picname )) {
				echo 'success';
				exit ();
			} else {
				die ( 'error' );
			}
		} else {
			die ( '没有图片信息!' );
		}
	}
	
	// 我的发布
	public function release() {
		$this->checklogin ();
		$tab = I ( 'get.tab' );
		$memid = $_SESSION ["MEMBER_id"];
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
		$this->display ( 'Member:release' );
	}
	public function myanswer() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		$tab = I ( 'get.tab' );
		$myanswer = array ();
		$where ['user_id'] = array (
				'eq',
				$memid 
		);
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
		$this->assign ( 'page', $result ['show'] );
		$this->assign ( 'myanswer', $myanswer );
		$this->display ( 'Member:myanswer' );
	}
	
	// 修改密码
	public function password() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		if (IS_POST) {
			$password = I ( 'post.password' );
			$ol_password = I ( 'post.ol_password' );
			$ol2_password = I ( 'post.ol2_password' );
			$members = M ( 'Members' );
			if ($ol_password != $ol2_password) {
				$this->error ( '确认密码与新密码不同！' );
			}
			$user_pass = $members->where ( "ID=%d", array (
					$memid 
			) )->getField ( 'user_pass' );
			if ($user_pass != encode ( $password, C ( 'DATA_AUTH_KEY' ) )) {
				$this->error ( '原密码错误，请重新输入' );
			}
			$members->where ( "ID=%d", array (
					$memid 
			) )->setField ( 'user_pass', encode ( $ol_password, C ( 'DATA_AUTH_KEY' ) ) );
			session ( null );
			$this->success ( '修改成功,请重新登录!', U ( 'portal/member/index' ) );
		} else {
			$this->display ( 'Member:password' );
		}
	}
	
	// 修改手机
	public function mobile() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		if (IS_POST) {
			if (! preg_match ( "/^1[3-5,8]{1}[0-9]{9}$/", I ( 'post.mobile' ) )) {
				$this->error ( '手机号格式错误！' );
			}
			if (I ( 'post.user_tel_yz' ) != session ( 'tel_yz' )) {
				$this->error ( '校验码错误！' );
			}
			M ( 'Members' )->where ( "ID=%d", array (
					$memid 
			) )->setField ( 'user_tel', I ( 'post.mobile' ) );
			$this->success ( '修改成功！' );
		} else {
			$user_tel = M ( 'Members' )->where ( "id=%d", array (
					$memid 
			) )->getField ( 'user_tel' );
			$this->assign ( 'user_tel', $user_tel );
			$this->display ( 'Member:mobile' );
		}
	}
	
	// 获取验证码
	public function getCode() {
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		$user_tel = M ( 'Members' )->where ( "ID=%d", array (
				$memid 
		) )->getField ( 'user_tel' );
		// 随机码
		$code = rand ( 100000, 999999 );
		if ($this->sendMESSAGES ( $user_tel, '【' . C ( 'SENDSMS' ) . '】你正在注册' . C ( 'SENDSMS' ) . '，校验码：' . $code . '打死都不能告诉别人哦！' )) {
			session ( 'tel_yz', $code );
			$this->success ( "成功！" );
		} else {
			session ( 'tel_yz', null );
			$this->error ( "失败！" );
		}
	}
	
	// 编辑简介
	public function profileEidt() {
		$this->checklogin ();
		$data ['profile'] = I ( 'post.profile' );
		$result = M ( 'Members' )->where ( "ID=" . $_SESSION ["MEMBER_id"] )->save ( $data );
		$this->success ( '修改成功！' );
	}
	
	// 修改签名
	function changesign() {
		if (strlen ( $sign = strip_tags ( $_POST ['sign_'] ) ) > 100) {
			$this->error ( '签名字数限制100个字符！' );
			exit ();
		}
		;
		if (M ( 'Members' )->where ( "ID=" . $_SESSION ["MEMBER_id"] )->setField ( 'sign_words', $sign )) {
			$this->success ( '签名修改成功！' );
		} else {
			$this->error ( '签名修改失败！' );
		}
	}
	
	// 修改头像
	function changeHead() {
		import ( 'ORG.Net.UploadFile' );
		$upload = new UploadFile ();
		$upload->maxSize = 11048576;
		$upload->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg' 
		);
		$upload->savePath = C ( "UPLOADPATH" );
		$upload->thumb = true;
		$upload->thumbMaxWidth = "120";
		$upload->thumbMaxHeight = "120";
		$upload->thumbRemoveOrigin = true;
		$upload->saveRule = 'uniqid';
		if (! $upload->upload ()) {
			$this->error ( $upload->getErrorMsg (), U ( 'Member/center/index' ) );
		} else {
			$info = $upload->getUploadFileInfo ();
			// 添加
			$data = array (
					'_unique' => uniqid (),
					'filename' => 'thumb_' . $info [0] ['savename'],
					'filepath' => C ( "UPLOADPATH" ),
					'uploadtime' => time (),
					'status' => '1' 
			);
			$head_url = '/index.php?g=asset&m=download&key=' . $data ['_unique'];
			$memdo = M ( 'Members' )->where ( 'ID=' . $_SESSION ["MEMBER_id"] )->setField ( 'user_pic_url', $head_url );
			// dump($head_url);dump($memdo);
			if (M ( "Asset" )->add ( $data ) && $memdo) {
				$this->success ( '头像修改成功！' );
			} else {
				$this->error ( '头像修改失败！' );
			}
		}
	}

	//我的小组
	public function group(){
		$uid = $_SESSION ["MEMBER_id"];
		$gids = M('GroupExtend')->where("uid=%d",array($uid))->getField('gid',true);
		$map['id'] = array('in',$gids);
		$group = M('Group')->where($map)->select();
		$this->assign('group',$group);
		$this->display('Member:group');
	}

	//创建小组
	public function build_group(){
		$uid = $_SESSION ["MEMBER_id"];
		if(IS_POST){
			if(M('Members')->where("ID=%d",array($uid))->getField('group') < 4){
				$this->error('需要P3及以上用户才能创建');
			}
			if($_FILES['img']==''){
				$this->error('小组图标不能为空');
			}
			if(I('post.name')==''){
				$this->error('小组名称不能为空');
			}
			if(I('post.cid')==''){
				$this->error('小组分类必须选择');
			}

			$upload = new \Think\Upload();
			$upload->maxSize = 3145728;
			$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
			$upload->rootPath ='./Uploads/';
			$upload->savePath = date('Ymd',time);
			$info = $upload->upload();
			if(!$info) {
				$this->error($upload->getError());
			}
			if(M('Group')->where("name='%s'",array(I('post.name')))->count() > 0){
				$this->error('小组名已存在');
			}
			$gid = M('Group')->add(array(
					'uid' => $uid,
					'img' => '/Uploads/'.$info['img']['savepath'].$info['img']['savename'],
					'cid' => I('post.cid'),
					'name' => I('post.name'),
					'chcek' => 1,
				));
			
				$result = M('GroupExtend')->add(array(
						'uid' => $uid,
						'gid' => $gid,
						'chcek' => 1
					));
			if($result){
				$this->success('创建成功！');
			}else{
				$this->error('创建小组失败！');
			}
		}else{
			$_class = M('GroupClass')->select();
			$this->assign('_class',$_class);
			$this->display('Member:build_group');
		}
	}
	
	/********
	 * 积分  红途币   查询
	 * ********/
	public function integral(){
		$uid = $_SESSION ["MEMBER_id"];
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
		$this->display('Member:integral');
	}
}
