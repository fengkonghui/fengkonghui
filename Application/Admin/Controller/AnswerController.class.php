<?php

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class AnswerController extends AdminbaseController {

	protected $ad_obj;

	function _initialize() {
		parent::_initialize();
		$this->ad_obj = M("Answer");
	}

	function index() {
		$ads = $this->ad_obj->order('time desc')->select();
		$this->assign("answer", $ads);
		$this->display();
	}

	/**
	 *  删除
	 */
	function delete() {
		$id = (int) I("get.id");
		$data['id'] = $id;
		if ($this->ad_obj->delete($data)) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}

}
