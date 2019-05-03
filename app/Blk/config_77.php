<?php return array (
  'id' => 77,
  'title' => '单个配置文件',
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
          'width' => '100%',
          'instructions' => '撒地方撒地方撒地方',
        ),
        'r' => 
        array (
          'field' => 'r',
          'title' => '打分',
          'sorting' => 0,
          'width' => '100%',
          'instructions' => NULL,
        ),
        'uuu' => 
        array (
          'field' => 'uuu',
          'title' => '是否达到',
          'sorting' => 0,
          'width' => '100%',
          'instructions' => NULL,
        ),
        'yyyyyyy' => 
        array (
          'field' => 'yyyyyyy',
          'title' => '撒地方',
          'sorting' => '5',
          'width' => '5',
          'instructions' => '撒地方是否撒地方',
        ),
        'rrrr' => 
        array (
          'field' => 'rrrr',
          'title' => '第三方',
          'sorting' => '7',
          'width' => '7',
          'instructions' => '是否打分',
        ),
        'werwe' => 
        array (
          'field' => 'werwe',
          'title' => '我违反为',
          'sorting' => '8',
          'width' => '8',
          'instructions' => '玩儿玩儿玩儿',
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
          'width' => '100%',
          'instructions' => NULL,
        ),
        'size' => 
        array (
          'field' => 'size',
          'title' => '附件大小',
          'sorting' => 0,
          'width' => '100%',
          'instructions' => NULL,
        ),
        'ext' => 
        array (
          'field' => 'ext',
          'title' => '文件后缀',
          'sorting' => 0,
          'width' => '100%',
          'instructions' => '请填写支持上传的文件后缀（jpg,png,rar）',
        ),
      ),
    ),
  ),
);?>