<?php
/**
 * 数据表：table_name
 * 该模型类由Datatable生成器自动生成
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewModel extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'table_name';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}