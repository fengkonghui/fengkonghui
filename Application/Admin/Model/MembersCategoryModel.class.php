<?php

/* * 
 * 类别管理
 */

namespace Admin\Model;
use Admin\Model\CommonModel;

class MembersCategoryModel extends CommonModel {
	//自动验证
	protected $_validate = array(
		array('name', 'require', '类别名称不能为空', 1, 'regex', 3),
		array('name','','类别名称已经存在！',0,'unique',1),
	);
}