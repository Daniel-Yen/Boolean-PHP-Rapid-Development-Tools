<?php return array (
  'id' => 46,
  'title' => '开发设计',
  'pid' => 29,
  'model' => '5',
  'function_type' => '1',
  'url' => 'lazykit/functionpage/index',
  'method' => 'FunctionPageController@index',
  'inheritance' => '45',
  'inheritance_note' => '继承系统管理的列表显示，增加功能按钮',
  'system_id' => '1',
  'main_table' => NULL,
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => NULL,
  'datatable_set' => 
  array (
  ),
  'head_menu' => 
  array (
    'search2' => 
    array (
      'text' => '搜索2',
      'icon' => 'layui-icon-search',
      'must' => 'on',
      'width' => '800px',
      'height' => '90%',
      'method' => NULL,
    ),
  ),
  'other_set' => 
  array (
    'line_button_area_width' => '250',
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/functionpage/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\FunctionPageController',
    'method' => 'index',
  ),
  'new_head_menu' => NULL,
  'line_button' => 
  array (
    'design' => 
    array (
      'text' => '页面设计',
      'style' => 'layui-btn-danger',
      'open_tepe' => 'window',
      'must' => 'on',
      'width' => '100%',
      'height' => '100%',
      'method' => 'route@lazykit/functionpage/design',
    ),
    'route' => 
    array (
      'text' => '生成路由',
      'style' => 'layui-btn-normal',
      'open_tepe' => 'ajax',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => 'createRoute',
    ),
    'menu' => 
    array (
      'text' => '生成菜单',
      'style' => 'layui-btn-warm',
      'open_tepe' => 'ajax',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => 'createMenu',
    ),
  ),
);?>