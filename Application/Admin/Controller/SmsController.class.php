<?php
/**
 * 短信日志 
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class SmsController extends AdminbaseController {
	public function index(){
		$result = M('SmsLog')->order("dateline desc")->select();
		$this->assign('smslog',$result);
		$this->display();
	}
}