<?php
/**
 * 数据表：attachment
 * 该模型由Datatable生成器自动生成
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class AttachmentRepository extends Model 
{
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'attachment';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}
