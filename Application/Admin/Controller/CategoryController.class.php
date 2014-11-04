<?php
/**
 * 公司类别管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class CategoryController extends AdminbaseController {
	/**
	 * 区域管理
	 */
	public function index(){
		$result = M('Members_category')->select();
		$this->assign('category',$result);
		$this->display();
	}

	/**
	 * 添加区域
	 */
	public function add(){
		if(IS_POST){
			$area = D('MembersCategory');
			$data['name'] = I('post.name');
			$result = $area->create($data);
			if (!$result) {
				$this->error($area->getError());
			} else {
				$area->add($data);
				$this->success('添加成功');
			}
		}else{
			$this->display();
		}
	}

	/**
	 * 编辑区域
	 */
	public function edit(){
		if(IS_POST){
			$area = D('MembersCategory');
			$data['name'] = I('post.name');
			$result = $area->create($data);
			if (!$result) {
				$this->error($area->getError());
			} else {
				$area->where("id=%d",array(I('post.id')))->save($data);
				$this->success('编辑成功');
			}
		}else{
			$result = M('Members_category')->where("id=%d",array(I('get.id')))->find();
			$this->assign('category',$result);
			$this->display();
		}
	}

	/**
	 * 删除区域
	 */
	public function delete(){
		$area = M('MembersCategory');
		if (IS_GET) {
			// 删除单挑数据
			if ($area->delete(I('get.id'))) {
				$this->success ('删除成功');
			} else {
				$this->error ('删除失败');
			}
		}
		if (IS_POST) {
			$stat = 0;
			$num = count ($_POST['ids']);
			for($i=0; $i<$num; $i++) {
				if ($area->delete($_POST['ids'][$i])) {
					$stat = 1;
				} else {
					$stat = 0;
				}
			}
			if($stat == 1){
				$this->success ('删除成功');
			}else{
				$this->error ('删除失败');
			}
		}
	}
}