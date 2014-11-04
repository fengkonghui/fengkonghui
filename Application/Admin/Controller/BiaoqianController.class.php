<?php

/**
 * 标签管理
 * ***/
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class BiaoqianController extends AdminbaseController {
	protected $biaoqian_obj;
	function _initialize() {
		parent::_initialize ();
		$this->biaoqian_obj = D ( "biaoqian" );
	}
	// 管理员设置标签
	function index() {
		// 查询数据
		$arr = $this->biaoqian_obj->where ( 'zhuangtai=1' )->select ();
		$this->assign ( 'arr', $arr );
		$this->display ();
	}
	// 用户自定义标签
	function user_biaoqian() {
		echo "BQ TODO";
		exit ();
	}
	// 管理员设置标签
	function add() {
		if (IS_POST) {
			// 判断是修改还是删除
			if ($_POST ['ID']) {
				// 进行修改数据
				if ($this->biaoqian_obj->save ( $_POST )) {
					$this->success ( '保存成功1' );
				} else {
					$this->error ( '保存失败' );
				}
			} else {
				// 进行添加数据
				$_POST ['zhuangtai'] = 1;
				if ($this->biaoqian_obj->add ( $_POST )) {
					$this->success ( '保存成功' );
				} else {
					$this->error ( '保存失败' );
				}
			}
		} else {
			// 判断是否点击修改
			if ($_GET ['id']) {
				// 接收并查询数据
				$id = $_GET ['id'];
				$rs = $this->biaoqian_obj->find ( $id );
				$this->assign ( 'biaoqian', $rs );
			}
			$this->display ();
		}
	}
	function edit($id) {
		if (IS_POST) {
			if ($this->biaoqian_obj->create()) {
				if ($this->biaoqian_obj->save()) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->biaoqian_obj->getError());
			}
		}
		$rs = $this->biaoqian_obj->find ( $id );
		$this->assign ( 'biaoqian', $rs );
		$this->display ();
	}
	function delete() {
		if (IS_GET) {
			// 删除单挑数据
			if ($this->biaoqian_obj->delete ( I ( 'get.id' ) )) {
				$this->success ( '删除成功' );
			} else {
				$this->error ( '删除失败' );
			}
		}
		if (IS_POST) {
			$stat = 0;
			$num = count ( $_POST ['ids'] );
			for($i = 0; $i < $num; $i ++) {
				if ($this->biaoqian_obj->delete ( $_POST ['ids'] [$i] )) {
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
