<?php return array (
  'id' => 23,
  'title' => '系统信息',
  'pid' => 32,
  'model' => 'datatable',
  'url' => '/lazykit/environment/server',
  'method' => 'EnvironmentController@server',
  'module_id' => '1',
  'main_table' => '',
  'associated_type' => '',
  'associated_table' => '',
  'external_field' => 'set,key',
  'datatable_set' => 
  array (
    'set' => 
    array (
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
    'limit' => '20',
    'cell_min_width' => '160',
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => '/lazykit/environment/',
    'route_name' => 'server',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\EnvironmentController',
    'method' => 'server',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>