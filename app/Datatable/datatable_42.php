<?php return array (
  'id' => 42,
  'title' => '系统用户管理',
  'pid' => 40,
  'model' => '2',
  'url' => '/system/user/index',
  'method' => 'UserController@index',
  'module_id' => '2',
  'main_table' => 'blk_users',
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
    'remember_token' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '100',
      'sorting' => NULL,
      'fixed' => NULL,
      'title' => '记住账号',
      'field' => 'remember_token',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'id' => 
    array (
      'field_type' => 'bigint',
      'field_length' => '20 unsigned',
      'sorting' => '1',
      'fixed' => NULL,
      'title' => 'UID',
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => '80',
      'read' => 'on',
    ),
    'name' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '30',
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '姓名',
      'field' => 'name',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'phone' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '20',
      'sorting' => '3',
      'fixed' => NULL,
      'title' => '电话',
      'field' => 'phone',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'email' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '50',
      'sorting' => '4',
      'fixed' => NULL,
      'title' => '电子邮箱',
      'field' => 'email',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'email_verified_at' => 
    array (
      'field_type' => 'timestamp',
      'field_length' => 'no_limit',
      'sorting' => '5',
      'fixed' => NULL,
      'title' => '电子邮箱验证时间',
      'field' => 'email_verified_at',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'password' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '255',
      'sorting' => '6',
      'fixed' => NULL,
      'title' => '密码',
      'field' => 'password',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
    ),
    'user_group' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '250',
      'sorting' => '7',
      'fixed' => NULL,
      'title' => '用户组',
      'field' => 'user_group',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'status' => 
    array (
      'field_type' => 'char',
      'field_length' => '5',
      'sorting' => '8',
      'fixed' => NULL,
      'title' => '账号状态',
      'field' => 'status',
      'field_from' => 'main_table',
      'width' => NULL,
      'read' => 'on',
      'search' => 'on',
    ),
    'login_time' => 
    array (
      'field_type' => 'int',
      'field_length' => '11',
      'sorting' => '9',
      'fixed' => NULL,
      'title' => '登录时间',
      'field' => 'login_time',
      'field_from' => 'main_table',
      'width' => NULL,
      'read' => 'on',
    ),
    'remark' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '100',
      'sorting' => '10',
      'fixed' => NULL,
      'title' => '用户备注',
      'field' => 'remark',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'created_at' => 
    array (
      'field_type' => 'datetime',
      'field_length' => 'no_limit',
      'sorting' => '999',
      'fixed' => NULL,
      'title' => '创建时间',
      'field' => 'created_at',
      'field_from' => 'main_table',
      'width' => NULL,
      'read' => 'on',
    ),
    'updated_at' => 
    array (
      'field_type' => 'datetime',
      'field_length' => 'no_limit',
      'sorting' => '999',
      'fixed' => NULL,
      'title' => '修改时间',
      'field' => 'updated_at',
      'field_from' => 'main_table',
      'width' => NULL,
      'read' => 'on',
    ),
    'deleted_at' => 
    array (
      'field_type' => 'datetime',
      'field_length' => 'no_limit',
      'sorting' => '999',
      'fixed' => NULL,
      'title' => '删除时间',
      'field' => 'deleted_at',
      'field_from' => 'main_table',
      'width' => NULL,
      'read' => 'on',
    ),
  ),
  'head_menu' => 
  array (
    'search' => 
    array (
      'text' => '搜索',
      'icon' => 'layui-icon-search',
      'must' => 'on',
      'width' => '800px',
      'height' => '90%',
      'method' => NULL,
    ),
    'create' => 
    array (
      'text' => '新增',
      'icon' => 'layui-icon-add-1',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'method' => NULL,
    ),
    'update' => 
    array (
      'text' => '修改',
      'icon' => 'layui-icon-edit',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'method' => NULL,
    ),
    'delete' => 
    array (
      'text' => '删除',
      'icon' => 'layui-icon-delete',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => NULL,
    ),
    'recycle' => 
    array (
      'text' => '回收站',
      'icon' => 'layui-icon-fonts-del',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'method' => NULL,
    ),
    'recovery' => 
    array (
      'text' => '数据恢复',
      'icon' => 'layui-icon-prev',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => NULL,
    ),
  ),
  'other_set' => 
  array (
    'limit' => '20',
    'cell_min_width' => '160',
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => '/system/user/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\System\\UserController',
    'method' => 'index',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>