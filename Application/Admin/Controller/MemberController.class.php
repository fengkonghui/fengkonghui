<?php

/**
 * 会员注册登录
 */

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MemberController extends AdminbaseController {

	function index() {
		$lists = M("Members")->where("user_status=1")->select();
		$this->assign('lists', $lists);
		$this->display();
	}

	function delete() {
		$id = intval($_GET['id']);
		if ($id) {
			$rst = M("Members")->where("user_status=1 and ID=$id")->setField('user_status', '0');
			if ($rst) {
				$this->success("保存成功！", U("admin/member/index"));
			} else {
				$this->error('会员删除失败！');
			}
		} else {
			$this->error('数据传入失败！');
		}
	}
	/***
	 * 查看用户详情，并且修改用户信息
	 * **/
	public function edit(){
		if(IS_POST){
			if(M('members')->save($_POST)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else {
			//城市查询
			$this->area = M('area')->select();
			//查询公司分类
			$this->category = M('members_category')->select();
			//查询职务级别
			$this->duty = M('members_post_level')->select();
			//查询级别
			$this->group = M('members_group')->where(array('git'=>array('not in','0')))->select();
			
			//查询用户数据
			$this->user = M('members')->where(array('ID'=>I('get.id')))->find();
			$this->display();
		}
	}
	
	
	/**
	 * 公司类型
	 * **/
	//首页
	public function category(){
		$this->rows  = M('members_category')->select();
		$this->display();
	}
	
	//添加
	public function cadd(){
		if(IS_POST){
			if(M('members_category')->add($_POST)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
	}
	
	//修改
	public function cedit(){
		if(IS_POST){
			if(M('members_category')->save($_POST)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			$this->vo = M('members_category')->where(array('id'=>I('get.id')))->find();
			$this->display();
		}
	}
	
	//删除
	public function cdelete(){
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M('members_category')->delete ( $id )) {
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
				if (M('members_category')->delete ( $_POST ['ids'] [$i] )) {
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
	 * 用户职务
	 * **/
	//首页
	public function duty(){
		$this->rows  = M('members_post_level')->select();
		$this->display();
	}
	
	//添加
	public function dadd(){
		if(IS_POST){
			if(M('members_post_level')->add($_POST)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
	}
	
	//修改
	public function dedit(){
		if(IS_POST){
			if(M('members_post_level')->save($_POST)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			$this->vo = M('members_post_level')->where(array('id'=>I('get.id')))->find();
			$this->display();
		}
	}
	
	//删除
	public function ddelete(){
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M('members_post_level')->delete ( $id )) {
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
				if (M('members_post_level')->delete ( $_POST ['ids'] [$i] )) {
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
	 * 地区设置
	 * **/
	//首页
	public function area(){
		$this->rows  = M('area')->select();
		$this->display();
	}
	
	//添加
	public function aadd(){
		if(IS_POST){
			if(M('area')->add($_POST)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
	}
	
	//修改
	public function aedit(){
		if(IS_POST){
			if(M('area')->save($_POST)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			$this->vo = M('area')->where(array('ID'=>I('get.id')))->find();
			$this->display();
		}
	}
	
	//删除
	public function adelete(){
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M('area')->delete ( $id )) {
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
				if (M('area')->delete ( $_POST ['ids'] [$i] )) {
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
