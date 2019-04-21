<?php return array (
  'id' => 22,
  'title' => 'Datatable自定义字段',
  'id_prefix' => 'diy_',
  'pid' => 31,
  'model' => '2',
  'function_type' => '1',
  'url' => 'lazykit/demo/external',
  'method' => 'DemoController@external',
  'inheritance' => NULL,
  'inheritance_note' => NULL,
  'main_table' => NULL,
  'associated_type' => NULL,
  'associated_table' => NULL,
  'external_field' => 'field_1,field_2,field_3,field_4,field_5',
  'datatable_set' => 
  array (
    'field_1' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '1',
      'fixed' => 'left',
      'title' => '自定义字段1',
      'field' => 'field_1',
      'field_from' => 'external_field',
      'width' => NULL,
      'read' => 'on',
      'attribute' => 
      array (
        'sort' => 'on',
        'window_title' => 'on',
        'url_type' => 'window',
        'url' => '',
        'cell_style_template' => '',
        'verify' => '',
      ),
    ),
    'field_2' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '2',
      'fixed' => NULL,
      'title' => '自定义字段2',
      'field' => 'field_2',
      'field_from' => 'external_field',
      'width' => NULL,
      'read' => 'on',
      'attribute' => NULL,
    ),
    'field_3' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '3',
      'fixed' => NULL,
      'title' => '自定义字段3',
      'field' => 'field_3',
      'field_from' => 'external_field',
      'width' => NULL,
      'read' => 'on',
      'attribute' => NULL,
    ),
    'field_4' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '4',
      'fixed' => NULL,
      'title' => '自定义字段4',
      'field' => 'field_4',
      'field_from' => 'external_field',
      'width' => '100',
      'read' => 'on',
      'attribute' => NULL,
    ),
    'field_5' => 
    array (
      'field_type' => NULL,
      'field_length' => NULL,
      'sorting' => '5',
      'fixed' => NULL,
      'title' => '自定义字段5',
      'field' => 'field_5',
      'field_from' => 'external_field',
      'width' => NULL,
      'read' => 'on',
      'attribute' => NULL,
    ),
  ),
  'head_menu' => 
  array (
    'search2' => 
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
    'line_button_area_width' => '160',
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/demo/',
    'route_name' => 'external',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\DemoController',
    'method' => 'external',
  ),
  'new_head_menu' => NULL,
  'line_button' => NULL,
);?>