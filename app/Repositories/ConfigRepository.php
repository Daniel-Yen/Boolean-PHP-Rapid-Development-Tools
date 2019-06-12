<?php
/**
 * 数据表：config
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigRepository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'config';
	//主键
	protected $primaryKey = 'id';
}