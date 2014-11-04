<?php

/**
 * 信贷案例
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;
use Org\Util\Date;
use Admin\Model\CreditModel;

class XdalController extends HomeBaseController {
	public function index() {
		/**
		 *
		 * @var $M CreditModel
		 */
		$M = M ( 'Credit' );
		$rows = $M->limit ( 6 )->order ( 'id desc' )->select ();
		$this->row1 = array_shift ( $rows );
		$this->row2 = array_shift ( $rows );
		$rowss = array();
		if(!empty($rows)){
			foreach ($rows as $key => $v) {
				$rowss[] = array(
					'xd_image' => $v['xd_image'],
					'ID' => $v['ID'],
					'xd_title' => $v['xd_title'],
					'zheng' => M('Comment')->where("zhengfan=1 AND credit_id=%d",array($v['ID']))->order('nice desc')->getField('postby'),
					'fan' => M('Comment')->where("zhengfan=0 AND credit_id=%d",array($v['ID']))->order('nice desc')->getField('postby'),
				);
			}
		}
		$this->rows = $rowss;
		
		// 网友案例
		$this->wangyouanli ( I ( 'get.type' ) );
		
		$this->display ();
	}
	public function row($id) {
		$this->xindai_obj = M ( 'Credit' );
		$this->jilu_obj = M ( 'review_record' );
		$this->comment_obj = M ( 'Comment' );
		
		if (IS_POST) {
			$this->checklogin ();
			//是否已评论
			if($_POST['replyfor']==''){
				if($this->comment_obj->where("credit_id=%d AND postby=%d AND parent_id=0",array($_POST ['rev_review_hteme'],$_SESSION ["MEMBER_id"]))->count()>0){
					$this->success ( '不能重复评论' );exit;
				}
			}

			// 提交评论进行添加数据
			if ($_POST ['sub1']) {
				// 添加数据
				$data ['content'] = $_POST ['rev_content'];
				$data ['zhengfan'] = 1;
				$data ['create_time'] = time ();
				$data ['postby'] = $_SESSION ["MEMBER_id"];
				$data ['parent_id'] = (I ( 'replyfor' ) ? I ( 'replyfor' ) : 0);
				$data ['credit_id'] = $_POST ['rev_review_hteme'];
				$re = $this->comment_obj->add ( $data );
			}
			if ($_POST ['sub2']) {
				// 添加数据
				$data ['content'] = $_POST ['rev_content'];
				$data ['zhengfan'] = 0;
				$data ['create_time'] = time ();
				$data ['postby'] = $_SESSION ["MEMBER_id"];
				$data ['parent_id'] = (I ( 'replyfor' ) ? I ( 'replyfor' ) : 0);
				$data ['credit_id'] = $_POST ['rev_review_hteme'];
				$re = $this->comment_obj->add ( $data );
			}
			if ($re) {
				$this->integrals('comment');
				$this->success ( '完成评论' );
			} else {
				$this->error ( '评论失败' );
			}
			return;
			
		}
		
		$rs = $this->xindai_obj->where ( 'ID=' . $id )->find ();
		//查询标签
		$biaoqian = str_split($rs['xd_biaoqian']);
		$num = count($biaoqian);
		for($i=1;$i<=$num;$i++){
			//查询标签
			$b .= M('biaoqian')->where('ID='.$biaoqian[$i])->getField('bq').'&nbsp;&nbsp;&nbsp;';
		}		
		$rs['biaoqian'] = $b;
		$this->show_result =  ( strtotime($rs[xd_surplus]) < time() );
		
		$this->assign ( 'xiangqing', $rs );
		$this->assign ( 'xd_id', $id );
		// 查询后台正方文档
		$where = array (
				'rev_neirong' => 1,
				'rev_neirongby' => 0,
				'rev_review_hteme' => $id,
				'rev_zhengfan' => 1 
		);
		$arr = $this->jilu_obj->where ( $where )->limit ( 3 )->group ( 'rev_create_time desc' )->select ();
		$this->assign ( 'zhengfang', $arr );
		// 查询后台反方文档
		if (I ( 'get.p_id' )) {
			$page = I ( 'get.p_id' );
		} else {
			$page = 1;
		}
		$num = $page * 3;
		$where = array (
				'rev_neirong' => 1,
				'rev_neirongby' => 0,
				'rev_review_hteme' => $id,
				'rev_zhengfan' => 0 
		);
		$where ['rev_title'] = array (
				'neq',
				'' 
		);
		$arr1 = $this->jilu_obj->where ( $where )->limit ( 3 )->group ( 'rev_create_time desc' )->select ();
		$this->assign ( 'fanfang', $arr1 );
		
		// 网友正方评论内容
		$where = array (
				'credit_id' => $id,
				'zhengfan' => 1,
				'parent_id' => 0 
		);
		$arr2 = $this->comment_obj->where ( $where )->page ( '1,' . $num )->order ( 'create_time desc' )->select ();
		$zf_num = $this->comment_obj->where ( $where )->count ();
		$zf_flag = $this->comment_obj->where ( $where )->count ( 'DISTINCT postby' );
		$this->zf_hasmore = ($zf_num > $page * 3);
		$this->assign ( 'zf_flag', $zf_flag );
		foreach ( $arr2 as &$k ) {
			$k ['rev_create_time'] = Date ( 'Y-m-d', $k ['rev_create_time'] );
			$k ['user_name'] = getMemberNameById ( $k ['user_id'] );
			$where2 = array (
					'parent_id' => $k ['id'] 
			);
			$k ['replys'] = $this->comment_obj->where ( $where2 )->order ( 'create_time desc' )->select ();
			$k ['num'] = $this->comment_obj->where ( $where2 )->order ( 'create_time desc' )->count ();
		}
		$this->assign ( 'wzhengfang', $arr2 );
		
		// 网友反方评论内容
		$where = array (
				'credit_id' => $id,
				'zhengfan' => 0,
				'parent_id' => 0 
		);
		$arr3 = $this->comment_obj->where ( $where )->page ( '1,' . $num )->order ( 'create_time desc' )->select ();
		$ff_num = $this->comment_obj->where ( $where )->count ();
		$ff_flag = $this->comment_obj->where ( $where )->count ('DISTINCT postby' );
		$this->ff_hasmore = ($ff_num > $page * 3);
		$this->assign ( 'ff_flag', $ff_flag );
		// 转换时间
		foreach ( $arr3 as &$k ) {
			$k ['rev_create_time'] = Date ( 'Y-m-d', $k ['rev_create_time'] );
			$k ['user_name'] = getMemberNameById ( $k ['user_id'] );
			$where2 = array (
					'parent_id' => $k ['id'] 
			);
			$k ['replys'] = $this->comment_obj->where ( $where2 )->order ( 'create_time desc' )->select ();
			$k ['num'] = $this->comment_obj->where ( $where2 )->order ( 'create_time desc' )->count ();
		}
		$this->assign ( 'wfanfang', $arr3 );
		
		$page ++;
		$this->assign ( 'page', $page );
		
		/**
		 * 相似案例
		 * **
		 */
		$xd_biaoqian = array_filter(explode(',',$rs['xd_biaoqian']));

		if(!empty($xd_biaoqian)){
			foreach ($xd_biaoqian as $key => $value) {
				$wheres[$key]['xd_biaoqian'] = array('like', '%,'.$value.',%');
				$whereb[$key]['tag'] = array('like', '%,'.$value.',%');
			}
			$wheres['_logic'] = 'or';
			$map['_complex'] = $wheres;
			$map['ID'] = array('neq',I('get.id'));
			$xiangsianli = $this->xindai_obj->where($map)->select();
			$this->assign ( 'xiangsi', $xiangsianli );
			
			// 红图技术
			$whereb['_logic'] = 'or';
			$hongtujishu = M('Tuijian_yuedui')->where($whereb)->select();

			$this->assign ( 'hongtujishu', $hongtujishu );
		}
		$this->display ();
	}
	
	// 大咖详情
	public function big(){
		if(!I('get.id'))
			redirect('/');
		$result = M('review_record')->where("ID=%d",array(I('get.id')))->find();
		$this->assign ( '_info', $result);
		$this->display ();
	}

	// 点赞
	public function nice(){
		$this->checklogin ();
		$memid = $_SESSION ["MEMBER_id"];
		if(!I('post.id')){
			$this->error('请求错误，请重试！');exit;
		}
		
		if(M('Comment_nice')->where('uid=%d AND cid=%d',array($memid,I('post.id')))->count() > 0){
			$this->error('已点赞，不能重复');exit;
		}

		M('Comment')->where('id=%d',array(I('post.id')))->setInc('nice');
		
		$result = M('Comment_nice')->add(array('uid'=>$memid,'cid'=>I('post.id')));

		if($result){
			$nice = M('Comment')->where('id=%d',array(I('post.id')))->getField('nice');
			$this->integrals('praise',I('post.uid'));
			echo json_encode(array('info'=>$nice,'status'=>1));exit;
		}else{
			$this->error('数据错误，请重试！');
		}
	}

	/**
	 * 查询网友案例
	 * **
	 */
	private function wangyouanli($type = null, $page = 1) {
		switch ($type) {
			case 'essence'://精华
				$order = 'cream desc';
				break;

			case 'popularity'://人气
				$order = 'hits desc';
				break;
			
			default://最新
				$order = 'ID desc';
				break;
		}
		$where['chcek'] = array('neq',2);
		// 分页显示
		$count = M ( 'wangyou' )->where($where)->order($order)->count ();
		$page = $this->page ( $count, 10 );
		$arr = M ( 'wangyou' )->limit ( $page->firstRow . ',' . $page->listRows )->where($where)->order($order)->select ();
		$this->assign ( "Page1", $page->show ( 'Home' ) );
		
		$this->assign ( 'wangyou', $arr );
	}
	
	// 查询相似案例
	private function xiangsianli($id) {
		// 获取案例标签
		$rs = M ( 'credit' )->where ( 'ID=' . $id )->getField ( 'xd_biaoqian' );
		$arr = explode ( ',', $rs );
		// 查询第一个的
		$where ['wy_biaoqian'] = array (
				'LIKE',
				'%' . $arr ['0'] . '%' 
		);
		return M ( 'wangyou' )->limit ( 3 )->where ( $where )->select ();
	}
	
	// 查询红途技术
	private function hongtujishu() {
		return M ( 'share' )->limit ( 3 )->where ()->select ();
	}
	/**
	 * 往期查询
	 * **/
	public function wqcx(){
		$credit = M('Credit');
		$result = $credit->group("DATE_FORMAT(xd_tianjia_time,'%Y')")->field('DATE_FORMAT(FROM_UNIXTIME(xd_tianjia_time),"%Y") as years')->select();
		foreach ($result as &$v) {
			$v['month'] = $credit
			->where("xd_tianjia_time > '%s' AND xd_tianjia_time <'%s' ",array(strtotime($v['years'].'-1-1 0:0:00'),strtotime($v['years'].'-12-31 12:59:59')))
			->group("month(FROM_UNIXTIME(xd_tianjia_time))")->field('month(FROM_UNIXTIME(xd_tianjia_time)) as month')->select();
		}
		foreach ($result as &$s) {
			foreach($s['month'] as &$k){
				$k['day'] = $credit
				->where("xd_tianjia_time > '%s' AND xd_tianjia_time <'%s' ",array(strtotime($s['years'].'-'.$k['month'].'-1 0:0:00'),strtotime($s['years'].'-'.$k['month'].'-31 23:59:59')))
				->select();
			}
		}
		$this->assign('credit',$result);
		$this->display();
	}
	
	
}
