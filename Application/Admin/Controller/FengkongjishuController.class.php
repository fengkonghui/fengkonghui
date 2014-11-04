<?php

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class FengkongjishuController extends AdminbaseController {
	protected $zhuanti_obj;
	function _initialize() {
		parent::_initialize ();
		$this->zhuanti_obj = D ( "zhuanti" );
		$this->zhuanti_week = M ("Zhuanti_week");
	}
	/**
	 * 首页查询数据
	 * *
	 */
	function index() {
		$arr = $this->zhuanti_obj->select();
		//时间转换
		foreach ($arr as &$k){
			$k['zt_create_time'] = date('Y-m-d',$k['zt_create_time']);
		}
		$this->assign('zhuanti',$arr);
		$this->display ();
	}
	/**
	 * 添加数据
	 */
	function add() {
		if (IS_POST) {
			//自动添加
			$_POST['zt_create_time'] = time();
			$_POST['zt_state']	= 0;
			$_POST['zt_createby'] = $_SESSION['user']['user_login'];
			if ($this->zhuanti_obj->create ()) {
				if (false !== $this->zhuanti_obj->add ()) {
					$this->success ( "保存成功！", U ( "fengkongzhuanti/index" ) );
				} else {
					$this->error ( '保存失败' );
				}
			} else {
				$this->error ( $this->zhuanti_obj->getError () );
			}
		} else {
			$this->display ();
		}
	}
	/**
	 * 修改数据
	 * ***/
	function edit(){
		if(IS_POST){
			if ($this->zhuanti_obj->create ()) {
				if (false !== $this->zhuanti_obj->save ()) {
					$this->success ( "保存成功！", U ( "fengkongzhuanti/index" ) );
				} else {
					$this->error ( '保存失败' );
				}
			} else {
				$this->error ( $this->zhuanti_obj->getError () );
			}
		}else{
			//接受数据查询内容
			$id  = I('get.zt_id');
			$rs = $this->zhuanti_obj->where('ID='.$id)->find();
			$this->assign('zhuanti',$rs);
			$this->display ();
		}
	}
	/**
	 * 删除数据
	 * ***/
	function delete(){
		if(IS_GET){
			//接受数据删除一条数据
			$id = I('get.zt_id');
			if($this->zhuanti_obj->delete($id)){
				$this->success();
			}else{
				$this->error();
			}
		}
		if(IS_POST){
			$stat = 0;
			$num = count($_POST['ids']);
			for($i=0;$i<$num;$i++){
				if($this->zhuanti_obj->delete($_POST['ids'][$i])){
					$stat = 1;
				}else{
					$stat = 0;
				}
			}
			if($stat==1){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}
	//更改期数
	function zt_period(){
	if(IS_POST){
			$stat = 0;
			$num = count($_POST['ids']);
			for($i=0;$i<$num;$i++){
				$data['ID'] = $_POST['ids'][$i];
				$data['zt_period'] = I('get.check');
				if( $this->zhuanti_obj->save($data) ){
					$stat = 1;
				}else{
					$stat = 0;
				}
			}
			if($stat==1){
				$this->success('设置成功');
			}else{
				$this->error('设置失败');
			}
		}
	}
	/***
	 * 技术知识
	 * **/
	function jishu(){
		$rs = M('jishu_cont')->select();
		$this->assign('jishu',$rs);
		$this->display();
	}
	
	//添加
	function jadd(){
		if(IS_POST){
			$_POST['js_createby'] = $_SESSION['user']['user_login'];
			if(M('jishu_cont')->add($_POST)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			//技术分类
			$jishu = M('Jishu_type');
			$type = $jishu->where('tid=0')->select();
			$types = array();
			if(!empty($type)){
				foreach ($type as $key => $value) {
					$types[] = array(
						'ty_title' => $value['ty_title'],
						'type_two' => $jishu->where('tid=%d',array($value['ID']))->select()
					);
				}
			}
			$this->assign('type',$types);
			$this->display();
		}
	}
	/**
	 * 知识分类
	 * **/
	function type(){
		$result = M('Jishu_type')->select();
		$tree = new \Common\Lib\Util\Trees($result,'ID','tid','lv');
		$this->assign('type',$tree->tree);
		$this->display();
	}

	//添加
	function tadd(){
		if(IS_POST){
			$_POST['tid'] = $_POST['tid'] ? $_POST['tid'] : 0;
			//进行添加数据
			if(M('jishu_type')->add($_POST)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			//读取一级
			$result = M('Jishu_type')->where('tid=0')->select();
			$this->assign('type',$result);
			$this->display();
		}
	}
	//修改
	function tedit(){
		if(IS_POST){
			if(M('jishu_type')->save($_POST)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			//查询本条数据
			$id = I('get.ty_id');
			$re = M('jishu_type')->find($id);
			//读取一级
			$result = M('Jishu_type')->where('tid=0')->select();
			$this->assign('type',$result);
			$this->assign('arr',$re);
			$this->display();
		}
	}
	//删除
	function tdelete(){
		if(IS_POST){
			$stat = 0;
			$num = count($_POST['ids']);
			for($i=0;$i<$num;$i++){
				if(M('jishu_type')->delete($_POST['ids'][$i])){
					$stat = 1;
				}else{
					$stat = 0;
				}
			}
			if($stat==1){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
		if(I('get.ty_id')){
			//删除单条数据
			$id = I('get.ty_id');
			if(M('jishu_type')->delete($id)){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}
	
	/**
	 * pdf 下载
	 * **/
	function xiazaiPDF(){
		//通过id查询数据
		$rs = M('jishu_cont')->find(I('get.js_id'));
		header("Content-type:application/pdf");
		// 文件将被称为 downloaded.pdf
		$fine_name = time().'_fkh.pdf';
		header("Content-Disposition:attachment;filename=".$fine_name);
		// PDF 源在 sss.pdf 中
		$file_url = './'.$rs['js_url'];
		readfile($file_url);
	}
	
	/**
	 * 技术知识
	 * **/
	function read(){
		$rs = M('tuijian_yuedui')->select();
		$this->assign('read',$rs);
		$this->display();
	}
	//添加
	function radd(){
		if(IS_POST){
			if(empty($_POST['title']))
				$this->error('标题不能为空');
			if(empty($_POST['class']))
				$this->error('请选择收费标准');
			if($_POST['class']==3){
				if(empty($_POST['group']))
					$this->error('请选择会员组');
				if(empty($_POST['price']) || $_POST['price']<=0)
					$this->error('红途币不能为空或必须大于0');
			}else{
				$_POST['group'] = 0;
				$_POST['price'] = 0;
			}
			if(empty($_POST['type']))
				$this->error('请选择技术分类');
			if(empty($_POST['tj_url']))
				$this->error('文件不能为空');
			if(empty($_POST['tj_img']))
				$this->error('文档封面不能为空');
			$_POST['tag'] = ','.implode(',',$_POST['tag']).',';
			$_POST['tj_createby'] = $_SESSION['user']['user_login'];
			if(M('tuijian_yuedui')->add($_POST)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			//会员等级
			$group = M('Members_group');
			$result = $group->where('gid=0')->select();
			$level = array();
			if(!empty($result)){
				foreach ($result as $key => $value) {
					$level[] = array(
						'name' => $value['name'],
						'levels' => $group->where('gid=%d',array($value['id']))->select()
					);
				}
			}
			//技术分类
			$jishu = M('Jishu_type');
			$type = $jishu->where('tid=0')->select();
			$types = array();
			if(!empty($type)){
				foreach ($type as $key => $value) {
					$types[] = array(
						'ty_title' => $value['ty_title'],
						'type_two' => $jishu->where('tid=%d',array($value['ID']))->select()
					);
				}
			}
			//标签
			$tag = M('Biaoqian')->select();
			$this->assign('tag',$tag);
			$this->assign('type',$types);
			$this->assign('group',$level);
			$this->display();
		}
	}

	//修改
	function redit(){
		if(IS_POST){
			if(empty($_POST['title']))
				$this->error('标题不能为空');
			if(empty($_POST['class']))
				$this->error('请选择收费标准');
			if($_POST['class']==3){
				if(empty($_POST['group']))
					$this->error('请选择会员组');
				if(empty($_POST['price']) || $_POST['price']<=0)
					$this->error('红途币不能为空或必须大于0');
			}else{
				$_POST['group'] = 0;
				$_POST['price'] = 0;
			}
			if(empty($_POST['type']))
				$this->error('请选择技术分类');
			if(empty($_POST['tj_url']))
				$this->error('文件不能为空');
			if(empty($_POST['tj_img']))
				$this->error('文档封面不能为空');
			$_POST['tag'] = ','.implode(',',$_POST['tag']).',';
			if(M('tuijian_yuedui')->save($_POST)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			//查询数据
			$rs = M('tuijian_yuedui')->find(I('get.tj_id'));
			//会员等级
			$group = M('Members_group');
			$result = $group->where('gid=0')->select();
			$level = array();
			if(!empty($result)){
				foreach ($result as $key => $value) {
					$level[] = array(
						'name' => $value['name'],
						'levels' => $group->where('gid=%d',array($value['id']))->select()
					);
				}
			}
			//技术分类
			$jishu = M('Jishu_type');
			$type = $jishu->where('tid=0')->select();
			$types = array();
			if(!empty($type)){
				foreach ($type as $key => $value) {
					$types[] = array(
						'ty_title' => $value['ty_title'],
						'type_two' => $jishu->where('tid=%d',array($value['ID']))->select()
					);
				}
			}

			//标签
			$tag = M('Biaoqian')->select();
			$this->assign('tag',$tag);
			$this->assign('type',$types);
			$this->assign('group',$level);
			$this->assign('read',$rs);
			$this->display();
		}
	}
	//删除
	function rdelete(){
		if($_GET['tj_id']){
			//删除单条数据
			if(M('tuijian_yuedui')->delete(I('get.tj_id'))){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
		if(IS_POST){
			$stat = 0;
			$num = count($_POST['ids']);
			for($i=0;$i<$num;$i++){
				if(M('tuijian_yuedui')->delete($_POST['ids'][$i])){
					$stat = 1;
				}else{
					$stat = 0;
				}
			}
			if($stat==1){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	//网友技术
	public function wangyou(){
		$result = M('Share')->order('id desc')->select();
		$this->assign('_list',$result);
		$this->display();
	}

	//网友技术编辑
	public function wangyouedit(){
		if(IS_POST){
			$result = M('Share')->where("id=%d",array(I('post.id')))->save($_POST);
			if ($result) {
				$this->success ( '修改成功' );
			} else {
				$this->error ( '修改失败' );
			}
		}else{
			if(!I('get.id')){
				$this->error('网络请求超时，请刷新重试！');
			}
			$result = M('Share')->where("id=%d",array(I('get.id')))->find();
			$this->assign('_info',$result);
			$this->display ();
		}
	}
	//网友技术删除
	public function wangyouDel(){
		// 删除单条数据
		if (IS_GET) {
			$id = ( int ) I ( "get.id" );
			if (M('Share')->delete ( $id )) {
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
				if (M('Share')->delete ( $_POST ['ids'] [$i] )) {
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

	//风控专家
	public function expert(){
		$result = M('Zhuanti_expert')->select();
		$this->assign('_list',$result);
		$this->display();
	}

	//风控专家删除
	public function expertDel(){
		if(IS_GET){
			$id = I('get.id');
			if(M('Zhuanti_expert')->delete($id)){
				$this->success();
			}else{
				$this->error();
			}
		}
		if(IS_POST){
			$stat = 0;
			$num = count($_POST['ids']);
			for($i=0;$i<$num;$i++){
				if(M('Zhuanti_expert')->delete($_POST['ids'][$i])){
					$stat = 1;
				}else{
					$stat = 0;
				}
			}
			if($stat==1){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	//风控专家添加
	public function expertAdd(){
		if(IS_POST){
			if(!I('post.mobile')){
				$this->error('请输入手机号');
			}
			$_info = M('Members')->where("user_tel=".I('post.mobile'))->find();
			if(!$_info){
				$this->error('你输入的手机号不存在，请重新输入');
			}

			if(M('Zhuanti_expert')->where('uid=%d',array($_info['ID']))->count() > 0 ){
				$this->error('专家已加入，请输入其它专家');
			}

			if(M('Zhuanti_expert')->add(array('uid'=>$_info['ID'],'dataline'=>time()))){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
	}

	//推荐阅读下载
	function TJxiazaiPDF(){
		//通过id查询数据
		$rs = M('tuijian_yuedui')->find(I('get.tj_id'));
		header("Content-type:application/pdf");
		// 文件将被称为 downloaded.pdf
		$fine_name = time().'_fkh.pdf';
		header("Content-Disposition:attachment;filename=".$fine_name);
		// PDF 源在 sss.pdf 中
		$file_url = './'.$rs['tj_url'];
		readfile($file_url);
	}
	
	//下周专题
	public function week(){
		$result = $this->zhuanti_week->where('endtime>'.time())->order('starttime asc')->select();
		$this->assign('week',$result);
		$this->display();
	}

	//添加下周专题
	public function weekAdd(){
		if(IS_POST){
			if(!I('post.series') || I('post.series')<=0)
				$this->error('周期不能为空');
			if(!I('post.title'))
				$this->error('主题名称也不能为空');

			$data['series'] = I('post.series');
			$data['title'] = I('post.title');
			$data['starttime'] = week(date('Y'),I('post.series'),'1');
			$data['endtime'] = strtotime(date('Y-m-d',week(date('Y'),I('post.series'),'7')).' 23:59:59');
			$data['dataline'] = time();
			$result = $this->zhuanti_week->add($data);
			if(!$result)
				$this->error('创建失败');
			$this->success('创建成功');
		}else{
			$start = mktime(0,0,0,01,01,date('Y'));
			$now = strtotime('+1 week sunday');
			$week = ceil(($now-$start)/(3600*24*7));
			$this->assign('week',$week);
			$this->display();
		}
	}

	//删除下周专题
	public function weekDel(){

		if(IS_GET){
			$id = I('get.id');
			if($this->zhuanti_week->delete($id)){
				$this->success();
			}else{
				$this->error();
			}
		}
		if(IS_POST){
			$stat = 0;
			$num = count($_POST['ids']);
			for($i=0;$i<$num;$i++){
				if($this->zhuanti_week->delete($_POST['ids'][$i])){
					$stat = 1;
				}else{
					$stat = 0;
				}
			}
			if($stat==1){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	//编辑下周专题
	public function weekEdit(){
		if(IS_POST){
			if(!I('post.id'))
				$this->error('连接超时，请刷新后重试');
			if(!I('post.series') || I('post.series')<=0)
				$this->error('周期不能为空');
			if(!I('post.title'))
				$this->error('主题名称也不能为空');

			$data['series'] = I('post.series');
			$data['title'] = I('post.title');
			$data['starttime'] = week(date('Y'),I('post.series'),'1');
			$data['endtime'] = strtotime(date('Y-m-d',week(date('Y'),I('post.series'),'7')).' 23:59:59');
			$result = $this->zhuanti_week->where("id=%d",array(I('post.id')))->save($data);
			if(!$result)
				$this->error('修改失败');
			$this->success('修改成功');
		}else{
			if(!I('get.id'))
				$this->error('连接超时，请刷新后重试');
			$_info = $this->zhuanti_week->where("id=%d",array(I('get.id')))->find();
			$this->assign('_info',$_info);
			$this->display();
		}
	}

	//ajax
	public function weekTis(){
		if(!I('post.week') || I('post.week')<=0)
			return ;
		echo date('Y年m月d日',week(date('Y'),I('post.week'),'1')).'&nbsp;-&nbsp;'.date('Y年m月d日',week(date('Y'),I('post.week'),'7'));
	}
}
