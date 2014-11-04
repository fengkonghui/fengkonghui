<?php	return array (
  'app' => 'Admin',
  'model' => 'Member',
  'action' => 'default',
  'data' => '',
  'type' => '1',
  'status' => '1',
  'name' => '用户管理',
  'icon' => 'group',
  'remark' => '',
  'listorder' => '0',
  'items' => 
  array (
    0 => 
    array (
      'app' => 'Admin',
      'model' => 'Member',
      'action' => 'default1',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '用户组',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
      'items' => 
      array (
        0 => 
        array (
          'app' => 'Admin',
          'model' => 'Member',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '本站用户',
          'icon' => 'leaf',
          'remark' => '',
          'listorder' => '0',
        ),
        1 => 
        array (
          'app' => 'Admin',
          'model' => 'Api',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '第三方用户',
          'icon' => 'leaf',
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
    1 => 
    array (
      'app' => 'Admin',
      'model' => 'Member',
      'action' => 'default3',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '管理组',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
      'items' => 
      array (
        0 => 
        array (
          'app' => 'Admin',
          'model' => 'Rbac',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '角色管理',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        1 => 
        array (
          'app' => 'Admin',
          'model' => 'User',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '管理员',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
  ),
);?>