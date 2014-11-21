<?php

namespace Portal\Controller;

use Common\Controller\HomeBaseController;

class LifeController extends HomeBaseController {
	public function index() {
		//问答
		$news = M('News')->order('time desc')->limit(4)->select();
		//信贷感悟 标签
		$articles_type = M('ArticlesType')->order('time desc')->select();
		//小组分类
		$group_class = M('GroupClass')->order('ordination desc,dateline desc')->select();
		//推荐阅读
		$rec_yuedui = M ( 'TuijianYuedui' )->where('recommend=1')->limit (9)->select();
		//轮番图片
		$this->img = M('xdimg')->limit(5)->select();
		$this->assign('news',$news);
		$this->assign('group_class',$group_class);
		$this->assign('articles_type',$articles_type);
		$this->assign('rec_yuedui',$rec_yuedui);
		$this->display();
	}

	//发布问题
	public function questions(){
		$uid = $_SESSION ["MEMBER_id"];
		if($uid==''){
			$this->ajaxReturn(array('status'=>201,'info'=>'请登录后再发布'));
		}
		$questions = I('post.questions','','strip_tags');
		$result = M('Ask')->add(array('uid'=>$uid,'content'=>$questions,'dateline'=>time()));
		if($result){
			$this->integrals('put_questions_to');
			$this->ajaxReturn(array('status'=>200,'info'=>'发布成功！'));
		}else{
			$this->ajaxReturn(array('status'=>201,'info'=>'发布失败，请刷新后重试'));
		}
	}

	//最新信息详情
	public function news(){
		$id = I('get.id');
		if(!$id){
			$this->error('网络异常，请刷新后重试！');
		}
		$news = M('News')->where("id=%d",array($id))->find();
		$comment = M('NewsComment')->where("pid=0 AND nid=%d",array($id))->select();
		foreach ($comment as &$v) {
			$rss = M('NewsComment')->where("pid=%d",array($v['id']))->select();
			$v['num'] = count($rss);
			$v['replyfor'] = $rss;
		}

		$this->assign('news',$news);
		$this->assign('comment',$comment);
		$this->display();
	}

	//最新信息评论
	public function new_comment() {
		if (IS_POST) {
			if($_SESSION ["MEMBER_id"]==''){
				$this->error('请登录后再回复');
			}
			if(I('post.nid')==''){
				$this->error('网络异常，请刷新后重试！');
			}
			// 数据
			$data['uid'] = $_SESSION ["MEMBER_id"];
			$data['create_time'] = time ();
			$data['nid'] = I('post.nid');
			$data['content'] = I('post.content','','strip_tags');
			$data['pid'] = I('post.replyfor') ? I('post.replyfor') : '0';
			if (M ( 'NewsComment' )->add ($data)) {
				$this->integrals('comment');
				$this->success ( '评论成功','',0 );
			} else {
				$this->error ( '评论失败','',0 );
			}
		}
	}

	//信贷感悟详情
	public function feeling(){
		$id = I('get.id');
		if(!$id){
			$this->error('网络异常，请刷新后重试！');
		}
		$feeling = M('Articles')->where("id=%d",array($id))->find();
		$comment = M('ArticlesComment')->where("pid=0 AND nid=%d",array($id))->select();
		foreach ($comment as &$v) {
			$rss = M('ArticlesComment')->where("pid=%d",array($v['id']))->select();
			$v['num'] = count($rss);
			$v['replyfor'] = $rss;
		}

		$this->assign('feeling',$feeling);
		$this->assign('comment',$comment);
		$this->display();
	}

	//小组列表
	public function group(){
		$id = I('get.id');
		$uid = $_SESSION ["MEMBER_id"];
		if(!$id){
			$this->error('网络异常，请刷新后重试！');
		}
		if(M('GroupExtend')->where("gid=%d AND uid=%d",array($id,$uid))->count() <= 0){
			$this->error('请先加入该小组',U('index/index'));
		}
		$map['gid'] = array('eq',$id);
		if(I('get.type')=='my'){
			$map['uid'] = array('eq',$uid);
		}

		$group = M('GroupContent');
		$count = $group->where($map)->count();
		$Page = $this->page( $count,10);

		$_list = $group->where($map)->limit($Page->firstRow.','.$Page->listRows)->order("dateline desc")->select();
		foreach ($_list as &$v) {
			$v['num'] = M('GroupComment')->where("pid=0 AND nid=%d",array($v['id']))->count();
		}
		$auth_group = M('Group')->where("id=%d AND uid=%d",array($id,$uid))->count();
		$_user = M('GroupExtend')->where("gid=%d",array($id))->select();
		$this->assign('_list',$_list);
		$this->assign('page',$Page->show('Home'));
		$this->assign('_user',$_user);
		$this->assign('uid',$uid);
		$this->assign('auth_group',$auth_group);
		$this->display();
	}

	//发布话题
	public function topic(){
		$uid = $_SESSION ["MEMBER_id"];
		if($_SESSION ["MEMBER_id"]==''){
			$this->error('请登录后再发布');
		}

		$id = I('get.id') ? I('get.id') : I('post.id');
		if($id == '' || M('Group')->where('id=%d',array($id))->count() <=0 ){
			$this->error('网络异常，请刷新后重试！');
		}

		if(IS_POST){
			if(I('post.title')==''){
				$this->error('标题不能为空');
			}
			if(I('post.content')==''){
				$this->error('内容不能为空');
			}

			$result = M("GroupContent")->add(array(
					'title'=>I('post.title'),
					'content'=>I('post.content'),
					'uid'=>$uid,
					'gid'=>$id,
					'dateline'=>time()
				));
			if($result){
				$this->integrals('topic_group');
				$this->success ( '发布成功',U('/Portal/life/group',array('id'=>$id)));
			}else{
				$this->error ( '发布失败' );
			}
		}else{
			$this->display();
		}
	}

	//话题详情
	public function topicview(){
		$gid = I('get.gid');
		$id = I('get.id');
		$_info = M('GroupContent')->where('id=%d AND gid=%d',array($id,$gid))->find();
		if(empty($_info)){
			$this->error('网络异常，请刷新后重试！');
		}
		$comment = M('GroupComment')->where("pid=0 AND nid=%d",array($id))->select();
		foreach ($comment as &$v) {
			$result = M('GroupComment')->where("pid=%d",array($v['id']))->select();
			$v['num'] = count($result);
			$v['_comment'] = $result;
		}
		$_user = M('GroupExtend')->where("gid=%d",array($gid))->select();
		$this->assign('_info',$_info);
		$this->assign('comment',$comment);
		$this->assign('_user',$_user);
		$this->display();
	}

	//话题评论
	public function topic_comment(){
		if (IS_POST) {
			if($_SESSION ["MEMBER_id"]==''){
				$this->error('请登录后再回复');
			}
			if(I('post.nid')==''){
				$this->error('网络异常，请刷新后重试！');
			}
			// 数据
			$data['uid'] = $_SESSION ["MEMBER_id"];
			$data['create_time'] = time ();
			$data['nid'] = I('post.nid');
			$data['content'] = I('post.content','','strip_tags');
			$data['pid'] = I('post.replyfor') ? I('post.replyfor') : '0';
			if (M ( 'GroupComment' )->add ($data)) {
				$this->integrals('comment');
				$this->success ( '评论成功','',0 );
			} else {
				$this->error ( '评论失败','',0  );
			}
		}
	}

	//信贷感悟评论
	public function feeling_comment() {
		if (IS_POST) {
			if($_SESSION ["MEMBER_id"]==''){
				$this->error('请登录后再回复');
			}
			if(I('post.nid')==''){
				$this->error('网络异常，请刷新后重试！');
			}
			// 数据
			$data['uid'] = $_SESSION ["MEMBER_id"];
			$data['create_time'] = time ();
			$data['nid'] = I('post.nid');
			$data['content'] = I('post.content','','strip_tags');
			$data['pid'] = I('post.replyfor') ? I('post.replyfor') : '0';
			if (M ( 'ArticlesComment' )->add ($data)) {
				$this->integrals('comment');
				$this->success ( '评论成功' ,'',0);
			} else {
				$this->error ( '评论失败','',0 );
			}
		}
	}

	public function ajax(){
		$type = I('post.type') ? I('post.type') : I('get.type');
		$id = I('post.id');
		$uid = $_SESSION ["MEMBER_id"];
		switch ($type) {
			case 'launch'://展开
					if(!$id){
						$this->error('网络异常，请刷新后重试！');
					}
					$result = M('Ask')->where('aid=%d',array($id))->order('dateline desc')->select();
					foreach ($result as &$v) {
						$v['nicename'] = getMemberField('user_nickname',$v['uid']);
						$v['avatars'] = avatars($v['uid']);
					}
					$this->ajaxReturn(array('status'=>200,'data'=>$result));
				break;
			case 'reply'://回复
					if($uid==''){
						$this->error('请登录后再回复');
					}
					if(!$id){
						$this->error('网络异常，请刷新后重试！');
					}
					$content = nl2br(I('post.content','','strip_tags'));
					if(empty($content)){
						$this->error('回复内容不能为空');
					}
					M('Ask')->where("id=%d",array($id))->save(array('chcek'=>1));
					$result = M('Ask')->add(array(
							'aid' => $id,
							'uid' => $uid,
							'content' => $content,
							'dateline' => time()
						));
					if($result){
						$this->integrals('respond_comment');
						$this->success ( "回复成功！", U ( "/Portal/life/index" ),0 );
					}else{
						$this->error('回复失败','',0);
					}
				break;
			case 'ask'://遍历问答
					$status = I('post.status');
					$Keywords = I('post.Keywords');
					$map['aid'] = array('eq',0);
					$order = 'dateline desc';
					if($status=='hit'){
						$order = 'hit desc';
					}elseif($status=='wait'){
						$map['chcek'] = array('eq',0);
					}
					if($Keywords!=''){
						$map['content'] = array('like','%'.$Keywords.'%');
					}
					$count = M('Ask')->where($map)->count();
					$page = $this->page ( $count, 6 , 1);
					if(I('post.page')>0){
						$p = (I('post.page')-1)*6;
					}else{
						$p = I('post.page')*6;
					}
					$ask = M('Ask')->where($map)->limit (  $p . ',6' )->order($order)->select();
					foreach ($ask as &$v) {
						$v['num'] = M('Ask')->where('aid=%d',array($v['id']))->count();
						$v['nicename'] = getMemberField('user_nickname',$v['uid']);
						$v['avatars'] = avatars($v['uid']);
					}
					
					echo json_encode(array('status'=>200,'data'=>$ask,'page'=>$page->show('Home'),'p'=>I('post.page')));exit;
				break;
			case 'nice'://点赞
					if($uid==''){
						$this->ajaxReturn(array('status'=>201,'info'=>'请登录后再点赞'));
					}
					if(!$id){
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}
					if(M('AskNice')->where("uid=%d AND aid=%d",array($uid,$id))->count()>0){
						$this->ajaxReturn(array('status'=>201,'info'=>'不能重复点赞'));
					}
					$result = M('Ask')->where("id=%d",array($id))->setInc('hit');
					$ass = M('AskNice')->add(array('uid'=>$uid,'aid'=>$id));
					if($result && $ass){
						$his = M('Ask')->where("id=%d",array($id))->getField('hit');
						$this->integrals('praise',I('post.uid'));
						$this->ajaxReturn(array('status'=>200,'data'=>$his));
					}else{
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}
				break;
			case 'report'://举报
				if($uid==''){
					$this->ajaxReturn(array('info'=>'请登录后在举报'));exit;
				}
					if(!$id){
						$this->ajaxReturn(array('info'=>'网络异常，请刷新后重试！'));
					}
					if(M('AskReport')->where(array('uid'=>$uid))->count()>0){
						$this->ajaxReturn(array('info'=>'已举报！'));
					}
					M('AskReport')->add(array(
							'uid' => $uid ? $uid : '0',
							'aid' => $id,
							'ip' => ip2long(get_client_ip()),
							'dateline' => time()
						));
					$this->integrals('report');
					$this->ajaxReturn(array('info'=>'举报成功！'));
				break;
			case 'feeling'://信贷感悟
					if(!$id){
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}
					$result = M('Articles')->where("type=%d",array($id))->order('time desc')->limit(10)->select();
					foreach ($result as &$v) {
						$v['dateline'] = date('Y-m-d',$v['time']);
					}
					$this->ajaxReturn(array('status'=>200,'data'=>$result));
				break;
			case 'group'://小组
					if(!$id){
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}
					$result = M('Group')->where("cid=%d",array($id))->limit(12)->select();
					foreach ($result as &$v) {
						$v['num'] = M("GroupExtend")->where("gid=%d",$v['id'])->count();
					}
					
					foreach ($result as &$v) {
						if($uid!=''){
							$v['join_group'] = M("GroupExtend")->where("gid=%d AND uid=%d",array($v['id'],$uid))->count();
						}else{
							$v['join_group'] = 0;
						}
					}
					
					$this->ajaxReturn(array('status'=>200,'data'=>$result));
				break;
			case 'join_group':// 加入小组
					if($uid==''){
						$this->ajaxReturn(array('status'=>201,'info'=>'请登录后再加入'));
					}
					if(!$id){
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}

					$extend = M('GroupExtend');
					if($extend->where("uid=%d AND gid=%d",array($uid,$id))->count() > 0){
						$this->ajaxReturn(array('status'=>201,'info'=>'您已加入过此小组'));
					}

					$result = $extend->add(array(
							'uid' => $uid,
							'gid' => $id,
							'dateline' => time()
						));
					if($result){
						$this->integrals('join_group');
						$this->ajaxReturn(array('status'=>201,'info'=>'加入成功！'));
					}
					$this->ajaxReturn(array('status'=>201,'info'=>'加入失败！'));
				break;
			case 'exit_group':// 退出小组
					if($uid==''){
						$this->ajaxReturn(array('status'=>201,'info'=>'请登录后再加入'));
					}
					if(!$id){
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}

					//是否自己创建
					if(M('Group')->where("uid=%d AND id=%d",array($uid,$id))->count()>0){
						//删除组
						M('Group')->delete($id);
						//删除话题
						M('GroupContent')->where("gid=%d",array($id))->delete();
						//删除组下成员
						$result = M('GroupExtend')->where("gid=%d",array($id))->delete();
					}else{
						$extend = M('GroupExtend');
						if($extend->where("uid=%d AND gid=%d",array($uid,$id))->count() <= 0){
							$this->ajaxReturn(array('status'=>201,'info'=>'你未加入该小组'));
						}

						$result = $extend->where("uid=%d AND gid=%d",array($uid,$id))->delete();
					}

					if($result){
						$this->ajaxReturn(array('status'=>201,'info'=>'退出成功！'));
					}
					$this->ajaxReturn(array('status'=>201,'info'=>'退出失败！'));
				break;
			case 'kick_group'://踢出小组
					if($uid==''){
						$this->ajaxReturn(array('status'=>201,'info'=>'请登录再执行'));
					}
					if(!$id){
						$this->ajaxReturn(array('status'=>201,'info'=>'网络异常，请刷新后重试！'));
					}
					if(M('Group')->where("uid=%d AND id=%d",array($uid,$id))->count()>0){
						M('GroupExtend')->where("uid=%d AND gid=%d",array(I('post.uid'),$id))->delete();
						$this->ajaxReturn(array('status'=>200,'info'=>'此人已踢出'));
					}else{
						$this->ajaxReturn(array('status'=>201,'info'=>'你无权操作别人的小组'));
					}
				break;
		}
	}
}
