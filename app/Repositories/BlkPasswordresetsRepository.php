<?php
/**
 * 数据表：password_resets
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BlkPasswordresetsRepository extends Model 
{
	//表名称
	protected $table = 'blk_password_resets';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}