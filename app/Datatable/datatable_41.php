<?php return array (
  'id' => 41,
  'title' => '系统信息',
  'pid' => 40,
  'model' => 'datatable',
  'url' => '/system/environment/server',
  'method' => 'EnvironmentController@server',
  'module_id' => '2',
  'main_table' => NULL,
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => 'set,key',
  'datatable_set' => 
  array (
    'set' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '1',
      'fixed' => NULL,
      'title' => '运行环境属性',
      'field' => 'set',
      'field_from' => 'external_field',
      'width' => '180',
      'read' => 'on',
    ),
    'key' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '当前值',
      'field' => 'key',
      'field_from' => 'external_field',
      'width' => '600',
      'read' => 'on',
    ),
  ),
  'head_menu' => 
  array (
    'search2' => 
    array (
      'text' => '搜索2',
      'icon' => 'layui-icon-search',
      'width' => '800px',
      'height' => '90%',
      'method' => NULL,
    ),
  ),
  'other_set' => 
  array (
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => '/system/environment/',
    'route_name' => 'server',
    'controller' => 'App\\Http\\Controllers\\System\\EnvironmentController',
    'method' => 'server',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>