<?php

namespace Admin\Model;

use Admin\Model\CommonModel;

class CreditModel extends CommonModel {

	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('xd_title', 'require', '信贷标题不能为空！', 1, 'regex', 3),
	);

}
