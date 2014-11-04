<?php

/**
 * 字典管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class PostlevelController extends AdminbaseController {
	function _initialize() {
		parent::_initialize ();
	}
	
	/**
	 * 管理
	 */
	public function index() {
		$result = M ( 'Members_post_level' )->select ();
		$this->assign ( 'rows', $result );
		$this->display ();
	}
	
	/**
	 * 添加
	 */
	public function add() {
		if (IS_POST) {
			$M = D ( 'Members_post_level' );
			$result = $M->create ();
			if (! $result) {
				$this->error ( $M->getError () );
			} else {
				$M->add ( $data );
				$this->success ( '添加成功' );
			}
		} else {
			$this->display ();
		}
	}
	
	/**
	 * 编辑
	 */
	public function edit() {
		if (IS_POST) {
			$M = D ( 'Members_post_level' );
			$result = $M->create ();
			if (! $result) {
				$this->error ( $M->getError () );
			} else {
				$M->where ( "ID=%d", array (
						I ( 'post.ID' ) 
				) )->save ( $data );
				$this->success ( '编辑成功' );
			}
		} else {
			$result = M ( 'Members_post_level' )->where ( "ID=%d", I ( 'get.ID' ) )->find ();
			$this->assign ( 'row', $result );
			$this->display ();
		}
	}
	
	/**
	 * 删除
	 */
	public function delete() {
		$M = M ( 'Area' );
		if (IS_GET) {
			// 删除单挑数据
			if ($M->delete ( I ( 'get.ID' ) )) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
		if (IS_POST) {
			$stat = 0;
			$num = count ( $_POST ['ids'] );
			for($i = 0; $i < $num; $i ++) {
				if ($M->delete ( $_POST ['ids'] [$i] )) {
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