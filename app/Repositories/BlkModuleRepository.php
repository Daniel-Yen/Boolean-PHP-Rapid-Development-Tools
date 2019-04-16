<?php
/**
 * 数据表：blk_module
 * 该模型由Datatable生成器自动生成
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlkModuleRepository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'blk_module';
	//主键
	protected $primaryKey = 'id';
	
    protected $datas = ['deleted_at'];
}