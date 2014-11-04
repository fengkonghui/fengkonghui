<?php

/* * 
 * 类别管理
 */

namespace Admin\Model;
use Admin\Model\CommonModel;

class MembersModel extends CommonModel {
	//自动验证
	protected $_validate = array(
		array('user_tel', 'require', '手机号不能为空', 1, 'regex', 3),
		array('user_tel','','手机号已经存在！',0,'unique',1),
	);
}