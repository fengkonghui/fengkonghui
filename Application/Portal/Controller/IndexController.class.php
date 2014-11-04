<?php

/**
 * 首页
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController {
	
	// 首页
	public function index() {
		$this->site_icp = C ( 'site_icp' );
		$this->display ( "Portal:index" );
	}
}
