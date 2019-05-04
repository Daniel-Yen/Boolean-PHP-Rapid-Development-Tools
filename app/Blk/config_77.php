<?php return array (
  'id' => 77,
  'title' => '多个配置文件',
  'url' => 'lazykit/config/index',
  'method' => 'ConfigController@index',
  'config_set' => 
  array (
    'site' => 
    array (
      'name' => '站点配置',
      'tag' => 'site',
      'describe' => '打分撒地方撒地方撒地方撒地方',
      'fields' => 
      array (
        'tttt' => 
        array (
          'field' => 'tttt',
          'title' => '方式的说法',
          'sorting' => 0,
          'width' => '0',
          'instructions' => '撒地方撒地方撒地方',
          'attribute' => 
          array (
            'data_input_form' => 'select',
            'data_source_type' => 'method',
            'data_source' => 'attributeMiddleware',
            'validate' => NULL,
          ),
        ),
        'r' => 
        array (
          'field' => 'r',
          'title' => '打分',
          'sorting' => 0,
          'width' => '0',
          'instructions' => NULL,
          'attribute' => 
          array (
            'data_input_form' => 'textarea',
            'data_source_type' => 'method',
            'data_source' => NULL,
            'validate' => NULL,
          ),
        ),
        'uuu' => 
        array (
          'field' => 'uuu',
          'title' => '是否达到',
          'sorting' => 0,
          'width' => '0',
          'instructions' => NULL,
          'attribute' => NULL,
        ),
        'yyyyyyy' => 
        array (
          'field' => 'yyyyyyy',
          'title' => '撒地方',
          'sorting' => '5',
          'width' => '5',
          'instructions' => '撒地方是否撒地方',
          'attribute' => NULL,
        ),
        'rrrr' => 
        array (
          'field' => 'rrrr',
          'title' => '第三方',
          'sorting' => '7',
          'width' => '7',
          'instructions' => '是否打分',
          'attribute' => NULL,
        ),
        'werwe' => 
        array (
          'field' => 'werwe',
          'title' => '我违反为',
          'sorting' => '8',
          'width' => '8',
          'instructions' => '玩儿玩儿玩儿',
          'attribute' => NULL,
        ),
      ),
    ),
    'file' => 
    array (
      'name' => '附件设置',
      'tag' => 'file',
      'describe' => '系统附件属性设置',
      'fields' => 
      array (
        'type' => 
        array (
          'field' => 'type',
          'title' => '附件类型',
          'sorting' => 0,
          'width' => '0',
          'instructions' => NULL,
          'attribute' => NULL,
        ),
        'size' => 
        array (
          'field' => 'size',
          'title' => '附件大小',
          'sorting' => 0,
          'width' => '0',
          'instructions' => NULL,
          'attribute' => NULL,
        ),
        'ext' => 
        array (
          'field' => 'ext',
          'title' => '文件后缀',
          'sorting' => 0,
          'width' => '0',
          'instructions' => '请填写支持上传的文件后缀（jpg,png,rar）',
          'attribute' => NULL,
        ),
      ),
    ),
  ),
  'route' => 
  array (
    'route_path' => 'lazykit/config/',
    'route_name' => 'index',
    'controller' => 'App\\Http\\Controllers\\Lazykit\\ConfigController',
    'method' => 'index',
  ),
);?>