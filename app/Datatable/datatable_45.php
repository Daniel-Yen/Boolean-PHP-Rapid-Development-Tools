<?php return array (
  'id' => 45,
  'title' => '系统管理',
  'pid' => 29,
  'model' => '2',
  'url' => 'lazykit/system/index',
  'method' => 'SystemController@index',
  'module_id' => '1',
  'main_table' => 'blk_system',
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
    'id' => 
    array (
      'field_type' => 'int',
      'field_length' => '11',
      'sorting' => NULL,
      'fixed' => NULL,
      'title' => NULL,
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => NULL,
    ),
    'system_name' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '50',
      'sorting' => '1',
      'fixed' => NULL,
      'title' => '系统名称',
      'field' => 'system_name',
      'field_from' => 'main_table',
      'width' => NULL,
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'file_path' => 
    array (
      'field_type' => 'varchar',
      'field_length' => '50',
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '所在文件夹',
      'field' => 'file_path',
      'field_from' => 'main_table',
      'width' => '400',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'remark' => 
    array (
      'field_type' => 'text',
      'field_length' => 'no_limit',
      'sorting' => '3',
      'fixed' => NULL,
      'title' => '备注',
      'field' => 'remark',
      'field_from' => 'main_table',
      'width' => '800',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'created_at' => 
    array (
      'field_type' => 'datetime',
      'field_length' => 'no_limit',
      'sorting' => '4',
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
      'sorting' => '5',
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
      'sorting' => '6',
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
  ),
  'other_set' => 
  array (
    'limit' => '20',
    'cell_min_width' => '160',
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/system/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\SystemController',
    'method' => 'index',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>