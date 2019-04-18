<?php return array (
  'id' => 1,
  'title' => '菜单管理',
  'pid' => 29,
  'model' => '2',
  'url' => 'lazykit/menu/index',
  'method' => 'MenuController@index',
  'module_id' => '1/1',
  'main_table' => 'blk_menu',
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
    'associated_type' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '15',
      'sorting' => NULL,
      'fixed' => NULL,
      'title' => '关联类型',
      'field' => 'associated_type',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'main_table' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '30',
      'sorting' => NULL,
      'fixed' => NULL,
      'title' => '主表',
      'field' => 'main_table',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'associated_table' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '30',
      'sorting' => NULL,
      'fixed' => NULL,
      'title' => '关联表',
      'field' => 'associated_table',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'external_field' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '250',
      'sorting' => NULL,
      'fixed' => NULL,
      'title' => '自定义字段',
      'field' => 'external_field',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'id' => 
    array (
      'field_type' => 'int',
      'field_length' => '11',
      'sorting' => '0',
      'fixed' => NULL,
      'title' => 'ID',
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => '80',
      'read' => 'on',
    ),
    'title' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '40',
      'sorting' => '1',
      'fixed' => 'left',
      'title' => '菜单名称',
      'field' => 'title',
      'field_from' => 'main_table',
      'width' => '220',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'pid' => 
    array (
      'field_type' => 'int',
      'field_length' => '11',
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '父ID',
      'field' => 'pid',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
    ),
    'model' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '20',
      'sorting' => '3',
      'fixed' => NULL,
      'title' => '菜单模型',
      'field' => 'model',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'url' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '50',
      'sorting' => '4',
      'fixed' => NULL,
      'title' => 'URL',
      'field' => 'url',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'method' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '200',
      'sorting' => '5',
      'fixed' => NULL,
      'title' => '处理方法',
      'field' => 'method',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'module_id' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '20',
      'sorting' => '6',
      'fixed' => NULL,
      'title' => '所属系统 / 模块',
      'field' => 'module_id',
      'field_from' => 'main_table',
      'width' => '350',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
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
    'is_tree' => 'on',
    'limit' => '90',
    'cell_min_width' => '160',
    'line_button_area_width' => '90',
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/menu/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\MenuController',
    'method' => 'index',
  ),
  'directory' => 
  array (
    'has' => 'on',
    'method' => 'App\\Http\\Controllers\\Lazykit\\MenuController->leftDirectory',
    'associated_field' => 'module_id',
    'width' => '200',
  ),
  'new_head_menu' => 
  array (
    'route' => 
    array (
      'text' => '生成路由',
      'icon' => NULL,
      'open_tepe' => 'ajax',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => 'createRoute',
    ),
    'window' => 
    array (
      'text' => '弹窗测试',
      'icon' => NULL,
      'open_tepe' => 'window',
      'width' => '90%',
      'height' => '90%',
      'method' => 'window',
    ),
  ),
  'line_button' => 
  array (
    'set' => 
    array (
      'text' => '生成配置',
      'style' => 'layui-btn-danger',
      'open_tepe' => 'window',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'method' => 'set',
    ),
  ),
);?>