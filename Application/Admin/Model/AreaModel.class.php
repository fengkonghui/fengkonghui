<?php

/* * 
 * 区域管理
 */

namespace Admin\Model;
use Admin\Model\CommonModel;

class AreaModel extends CommonModel {
	//自动验证
	protected $_validate = array(
		array('area_title', 'require', '区域名称不能为空', 1, 'regex', 3),
		array('area_title','','区域名称已经存在！',0,'unique',1),
	);
}