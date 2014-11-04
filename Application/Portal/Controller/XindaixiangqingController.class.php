<?php

/**
 * 首页
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;
use Org\Util\Date;

class XindaixiangqingController extends HomeBaseController {
	private $xindai_obj;
	private $jilu_obj;
	function _initialize() {
		parent::_initialize ();
		$this->xindai_obj = M ( 'Credit' );
		$this->jilu_obj = M ( 'review_record' );
	}
	public function wangyouanli() {
		$this->checklogin ();
		
		if (IS_POST || I ( 'get.z_id' )) {
			$data = I ( 'post.' );
			$data ['tags'] = implode ( ',', $data ['tag'] );
			$data ['user_tags'] = implode ( ',', $data ['user_tag'] );
			$data ['user_id'] = $_SESSION ["MEMBER_id"];
			$data ['dataline'] = time ();
			$WangYou = M ( 'wangyou' );
			if ($WangYou->create ( $data )) {
				if ($WangYou->add ()) {
					$this->integrals('case_sharing');
					$this->success ( "添加成功！", U ( "xdal/index" ) );
				} else {
					$this->error ( "添加失败！" );
				}
			} else {
				$this->error ( $WangYou->getError () );
			}
		} else {
			// 查询所有标签
			$rs = M ( 'biaoqian' )->where ( 'zhuangtai=1' )->select ();
			$this->assign ( 'arr', $rs );
			$this->display ( 'Portal:wangyouanli' );
		}
	}
	/**
	 * *
	 * 自定义标签
	 * *
	 */
	public function wangyou_zd() {
		if (IS_POST) {
			$this->redirect ( 'xindaixiangqing/wangyouanli', array (
					'z_id' => 1 
			) );
		} else {
			echo "error";
			exit ();
		}
	}
	
}
