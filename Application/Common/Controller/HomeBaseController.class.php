<?php

namespace Common\Controller;

use Common\Controller\AppframeController;

class HomeBaseController extends AppframeController {
	function _initialize() {
		parent::_initialize ();
		
		// site_options
		$site_options = F ( "site_options", '', C ( 'CMF_CONF_PATH' ) );
		if (empty ( $site_options )) {
			$site_options = get_site_options ();
			F ( "site_options", $site_options, C ( 'CMF_CONF_PATH' ) );
			$this->assign ( $site_options );
		} else {
			$this->assign ( $site_options );
		}
		
		$this->nav = $this->nav ();
	}
	function checklogin() {
		$memid = $_SESSION ["MEMBER_id"];
		if (! isset ( $_SESSION ["MEMBER_id"] )) {
			$this->error ( '您还没有登录！', U ( 'portal/member/index' ) );
			exit ();
		}
	}
	
	/**
	 * 获取前台导航信息
	 * 2014-09-08
	 * *
	 */
	function nav() {
		$rs = M ( 'nav' )->where (array('status'=>'1'))->order ( 'listorder asc' )->select ();
		if ($_GET) {
			foreach ( $rs as &$k ) {
				if ($k ['id'] == I ( 'menu_id' )) {
					$k ['class'] = 'header_nav_def';
				}
			}
		} else {
			$rs ['0'] ['class'] = 'header_nav_def';
		}
		
		return $rs;
	}
	// 数据分页
	protected function page($Total_Size = 1, $Page_Size = 0,$page_sf=0, $Current_Page = 1, $listRows = 6, $PageParam = 'page', $PageLink = '', $Static = FALSE) {
		if ($Page_Size == 0) {
			$Page_Size = C ( "PAGE_LISTROWS" );
		}
		if (empty ( $PageParam )) {
			$PageParam = C ( "VAR_PAGE" );
		}
		$Page = new \Common\Lib\Util\Page ( $Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static );
		if($page_sf==0){
			$Page->SetPager ( 'Home', '{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array (
					"listlong" => "6",
					"first" => "首页",
					"last" => "尾页",
					"prev" => "上一页",
					"next" => "下一页",
					"list" => "*",
					"disabledclass" => ""
			) );
		}else{
			$Page->SetPager ( 'Home', '{liststart}{list}{listend}', array (
					"listlong" => "6",
					"first" => "首页",
					"last" => "尾页",
					"prev" => "上一页",
					"next" => "下一页",
					"list" => "*",
					"disabledclass" => ""
			) );
		}
		
		return $Page;
	}
	
	/**
	 * 发送验证码
	 *
	 * @param $phone [手机号]        	
	 * @param $content [发送内容]        	
	 * @return
	 *
	 *
	 *
	 *
	 */
	protected function sendMESSAGES($phone, $content) {
		set_time_limit ( 0 );
		header ( "Content-Type: text/html; charset=UTF-8" );
		
		$gwUrl = 'http://sdk.univetro.com.cn:6200/sdk/SDKService';
		$serialNumber = '7SDK-LHW-0588-OKWSP';
		$password = '264595';
		$sessionKey = '123456';
		$connectTimeOut = 5;
		$readTimeOut = 60;
		
		vendor ( 'Emay.nusoaplib.nusoap' );
		vendor ( 'Emay.include.Client' );
		$client = new \Client ( $gwUrl, $serialNumber, $password, $sessionKey, false, false, false, false, $connectTimeOut, $readTimeOut );
		$client->setOutgoingEncoding ( "UTF-8" );
		$client->login ( $sessionKey );
		$statusCode = $client->sendSMS ( array (
				$phone 
		), $content );

		//短信记录
		M('SmsLog')->add(array('phone'=>$phone,'content'=>$content,'status'=>$statusCode,'dateline'=>time()));

		if ($statusCode != null && $statusCode == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 得到数据分页
	 *
	 * @param string $modelName
	 *        	模型名称
	 * @param array $where
	 *        	分页条件
	 * @return array
	 */
	protected function getPagination($modelName, $where, $fields, $order, $mpage = '10') {
		$model = M ( $modelName );
		// 总数据行数
		$totalRows = $model->where ( $where )->count ();
		// 实例化分页
		$page = new \Think\Page ( $totalRows, $mpage );
		$page->setConfig ( 'prev', '上一页' );
		$page->setConfig ( 'next', '下一页' );
		$page->setConfig ( 'first', '首页' );
		$page->setConfig ( 'last', '尾页' );
		$result ['show'] = $page->show ();
		// 得到分页数据
		$data = $this->getPaginations ( $modelName, $where, $fields, $order, $page->firstRow, $page->listRows );
		
		$result ['data'] = $data;
		$result ['total_rows'] = $totalRows;
		return $result;
	}
	
	/**
	 * 得到分页数据
	 *
	 * @param array $where
	 *        	分页条件
	 * @param int $firstRow
	 *        	起始行
	 * @param int $listRows
	 *        	行数
	 * @return array
	 */
	protected function getPaginations($modelName, $where, $fields, $order, $firstRow, $listRows) {
		$M = M ( $modelName );
		// 需要查找的字段
		if (isset ( $fields )) {
			$M = $M->field ( $fields );
		}
		
		// 条件查找
		if (isset ( $where )) {
			$M = $M->where ( $where );
		}
		
		// 数据排序
		if (isset ( $order )) {
			$M = $M->order ( $order );
		}
		
		// 查询限制
		if (isset ( $firstRow ) && isset ( $listRows )) {
			$M = $M->limit ( $firstRow . ',' . $listRows );
		} else if (isset ( $listRows ) && isset ( $firstRow )) {
			$M = $M->limit ( $listRows );
		}
		
		return $M->select ();
	}
	
	/**
	 * 积分管理
	 * 参数：operation = 操作 uid = 用户id（默认当前）
	 * *
	 */
	function integrals($operation, $uid = '') {
		if($_SESSION['MEMBER_id']){
			// 获取用户id
			if ($uid == '') {
				$uid = $_SESSION ['MEMBER_id'];
			}
			// 判断做了哪些操作
			$rs = M('integrals')->where(array('key'=>$operation))->find();
			if($rs){
				//读取用户信息
				$user = M('members')->where(array('ID'=>$uid))->find();
				//修改用户积分以及红途币
				if($operation=='report'){
					$data['score'] = $user['score'] - $rs['integrals'];
				}else{
					$data['score'] = $user['score'] + $rs['integrals'];
					$data['redcoin'] = $user['redcoin'] + $rs['coin'];
				}
				$data['ID']  = $user['ID'];
				M('members')->save($data);
				//生成记录
				$da['operation'] = $rs['operation'];
				$da['date'] = time();
				$da['uid'] = $user['ID'];
				$da['integrals'] = $rs['integrals'];
				$da['coin'] = $rs['coin'];
				$da['remarks'] = $rs['remarks'];
				M('integrals_record')->add($da);
				$this->userGroup($uid);
			}else{
				$this->error('该操作不存在');
			}
		}else{
			$this->error('您还没有登录',U('Member/index'));
		}
	}
	
	//判断用户等级
	function userGroup($id){
		$user = M('members')->where(array('ID'=>$id))->find();
		//查询所属小组
		$group = M('members_group')->where(array('id'=>$user['group']))->find();
		$num = explode(',',$group['score']);
		if($user['score'] > $num[1]){
			$data['group'] = $user['group']+1;
			M('members')->where(array('ID'=>$id))->save($data);
		}
		/*
		if($user['score']>20){
			if($user['score'] < $num[0]){
				$data['group'] = $user['group']-1;
				M('members')->where(array('ID'=>$id))->save($data);
			}
		}*/
	}
}
