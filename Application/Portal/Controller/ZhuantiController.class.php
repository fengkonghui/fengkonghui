<?php

/**
 * 首页
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;

class ZhuantiController extends HomeBaseController {
	
	// 首页
	public function index() {
		// 查询本期专题，并按照获得票数进行排序查询前三条
		$arr = M ( 'zhuanti' )->where ( 'zt_period=1' )->limit ( '0,3' )->order ( 'zt_content desc' )->select ();
		$zhuanti_1 = $arr ['0'];
		$zhuanti_2 = $arr ['1'];
		$zhuanti_3 = $arr ['2'];
		$this->assign ( 'zhuanti', $arr );
		
		// 查询下期专题
		$zhuanti_week = M ( 'Zhuanti_week' );
		$series = $this->series ();
		$result = $zhuanti_week->where ( "series={$series}" )->limit ( 9 )->select ();
		$this->assign ( 'xq_zhuanti1', $result );
		
		$piaoshu = $zhuanti_week->where ( "series={$series}" )->field ( 'number' )->limit ( 9 )->select ();
		$num = 1;
		foreach ( $piaoshu as &$k ) {
			$k ['num'] = $num;
			$num ++;
		}
		$this->assign ( 'vote_total', $zhuanti_week->where ( "series={$series}" )->sum ( 'number' ) );
		$this->assign ( 'piaoshu', $piaoshu );
		// 查询分类
		$rs = M ( 'jishu_type' )->where ( 'tid=0' )->select ();
		$rs ['0'] ['class'] = 'div_def';
		$this->assign ( 'type', $rs );
		$jishu = M ( 'jishu_type' )->where ( 'tid=%d', array (
				$rs [0] ['ID'] 
		) )->select ();
		$this->assign ( 'jishu', $jishu );
		// 查询推荐阅读
		$rs2 = M ( 'tuijian_yuedui' )->where ( "recommend=1" )->limit ( '0,5' )->select ();
		$this->assign ( 'read', $rs2 );
		$rs3 = M ( 'tuijian_yuedui' )->where ( "recommend=1" )->limit ( '5,5' )->select ();
		$this->assign ( 'read1', $rs3 );
		// 查询网友分享技术
		$this->jishufenxiang ( I ( 'get.type' ) );
		
		// 风控专家
		$expert = M ( 'Zhuanti_expert' )->select ();
		$this->assign ( 'expert', $expert );
		
		$this->display ( "Portal:fengkongzhuanti" );
	}
	
	// 技术文档列表
	public function technical() {
		if (I ( 'get.type' ))
			$where ['type'] = array (
					'eq',
					I ( 'get.type' ) 
			);
		$result = $this->getPagination ( 'TuijianYuedui', $where, '', '', '40' );
		// 分类名称
		$typename = M ( 'Jishu_type' )->where ( 'ID=%d', array (
				I ( 'get.type' ) 
		) )->getField ( 'ty_title' );
		$this->assign ( 'typename', $typename );
		$this->assign ( '_list', $result ['data'] );
		$this->assign ( '_page', $result ['show'] );
		$this->display ( "Portal:technical_list" );
	}
	
	// 详情
	public function zhuanti_show() {
		if (! I ( 'get.id' ))
			redirect ( '/' );
		$result = M ( 'Zhuanti' )->where ( "ID=%d", array (
				I ( 'get.id' ) 
		) )->find ();
		$this->assign ( '_info', $result );
		$this->assign ( 'id', I ( 'get.id' ) );
		$this->zhuanti_pinglun_cont ( I ( 'get.id' ) );
		
		$this->display ( "Portal:zhuanti_show" );
	}
	public function zhuanti_pinglun() {
		if (I ( 'post.sub' )) {
			// 数据
			$_POST ['create_time'] = time ();
			$_POST ['user_id'] = $_SESSION ["MEMBER_id"];
			$_POST ['parent_id'] = (I ( 'replyfor' ) ? I ( 'replyfor' ) : 0);
			if (M ( 'comment_zt0' )->add ( $_POST )) {
				$this->success ( '评论成功' );
			} else {
				$this->error ( '评论失败' );
			}
		}
	}
	// 评论内容
	function zhuanti_pinglun_cont($id) {
		$where ['credit_id'] = $id;
		$where ['parent_id'] = 0;
		
		$rs = M ( 'comment_zt0' )->where ( $where )->select ();
		// 循环查询其他
		foreach ( $rs as &$k ) {
			$rs1 = M ( 'comment_zt0' )->where ( 'parent_id=' . $k ['id'] )->select ();
			$k ['replyfor'] = $rs1;
			$k ['num'] = M ( 'comment_zt0' )->where ( 'parent_id=' . $k ['id'] )->count ();
		}
		$this->assign ( 'pinglun', $rs );
	}
	public function ajToupiao() {
		// 是否登录
		$memid = $_SESSION ["MEMBER_id"];
		
		if (! $_SESSION ["MEMBER_id"]) {
			echo json_encode ( array (
					'info' => '请登录后再投票！',
					'status' => 0 
			) );
			exit ();
		}
		
		// 查询下周期号是否已投票
		if (M ( 'Zhuanti_week_log' )->where ( "uid=%d AND zid=%d", array (
				$memid,
				$this->series () 
		) )->count () > 0) {
			echo json_encode ( array (
					'info' => '您已投票！',
					'status' => 0 
			) );
			exit ();
		}
		
		// 投票
		$ids = I ( 'post.ids' );
		$arr = array_filter ( explode ( ',', $ids ) );
		if (count ( $arr ) != 3) {
			echo json_encode ( array (
					'info' => '请选择三项!',
					'status' => 0 
			) );
			exit ();
		}
		foreach ( $arr as $v ) {
			$reslut = M ( 'Zhuanti_week' )->where ( "id=%d", array (
					$v 
			) )->setInc ( 'number' );
		}
		
		// 投票记录
		$re = M ( 'Zhuanti_week_log' )->add ( array (
				'uid' => $memid,
				'dataline' => time (),
				'zid' => $this->series () 
		) );
		if ($re) {
			$this->integrals('the_vote');
			echo json_encode ( array (
					'status' => 1 
			) );
		} else {
			echo json_encode ( array (
					'info' => '投票失败！',
					'status' => 0 
			) );
		}
	}
	public function ajZhishi() {
		$rs = M ( 'jishu_type' )->where ( "tid=%d", array (
				I ( 'post.ty_id' ) 
		) )->select ();
		$html = '';
		foreach ( $rs as $k ) {
			$url = U ( 'zhuanti/technical', array (
					'type' => $k ['ID'] 
			) );
			$html .= "<div><a href=" . $url . ">" . $k ['ty_title'] . "</a></div>";
		}
		echo $html;
	}
	public function pdfXiazai() {
		$rs = M ( 'jishu_cont' )->find ( I ( 'get.js_id' ) );
		header ( "Content-type:application/pdf" );
		// 文件将被称为 downloaded.pdf
		$fine_name = time () . '_fkh.pdf';
		header ( "Content-Disposition:attachment;filename=" . $fine_name );
		// PDF 源在 sss.pdf 中
		$file_url = './' . $rs ['js_url'];
		readfile ( $file_url );
	}
	/**
	 * 下载信息
	 * *
	 */
	public function pdfTuijian() {
		if (! $_SESSION ["MEMBER_id"]) {
			$this->error('您还没有登录，请登录',U('Member/index'));
		}
		// 通过id查询数据
		$rs = M ( 'tuijian_yuedui' )->where ( "ID=%d", array (
				I ( 'get.ty_id' ) 
		) )->find ();
		$user = getCMember ();
		// 条件
		switch ($rs ['class']) {
			case '2' :
				header ( "Content-type: text/html; charset=utf-8" ); // type
				if ($user ['type'] != 'enterprise')
					echo '<script>alert("你的等级不够！"); javascript:history.go(-1);</script>';
				exit ();
				break;
			
			case '3' :
				header ( "Content-type: text/html; charset=utf-8" );
				if ($user ['redcoin'] < $rs ['price'] && $user ['group'] < $rs ['group']) {
					echo '<script>alert("红途币不够！"); javascript:history.go(-1);</script>';
					exit ();
				} else {
					// 减会员红途币
					M ( 'Members' )->where ( "ID=%d", array (
							$user ['ID'] 
					) )->setDec ( 'redcoin', $rs ['price'] );
				}
				break;
		}
		
		header ( "Content-type:application/pdf" );
		// 文件将被称为 downloaded.pdf
		$fine_name = time () . '_fkh.pdf';
		header ( "Content-Disposition:attachment;filename=" . $fine_name );
		// PDF 源在 sss.pdf 中
		$file_url = './' . $rs ['tj_url'];
		readfile ( $file_url );
	}
	
	/**
	 * 网友技术分享
	 */
	public function jishu() {
		$this->checklogin ();
		
		if (IS_POST) {
			$data = I ( 'post.' );
			$data ['tags'] = implode ( ',', $data ['tag'] );
			$data ['user_tags'] = implode ( ',', $data ['user_tag'] );
			$data ['user_id'] = $_SESSION ["MEMBER_id"];
			$data ['dataline'] = time ();
			
			if (M ( 'share' )->add ( $data )) {
				$this->integrals('ordinary_share_technology');
				$this->success ( '分享成功', U ( 'zhuanti/index', array (
						'id' => 3 
				) ) );
			} else {
				$this->error ( '分享失败' );
			}
		} else {
			// 查询所有标签
			$rs = M ( 'biaoqian' )->where ( 'zhuangtai=1' )->select ();
			$this->assign ( 'arr', $rs );
			$this->display ( "Portal:jishufenxiang" );
		}
	}
	
	/**
	 * 查询下周期号
	 */
	protected function series() {
		$series = ceil ( (strtotime ( '+1 week sunday' ) - mktime ( 0, 0, 0, 01, 01, date ( 'Y' ) )) / (3600 * 24 * 7) );
		return $series;
	}
	
	/**
	 * 技术详情
	 * *
	 */
	function jishuxiangqing() {
		// 浏览+1
		M ( 'Share' )->where ( 'id=%d', I ( 'get.xq_id' ) )->setInc ( 'hits' );
		// 查询本条数据
		$rs = M ( 'share' )->find ( I ( 'get.xq_id' ) );
		$rs ['tag'] = explode ( ',', $rs ['tags'] );
		$rs ['user_tag'] = explode ( ',', $rs ['user_tags'] );
		$this->assign ( 'share', $rs );
		$this->assign ( 'id', I ( 'get.xq_id' ) );
		$this->pinglun_cont ( I ( 'get.xq_id' ) );
		$this->display ( 'Portal:jishuxiangqing' );
	}
	/**
	 * 技术分享
	 * *
	 */
	function jishufenxiang($type) {
		// 条件查询
		switch ($type) {
			case 'essence' : // 精华
				$order = 'cream desc';
				break;
			
			case 'popularity' : // 人气
				$order = 'hits desc';
				break;
			
			default : // 最新
				$order = 'id desc';
				break;
		}
		$where ['chcek'] = array (
				'neq',
				2 
		);
		// 分页查询
		$count = M ( 'share' )->where ( $where )->count ();
		$page = $this->page ( $count, 6 );
		$rs4 = M ( 'share' )->limit ( $page->firstRow . ',' . $page->listRows )->where ( $where )->order ( $order )->select ();
		$this->assign ( "Page", $page->show ( 'Home' ) );
		$this->assign ( 'fenxiang', $rs4 );
	}
	
	/**
	 * 专题评论
	 * **
	 */
	function pinglun() {
		if (I ( 'post.sub' )) {
			// 数据
			$_POST ['create_time'] = time ();
			$_POST ['user_id'] = $_SESSION ["MEMBER_id"];
			$_POST ['parent_id'] = (I ( 'replyfor' ) ? I ( 'replyfor' ) : 0);
			if (M ( 'comment_zt' )->add ( $_POST )) {
				$this->integrals('comment');
				$this->success ( '评论成功' );
			} else {
				$this->error ( '评论失败' );
			}
		}
	}
	// 评论内容
	function pinglun_cont($id) {
		$where ['credit_id'] = $id;
		$where ['parent_id'] = 0;
		
		$rs = M ( 'comment_zt' )->where ( $where )->select ();
		// 循环查询其他
		foreach ( $rs as &$k ) {
			$rs1 = M ( 'comment_zt' )->where ( 'parent_id=' . $k ['id'] )->select ();
			$k ['replyfor'] = $rs1;
			$k ['num'] = M ( 'comment_zt' )->where ( 'parent_id=' . $k ['id'] )->count ();
		}
		$this->assign ( 'pinglun', $rs );
	}
}
