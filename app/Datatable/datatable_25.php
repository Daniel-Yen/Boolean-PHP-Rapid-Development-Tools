<?php return array (
  'id' => 25,
  'config_name' => '菜单管理',
  'main_table' => 'tools_menu',
  'associated_type' => '',
  'associated_table' => '',
  'external_field' => '',
  'create_time' => NULL,
  'update_time' => NULL,
  'delete_time' => 0,
  'datatable_set' => 
  array (
    'id' => 
    array (
      'sorting' => '',
      'fixed' => '',
      'title' => '',
      'field' => 'id',
      'field_from' => 'main_table',
      'width' => '',
    ),
    'title' => 
    array (
      'sorting' => '1',
      'fixed' => 'left',
      'title' => '标题',
      'field' => 'title',
      'field_from' => 'main_table',
      'width' => '',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
      'search' => 'on',
    ),
    'pid' => 
    array (
      'sorting' => '2',
      'fixed' => '',
      'title' => '父ID',
      'field' => 'pid',
      'field_from' => 'main_table',
      'width' => '',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'enable' => 
    array (
      'sorting' => '3',
      'fixed' => '',
      'title' => '启用',
      'field' => 'enable',
      'field_from' => 'main_table',
      'width' => '',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'module' => 
    array (
      'sorting' => '4',
      'fixed' => '',
      'title' => '模型',
      'field' => 'module',
      'field_from' => 'main_table',
      'width' => '',
      'create' => 'on',
      'update' => 'on',
      'read' => 'on',
    ),
    'url' => 
    array (
      'sorting' => '5',
      'fixed' => '',
      'title' => '链接',
      'field' => 'url',
      'field_from' => 'main_table',
      'width' => '300',
      'create' => 'on',
      'update' => 'on',
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