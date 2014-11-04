<?php

/**
 * 首页
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;
use Org\Util\Date;

class XindaiController extends HomeBaseController {
	private $xindai_obj;
	function _initialize() {
		parent::_initialize ();
		$this->xindai_obj = M ( 'Credit' );
	}
	// 首页
	public function index() {
		// 查询内容
		$rs = $this->xindai_obj->where ( 'xd_live=1' )->limit ( '0,2' )->order ( 'id desc' )->select ();
		$left_xindai = $rs [0];
		$right_xindai = $rs [1];
		// 计算剩余时间
		$left_sj = $left_xindai ['xd_surplus'] - time ();
		$left_date = floor ( $left_sj / 3600 ); // 小时
		$left_sj1 = $left_sj - $left_date * 3600;
		$left_hour = floor ( $left_sj1 / 60 );
		$left_second = $left_sj1 - $left_hour * 60;
		$left_xindai ['xd_surplus'] = $left_date . ':' . $left_hour . ':' . $left_second;
		
		$right_sj = $right_xindai ['xd_surplus'] - time ();
		$right_date = floor ( $right_sj / 3600 ); // 小时
		$right_sj1 = $right_sj - $right_date * 3600;
		$right_hour = floor ( $right_sj1 / 60 );
		$right_second = $right_sj1 - $right_hour * 60;
		$right_xindai ['xd_surplus'] = $right_date . ':' . $right_hour . ':' . $right_second;
		
		if ($left_sj < 0) {
			$left_xindai ['xd_surplus'] = 0;
		}
		if ($right_sj < 0) {
			$right_xindai ['xd_surplus'] = 0;
		}
		$this->assign ( 'right_xindai', $right_xindai );
		$this->assign ( 'left_xindai', $left_xindai );
		// 查询下面显示信息
		// 查询条件
		$ids = $left_xindai ['ID'] . ',' . $right_xindai ['ID'];
		$where ['ID'] = array (
				'not in',
				$ids 
		);
		$where ['xd_live'] = 1;
		if (I ( 'get.p' )) {
			$page = I ( 'get.p' );
		} else {
			$page = 1;
		}
		$num = $page * 4;
		$rs = $this->xindai_obj->where ( $where )->order ( 'id desc' )->limit ( '0,' . $num )->select ();
		$page ++;
		$this->assign ( 'page', $page );
		$this->hasmore = ($this->xindai_obj->where ( 'xd_live=1' )->count () > $page * 4);
		$this->assign ( 'xindai', $rs );
		
		/**
		 * *
		 * 查询网友案例
		 * *
		 */
		// 接收传值，判断是否点击精品
		$this->wangyouanli ( I ( 'get.type' ) );
		$this->display ( "Portal:xindaianli" );
	}
	
	/**
	 * 查询网友案例
	 * **
	 */
	function wangyouanli($type = null, $page = 1) {
		if ($type != null) {
			$where = array (
					'LIKE',
					'%' . $type . '%' 
			);
		} else {
			$where = '1';
		}
		
		// 分页显示
		$count = M ( 'wangyou' )->where ( $where )->count ();
		$page = $this->page ( $count, 10 );
		$arr = M ( 'wangyou' )->limit ( $page->firstRow . ',' . $page->listRows )->where ( $where )->order('ID desc')->select ();
		$this->assign ( "Page1", $page->show ( 'Home' ) );
		
		$this->assign ( 'wangyou', $arr );
	}
	
	/**
	 * 网友案例详情
	 * *
	 */
	function anlixiangqing() {
		// 查询信息
		$rs = M ( 'wangyou' )->where ( 'ID=' . I ( 'get.wy_id' ) )->find ();

		//加浏览
		M('wangyou')->where("ID=%d",array(I('get.wy_id')))->setInc('hits');
		
		$rs['tag'] = explode (',' , $rs['tags']);
		$rs['user_tag'] = explode (',' , $rs['user_tags']);
		$this->assign ( 'wangyouanli', $rs );
		$this->assign ( 'id', I ( 'get.wy_id' ) );
		$this->pinglun_cont ( I ( 'get.wy_id' ) );
		$this->display ( "Portal:anlixiangqing" );
	}
	
	// 添加评论
	function pinglun() {
		if (I ( 'post.sub' )) {
			// 数据
			$_POST ['create_time'] = time ();
			$_POST ['user_id'] = $_SESSION ["MEMBER_id"];
			$_POST ['parent_id'] = (I ( 'replyfor' ) ? I ( 'replyfor' ) : 0);
			if (M ( 'comment_xd' )->add ( $_POST )) {
				$this->integrals('comment');
				$this->success ( '评论成功' );
			} else {
				$this->error ( '评论失败' );
			}
		}
	}
	// 评论信息查询
	function pinglun_cont($id) {
		$where ['credit_id'] = $id;
		$where ['parent_id'] = 0;
		$rs = M ( 'comment_xd' )->where ( $where )->select ();
		// 循环查询其他
		foreach ( $rs as &$k ) {
			$rs1 = M ( 'comment_xd' )->where ( 'parent_id=' . $k ['id'] )->select ();
			$k ['replyfor'] = $rs1;
			$k ['num'] = M ( 'comment_xd' )->where ( 'parent_id=' . $k ['id'] )->count ();
		}
		$this->assign ( 'pinglun', $rs );
	}
}
