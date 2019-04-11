<?php
/**
 * 数据增删改查的Trait，每个DataGrid生成的数据表模型（model）均use Trait
 * Trait 和 Class 相似，但不可以实例化，可以将Trait理解为方法集合，可以用use将Trait插入需要这些方法的类中。
 * 导入类的Trait中的方法可以被该类当做自己的方法一样调用
 * @auther 		杨鸿<yh15229262120@qq.com>
 */
namespace App\Models;

trait Common 
{
	/**
	 * 日期转时间戳
	 * @access    public
	 * @author    杨鸿<yh15229262120@qq.com> 
	 * @param     string        	$value 		日期或者时间戳
	 * @return    string 						时间戳
	 */
	public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = is_int($value) ? $value : strtotime($value);
    }
 
    public function getStartTimeAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['start_time']);
    }
}