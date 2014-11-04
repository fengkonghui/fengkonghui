<?php

namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Org\Util\Date;

class XindaiController extends AdminbaseController {
	private $xindai_obj;
	private $jilu_obj;
	function _initialize() {
		parent::_initialize ();
		$this->xindai_obj = D ( 'Credit' );
		$this->jilu_obj = D ( 'review_record' );
	}
	// 查询首页信息
	function index() {
		$rs = $this->xindai_obj->where ()->select ();
		foreach ( $rs as &$k ) {
			$k ['xd_date'] = Date ( 'Y-m-d', $k ['xd_tianjia_time'] );
		}
		$this->assign ( 'arr', $rs );
		$this->display ();
	}
	function add() {
		if (IS_POST) {
			$_POST ['xd_tianjia_time'] = time ();
			$_POST ['xd_biaoqian'] = ','.implode ( ',', $_POST ['xd_biaoqian'] ).',';
			if ($this->xindai_obj->create ()) {
				if (false !== $this->xindai_obj->add ()) {
					$this->success ( "保存成功！", U ( "xindai/index" ) );
				} else {
					$this->error ( '保存失败' );
				}
			} else {
				$this->error ( $this->xindai_obj->getError () );
			}
		} else {
			// 查询标签信息
			$this->assign ( 'biaoqian', M ( 'biaoqian' )->select () );
			$this->display ();
		}
	}
	function edit() {
		if (IS_POST) {
				$_POST ['xd_biaoqian'] = ','.implode ( ',', $_POST ['xd_biaoqian'] ).',';
			if ($this->xindai_obj->create ()) {
				if (false !== $this->xindai_obj->save ($_POST)) {
					$this->success ( "保存成功！", U ( "index" ) );
				} else {
					$this->error ( "保存失败！" );
				}
			} else {
				$this->error ( $this->xindai_obj->getError () );
			}
		} else {
			$id = I ( "get.xd_id" );
			$xindai = $this->xindai_obj->where ( "ID=$id" )->find ();
			// 查询标签信息
			$this->assign ( 'biaoqian', M ( 'biaoqian' )->select () );
			$this->assign ( 'xindai', $xindai );
			$this->display ();
		}
	}
	
	/**
	 * 删除
	 */
	function delete() {
		// 删除单条数据
		if ($_GET) {
			$id = ( int ) I ( "get.xd_id" );
			if ($this->xindai_obj->delete ( $id )) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
		// 批量删除
		if (IS_POST) {
			$stat = 0;
			$num = count ( $_POST ['ids'] );
			for($i = 0; $i < $num; $i ++) {
				if ($this->xindai_obj->delete ( $_POST ['ids'] [$i] )) {
					$stat = 1;
				} else {
					$stat = 0;
				}
			}
			if ($stat == 1) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
	}
	
	/**
	 * *
	 * 辩论文档
	 * **
	 */
	function bianlun() {
		$where = array (
				'rev_neirong' => 1,
				'rev_neirongby' => 0 
		);
		$where ['rev_title'] = array (
				'neq',
				'' 
		);
		$rs = $this->jilu_obj->where ( $where )->group ( 'rev_create_time desc' )->select ();
		foreach ( $rs as &$k ) {
			$k ['rev_create_time'] = date ( 'Y-m-d', $k ['rev_create_time'] );
		}
		$this->assign ( 'arr', $rs );
		$this->display ();
	}
	
	// 添加信息
	function badd() {
		if (IS_POST) {
			$_POST ['rev_create_time'] = time ();
			$_POST ['rev_neirong'] = 1; // 信贷生的评论以及文档默认为1
			if ($this->jilu_obj->create ()) {
				if (false !== $this->jilu_obj->add ()) {
					$this->success ( "保存成功！", U ( "xindai/bianlun" ) );
				} else {
					$this->error ( '保存失败' );
				}
			} else {
				$this->error ( $this->xindai_obj->getError () );
			}
		} else {
			// 查询所有案例
			$rs = $this->xindai_obj->order ( 'ID desc' )->select ();
			$this->assign ( 'xindai', $rs );
			$this->display ();
		}
	}
	// 修改信息
	function bedit() {
		if (IS_POST) {
			$_POST ['xd_surplus'] = strtotime ( $_POST ['xd_surplus'] );
			if ($this->jilu_obj->create ()) {
				if (false !== $this->jilu_obj->save ()) {
					$this->success ( "保存成功！", U ( "xindai/bianlun" ) );
				} else {
					$this->error ( "保存失败！" );
				}
			} else {
				$this->error ( $this->jilu_obj->getError () );
			}
		} else {
			$id = I ( "get.xd_id" );
			$xindai = $this->jilu_obj->where ( "ID=$id" )->find ();
			$this->assign ( 'arr', $xindai );
			// 查询所有案例
			$rs = $this->xindai_obj->order ( 'ID desc' )->select ();
			$this->assign ( 'xindai', $rs );
			$this->display ();
		}
	}
	
	// 删除信息
	function bdelete() {
		// 删除单条数据
		if ($_GET) {
			$id = ( int ) I ( "get.xd_id" );
			if ($this->jilu_obj->delete ( $id )) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
		// 批量删除
		if (IS_POST) {
			$stat = 0;
			$num = count ( $_POST ['ids'] );
			for($i = 0; $i < $num; $i ++) {
				if ($this->jilu_obj->delete ( $_POST ['ids'] [$i] )) {
					$stat = 1;
				} else {
					$stat = 0;
				}
			}
			if ($stat == 1) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
	}

	//网友案例
	public function wangyou(){
		$result = M('Wangyou')->order('ID desc')->select();
		$this->assign('_list',$result);
		$this->display ();
	}
	//网友案例编辑
	public function wangyouedit(){
		if(IS_POST){
			$result = M('Wangyou')->where("ID=%d",array(I('post.id')))->save($_POST);
			if ($result) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		}else{
			if(!I('get.ID')){
				$this->error('网络请求超时，请刷新重试！');
			}
			$result = M('Wangyou')->where("ID=%d",array(I('get.ID')))->find();
			$this->assign('_info',$result);
			$this->display ();
		}
	}
	//网友案例删除
	public function wangyouDel(){
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.ID" );
			if (M('Wangyou')->delete ( $id )) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
		// 批量删除
		if (IS_POST) {
			$stat = 0;
			$num = count ( $_POST ['ids'] );

			for($i = 0; $i < $num; $i ++) {
				if (M('Wangyou')->delete ( $_POST ['ids'] [$i] )) {
					$stat = 1;
				} else {
					$stat = 0;
				}
			}
			if ($stat == 1) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
	}
}
