<?php return array (
  'id' => 24,
  'config_name' => 'DataGrid样例：树形表格',
  'main_table' => 'tools_treegrid',
  'associated_type' => '',
  'associated_table' => '',
  'external_field' => '',
  'create_time' => NULL,
  'update_time' => NULL,
  'delete_time' => 0,
  'datatable_set' => 
  array (
    'pid' => 
    array (
      'sorting' => '',
      'fixed' => '',
      'title' => '父ID',
      'field' => 'pid',
      'field_from' => 'main_table',
      'width' => '',
    ),
    'id' => 
    array (
      'sorting' => '1',
      'fixed' => '',
      'title' => 'ID',
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => '',
      'read' => 'on',
    ),
    'title' => 
    array (
      'sorting' => '1',
      'fixed' => '',
      'title' => '标题',
      'field' => 'title',
      'field_from' => 'main_table',
      'width' => '400',
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
      'note' => '',
    ),
    'create' => 
    array (
      'text' => '新增',
      'icon' => 'layui-icon-add-1',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'note' => '',
    ),
    'update' => 
    array (
      'text' => '修改',
      'icon' => 'layui-icon-edit',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'note' => '',
    ),
    'delete' => 
    array (
      'text' => '删除',
      'icon' => 'layui-icon-delete',
      'must' => 'on',
      'width' => '',
      'height' => '',
      'note' => '',
    ),
  ),
  'other_set' => 
  array (
    'is_tree' => 'on',
    'limit' => '20',
    'cell_min_width' => '80',
  ),
);?>