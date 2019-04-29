<?php return array (
  'id' => 41,
  'title' => '系统信息',
  'id_prefix' => 'env_',
  'pid' => 44,
  'model' => '2',
  'function_type' => '1',
  'url' => 'lazykit/environment/server',
  'method' => 'EnvironmentController@server',
  'inheritance' => NULL,
  'inheritance_note' => NULL,
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
      'fixed' => '0',
      'title' => '运行环境属性',
      'field' => 'set',
      'field_from' => 'external_field',
      'width' => '180',
      'read' => 'on',
      'search' => '0',
      'attribute' => NULL,
    ),
    'key' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '2',
      'fixed' => '0',
      'title' => '当前值',
      'field' => 'key',
      'field_from' => 'external_field',
      'width' => '600',
      'read' => 'on',
      'search' => '0',
      'attribute' => NULL,
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
  ),
  'other_set' => 
  array (
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/environment/',
    'route_name' => 'server',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\EnvironmentController',
    'method' => 'server',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>