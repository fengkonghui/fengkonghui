<?php
function getYesNo($v) {
	return $v ? '是' : '否';
}
//查询发布人
function userName($id){
	return M ( 'users' )->where ( array (
			'ID' => $id
	) )->getField ( 'user_login' );
}

//查询文章分类名
function articlesType($id){
	return M('articles_type')->where(array('id'=>$id))->getField('name');
}

//查询小组分类
function groupClass($id){
	return M('group_class')->where(array('id'=>$id))->getField('name');
}

//查询本站用户
function memberName($id){
	return M('members')->where(array('ID'=>$id))->getField('user_login_name');
}

//统计小组参与人数
function groupBy($id){
	//去重统计
	return M('group_extend')->where(array('gid'=>$id))->count('distinct(uid)');
}

//统计举报人数
function askUser($id){
	//去重统计
	return M('ask_report')->where(array('aid'=>$id))->count('distinct(uid)');
}

//公司类别
function company_type($id){
	return M('members_category')->where(array('id'=>$id))->getField('name');
}

//职务级别
function user_post_level($id){
	return M('members_post_level')->where(array('id'=>$id))->getField('name');
}

//所在城市
function user_city($id){
	return M('area')->where(array('id'=>$id))->getField('area_title');
}