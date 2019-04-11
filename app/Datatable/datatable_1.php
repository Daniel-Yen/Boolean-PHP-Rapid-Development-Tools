<?php return array (
  'id' => 1,
  'title' => '菜单管理',
  'pid' => 29,
  'model' => 'datatable',
  'url' => '/lazykit/datatable/index',
  'method' => 'DatatableController@index',
  'module_id' => '1',
  'main_table' => 'tools_datatable',
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
    'id' => 
    array (
      'sorting' => '0',
      'fixed' => 'left',
      'title' => '编号',
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => '60',
      'read' => 'on',
    ),
    'title' => 
    array (
      'sorting' => '1',
      'fixed' => 'left',
      'title' => '菜单名称',
      'field' => 'title',
      'field_from' => 'main_table',
      'width' => '200',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'pid' => 
    array (
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '上级菜单',
      'field' => 'pid',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'search' => 'on',
    ),
    'url' => 
    array (
      'sorting' => '3',
      'fixed' => NULL,
      'title' => '命名路由',
      'field' => 'url',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'method' => 
    array (
      'sorting' => '4',
      'fixed' => NULL,
      'title' => '处理方法',
      'field' => 'method',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'model' => 
    array (
      'sorting' => '5',
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
    'module_id' => 
    array (
      'sorting' => '6',
      'fixed' => NULL,
      'title' => '所属模块',
      'field' => 'module_id',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'main_table' => 
    array (
      'sorting' => '15',
      'fixed' => NULL,
      'title' => '主表',
      'field' => 'main_table',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'associated_type' => 
    array (
      'sorting' => '16',
      'fixed' => NULL,
      'title' => '关联类型',
      'field' => 'associated_type',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'associated_table' => 
    array (
      'sorting' => '17',
      'fixed' => NULL,
      'title' => '关联表',
      'field' => 'associated_table',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'external_field' => 
    array (
      'sorting' => '18',
      'fixed' => NULL,
      'title' => '自定义字段',
      'field' => 'external_field',
      'field_from' => 'main_table',
      'width' => '600',
    ),
    'created_at' => 
    array (
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
    'route_path' => '/lazykit/datatable/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\DatatableController',
    'method' => 'index',
  ),
  'directory' => 
  array (
    'has' => 'on',
    'method' => 'App\\Http\\Controllers\\Lazykit\\DatatableController->leftDirectory',
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
      'must' => 'on',
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
      'style' => 'layui-btn-normal',
      'open_tepe' => 'window',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'method' => 'set',
    ),
  ),
);?>