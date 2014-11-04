<?php
/**
 * 字典管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class AreaController extends AdminbaseController {
	function _initialize() {
		parent::_initialize();
	}

	/**
	 * 区域管理
	 */
	public function index(){
		$result = M('Area')->select();
		$this->assign('area',$result);
		$this->display();
	}

	/**
	 * 添加区域
	 */
	public function add(){
		if(IS_POST){
			$area = D('Area');
			$data['area_title'] = trim($_POST['area_title']);
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
			$area = D('Area');
			$result = $area->create();
			if (!$result) {
				$this->error($area->getError());
			} else {
				$area->where("ID=%d",array(I('post.ID')))->save($data);
				$this->success('编辑成功');
			}
		}else{
			$result = M('Area')->where("ID=%d",array(I('get.ID')))->find();
			$this->assign('area',$result);
			$this->display();
		}
	}

	/**
	 * 删除区域
	 */
	public function delete(){
		$area = M('Area');
		if (IS_GET) {
			// 删除单挑数据
			if ($area->delete(I('get.ID'))) {
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