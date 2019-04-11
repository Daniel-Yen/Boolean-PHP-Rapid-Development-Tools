<?php
/**
 * 功能名称：{menu_title}
 * 该控制器类由Datatable生成器自动生成
 * @auther 		Buer Lazykit
 */

namespace App\Http\Controllers\{module};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class {NewController} extends Controller
{
    /**
     * {menu_title}
     * @access    	public
     * @author    	Buer Lazykit
     */
    public function {method}(Request $request)
    {
    	create_datatable('datatable_{id}', [], $request);
    }
}