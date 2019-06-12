<?php
/**
 * 数据表：auto_generate
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoGenerateRepository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'auto_generate';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}