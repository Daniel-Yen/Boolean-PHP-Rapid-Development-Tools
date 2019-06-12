<?php
/**
 | 数据表：middleware
 | 该控制器类由 Boolean Lazyer Kit 页面设计器自动生成
 |
 | @auther 		Boolean-PHP-Rapid-Development-Tools
 | @datetime 	2019-05-04 18:43:39
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MiddlewareRepository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'middleware';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}