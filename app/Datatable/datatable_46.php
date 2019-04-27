<?php return array (
  'id' => 46,
  'title' => '开发设计',
  'id_prefix' => 'system_',
  'pid' => 29,
  'model' => '5',
  'function_type' => '1',
  'url' => 'lazykit/function_page/index',
  'method' => 'FunctionPageController@index',
  'inheritance' => '22',
  'inheritance_note' => '继承系统管理的列表显示，增加功能按钮',
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
  ),
  'other_set' => 
  array (
    'line_button_area_width' => '305',
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/function_page/',
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
      'method' => 'route@lazykit/function_page/design',
    ),
    'route' => 
    array (
      'text' => '更新路由',
      'style' => 'layui-btn-normal',
      'open_tepe' => 'ajax',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => 'createRoute',
    ),
    'menu' => 
    array (
      'text' => '更新菜单',
      'style' => 'layui-btn-warm',
      'open_tepe' => 'ajax',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => 'createMenu',
    ),
    'permission' => 
    array (
      'text' => '更新授权',
      'style' => 'layui-btn-warm',
      'open_tepe' => 'ajax',
      'must' => 'on',
      'width' => NULL,
      'height' => NULL,
      'method' => 'createPermissions',
    ),
  ),
);?>