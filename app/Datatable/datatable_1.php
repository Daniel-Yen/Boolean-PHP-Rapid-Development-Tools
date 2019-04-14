<?php return array (
  'id' => 1,
  'title' => '菜单管理',
  'pid' => 29,
  'model' => '2',
  'url' => '/lazykit/datatable/index',
  'method' => 'DatatableController@index',
  'module_id' => '1',
  'main_table' => 'blk_datatable',
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
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
    'route_path' => '/lazykit/datatable/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\DatatableController',
    'method' => 'index',
  ),
  'directory' => 
  array (
    'has' => 'on',
    'method' => 'App\\Http\\Controllers\\Lazykit\\DatatableController->leftDirectory',
    'associated_field' => NULL,
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