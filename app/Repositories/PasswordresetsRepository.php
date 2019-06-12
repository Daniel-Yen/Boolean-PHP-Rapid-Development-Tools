<?php
/**
 * 数据表：password_resets
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class PasswordresetsRepository extends Model 
{
	//表名称
	protected $table = 'password_resets';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}