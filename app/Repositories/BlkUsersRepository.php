<?php
/**
 * 数据表：users
 * 该模型类由Datatable生成器自动生成
 * @auther 		杨鸿<yh15229262120@qq.com>
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BlkUsersRepository extends Authenticatable 
{
	use Notifiable;
	//软删除Trait
	use SoftDeletes;
	//表名称
	protected $table = 'blk_users';
	//主键
	protected $primaryKey = 'id';
	
	protected $datas = ['deleted_at'];
}