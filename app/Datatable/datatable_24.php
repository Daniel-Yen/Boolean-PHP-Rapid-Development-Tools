<?php return array (
  'id' => 24,
  'title' => 'Datatable树形表格',
  'pid' => 31,
  'model' => 'datatable',
  'url' => '/lazykit/demo/treetable',
  'method' => 'DemoController@treetable',
  'module_id' => '1',
  'main_table' => 'tools_demo_tree',
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
    'id' => 
    array (
      'field_type' => 'int',
      'field_length' => '11',
      'sorting' => '1',
      'fixed' => NULL,
      'title' => 'ID',
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'title' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '50',
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '标题',
      'field' => 'title',
      'field_from' => 'main_table',
      'width' => '400',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'pid' => 
    array (
      'field_type' => 'int',
      'field_length' => '11',
      'sorting' => '3',
      'fixed' => NULL,
      'title' => '父ID',
      'field' => 'pid',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'enable' => 
    array (
      'field_type' => 'char',
      'field_length' => '5',
      'sorting' => '4',
      'fixed' => NULL,
      'title' => '启用',
      'field' => 'enable',
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
    'limit' => '20',
    'cell_min_width' => '160',
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => '/lazykit/demo/',
    'route_name' => 'treetable',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\DemoController',
    'method' => 'treetable',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>