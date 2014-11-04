<?php

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class XdshController extends AdminbaseController {
	public function index() {
		echo 1;
	}
	/**
	 * 最新消息
	 * *
	 */
	public function news() {
		// 查询显示数据
		$this->rows = M ( 'news' )->select ();
		$this->display ();
	}
	
	// 添加
	public function nadd() {
		if ($_POST) {
			$_POST ['time'] = time ();
			$_POST ['user'] = $_SESSION ['user'] ['ID'];
			if (M ( 'news' )->add ( $_POST )) {
				$this->success ( '添加成功' );
			} else {
				$this->error ( '添加失败' );
			}
		} else {
			$this->display ();
		}
	}
	
	// 修改
	public function nedit() {
		if ($_POST) {
			if (M ( 'news' )->save ( $_POST )) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		} else {
			// 查询数据
			$this->vo = M ( 'news' )->where ( array (
					'id' => I ( 'get.id' ) 
			) )->find ();
			$this->display ();
		}
	}
	
	// 删除
	public function ndelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'news' )->delete ( $id )) {
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
				if (M ( 'news' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 信贷感悟（文章）
	 * *
	 */
	// 首页
	public function articles() {
		$this->rows = M ( 'articles' )->select ();
		$this->display ();
	}
	
	// 添加
	public function aadd() {
		if (IS_POST) {
			$_POST ['time'] = time ();
			$_POST ['user'] = $_SESSION ['user'] ['ID'];
			if (M ( 'articles' )->add ( $_POST )) {
				$this->success ( '添加成功' );
			} else {
				$this->error ( '添加失败' );
			}
		} else {
			// 查询分类
			$this->rows = M ( 'articles_type' )->select ();
			$this->display ();
		}
	}
	
	// 修改
	public function aedit() {
		if (IS_POST) {
			if (M ( 'articles' )->save ( $_POST )) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		} else {
			// 查询分类
			$this->rows = M ( 'articles_type' )->select ();
			// 查询数据
			$this->vo = M ( 'articles' )->where ( array (
					'id' => I ( 'get.id' ) 
			) )->find ();
			$this->display ();
		}
	}
	
	// 删除
	public function adelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'articles' )->delete ( $id )) {
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
				if (M ( 'articles' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 文章分类
	 * *
	 */
	// 首页
	public function type() {
		$this->rows = M ( 'articles_type' )->select ();
		$this->display ();
	}
	
	// 添加
	public function tadd() {
		if (IS_POST) {
			$_POST ['time'] = time ();
			$_POST ['user'] = $_SESSION ['user'] ['ID'];
			if (M ( 'articles_type' )->add ( $_POST )) {
				$this->success ( '添加成功' );
			} else {
				$this->error ( '添加失败' );
			}
		} else {
			$this->display ();
		}
	}
	
	// 修改
	public function tedit() {
		if (IS_POST) {
			if (M ( 'articles_type' )->save ( $_POST )) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		} else {
			$this->vo = M ( 'articles_type' )->where ( array (
					'id' => I ( 'get.id' ) 
			) )->find ();
			$this->display ();
		}
	}
	
	// 删除
	public function tdelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'articles_type' )->delete ( $id )) {
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
				if (M ( 'articles_type' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 小组分类
	 * *
	 */
	// 首页显示
	public function gtype() {
		$this->rows = M ( 'group_class' )->select ();
		$this->display ();
	}
	
	// 添加
	public function gadd() {
		if (IS_POST) {
			$_POST ['time'] = time ();
			$_POST ['user'] = $_SESSION ['user'] ['ID'];
			if (M ( 'group_class' )->add ( $_POST )) {
				$this->success ( '添加成功' );
			} else {
				$this->error ( '添加失败' );
			}
		} else {
			$this->display ();
		}
	}
	
	// 修改
	public function gedit() {
		if (IS_POST) {
			if (M ( 'group_class' )->save ( $_POST )) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		} else {
			$this->vo = M ( 'group_class' )->where ( array (
					'id' => I ( 'get.id' ) 
			) )->find ();
			$this->display ();
		}
	}
	
	// 删除
	public function gdelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'group_class' )->delete ( $id )) {
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
				if (M ( 'group_class' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 小组管理
	 * *
	 */
	// 首页
	public function groupgl() {
		// 查询小组信息
		$this->rows = M ( 'group' )->select ();
		$this->display ();
	}
	
	// 删除
	public function groupdelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			M ( 'group_extend' )->where ( array (
					'gid' => $id 
			) )->delete ();
			M ( 'group_content' )->where ( array (
					'gid' => $id 
			) )->delete ();
			if (M ( 'group' )->delete ( $id )) {
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
				M ( 'group_extend' )->where ( array (
						'gid' => $_POST ['ids'] [$i] 
				) )->delete ();
				M ( 'group_content' )->where ( array (
						'gid' => $_POST ['ids'] [$i] 
				) )->delete ();
				if (M ( 'group' )->delete ( $_POST ['ids'] [$i] )) {
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
	
	// 小组文章
	public function grouparticles() {
		$this->rows = M ( 'group_content' )->where ( array (
				'gid' => I ( 'get.id' ) 
		) )->select ();
		$this->display ();
	}
	
	// 小组文章详情
	public function grouparticlesxq() {
		$this->row = M ( 'group_content' )->where ( array (
				'id' => I ( 'get.id' ) 
		) )->find ();
		$this->display ();
	}
	
	// 删除小组文章
	public function grouparticlesdelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'group_content' )->delete ( $id )) {
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
				if (M ( 'group_content' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 问答专区
	 * *
	 */
	// 首页
	public function ask() {
		$this->rows = M ( 'ask' )->where ( array (
				'aid' => 0 
		) )->select ();
		$this->display ();
	}
	
	// 删除
	public function askdelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'ask' )->delete ( $id )) {
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
				if (M ( 'ask' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 举报页面
	 * *
	 */
	public function askreport() {
		$this->rows = M ( 'ask_report' )->where ( array (
				'aid' => I ( 'get.aid' ) 
		) )->select ();
		$this->display ();
	}
	// 删除
	public function askrdelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'ask_report' )->delete ( $id )) {
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
				if (M ( 'ask_report' )->delete ( $_POST ['ids'] [$i] )) {
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
	 * 回复页面
	 * *
	 */
	public function asknice() {
		$this->rows = M ( 'ask' )->where ( array (
				'aid' => I ( 'get.aid' ) 
		) )->select ();
		$this->display ();
	}
	
	/**
	 * 图片管理
	 * *
	 */
	// 首页显示
	public function imgmanage() {
		$this->rows = M ( 'xdimg' )->select ();
		$this->display ();
	}
	
	// 添加图片
	public function iadd() {
		if (IS_POST) {
			$_POST ['time'] = time ();
			$_POST ['user'] = $_SESSION ['user'] ['ID'];
			if (M ( 'xdimg' )->add ( $_POST )) {
				$this->success ( '添加成功' );
			} else {
				$this->error ( '添加失败' );
			}
		} else {
			$this->display ();
		}
	}
	
	// 修改图片
	public function iedit() {
		if (IS_POST) {
			if (M ( 'xdimg' )->save ( $_POST )) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		} else {
			$this->vo = M ( 'xdimg' )->where ( array (
					'id' => I ( 'get.id' ) 
			) )->find ();
			$this->display ();
		}
	}
	
	// 删除图片
	public function idelete() {
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M ( 'xdimg' )->delete ( $id )) {
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
				if (M ( 'xdimg' )->delete ( $_POST ['ids'] [$i] )) {
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
