<?php

namespace Admin\Model;

use Admin\Model\CommonModel;

class ZhuantiModel extends CommonModel {

	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('zt_title', 'require', '专题主题不能为空！', 1, 'regex', 3),
		array('zt_content', 'require', '专题内容不能为空！', 1, 'regex', 3),
	);

}
