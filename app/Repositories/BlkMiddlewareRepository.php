<?php
/**
 | 数据表：blk_middleware
 | 该控制器类由 Boolean Lazyer Kit 页面设计器自动生成
 |
 | @auther 		BLK
 | @datetime 	2019-05-04 18:43:39
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlkMiddlewareRepository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'blk_middleware';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}