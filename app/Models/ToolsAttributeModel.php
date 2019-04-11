<?php
/**
 * 数据表：tools_attribute
 * 该模型类由DataGrid生成器自动生成，默认载入了Trait代码复用类 Common
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsAttributeModel extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'tools_attribute';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['created_at', 'updated_at', 'deleted_at'];
}
